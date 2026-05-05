<?php
/**
 * 放送楽曲リスト蓄積スクリプト
 * NOA (https://noa.jfn.co.jp/noa/nu.xml) のXMLを1分毎に取得し、
 * - 取得した最新XMLを now.xml として上書き保存（サイト参照用）
 * - 内容が更新されていたら当日の played XML に追記する。
 *
 * 実行: 1分毎に cron で発行する想定
 * 例: * * * * * php /path/to/_assets/apps/fetch_nowplay.php
 */

date_default_timezone_set('Asia/Tokyo');

$xmlUrl = 'https://noa.jfn.co.jp/noa/nu.xml';
$baseDir = dirname(__DIR__);
$playedDir = $baseDir . '/xml/played';
$today = date('Y-m-d');
$playedFile = $playedDir . '/' . $today . '-played.xml';

// 出力ディレクトリが無ければ作成
if (!is_dir($playedDir)) {
    if (!mkdir($playedDir, 0755, true)) {
        logExit("ディレクトリの作成に失敗しました: {$playedDir}", 1);
    }
}

// XML取得（User-Agent をブラウザ相当にしないと HTML が返るサーバーあり）
$headers = "User-Agent: Mozilla/5.0 (compatible; MSIE 11.0; Windows NT 10.0; Win64; x64)\r\nAccept: application/xml, text/xml, */*\r\n";
$context = stream_context_create([
    'http' => [
        'timeout' => 5,
        'ignore_errors' => true,
        'header' => $headers,
    ],
    'ssl' => [
        'verify_peer' => true,
        'verify_peer_name' => true,
    ],
]);

$xmlContent = @file_get_contents($xmlUrl, false, $context);
if ($xmlContent === false || $xmlContent === '') {
    $contextInsecure = stream_context_create([
        'http' => [
            'timeout' => 5,
            'ignore_errors' => true,
            'header' => $headers,
        ],
        'ssl' => ['verify_peer' => false, 'verify_peer_name' => false],
    ]);
    $xmlContent = @file_get_contents($xmlUrl, false, $contextInsecure);
}
if ($xmlContent === false || $xmlContent === '') {
    $err = error_get_last();
    $msg = 'nu.xml の取得に失敗しました';
    if ($err && isset($err['message'])) {
        $msg .= ' (' . $err['message'] . ')';
    }
    logExit($msg, 0);
}

libxml_use_internal_errors(true);
$xmlContent = trim($xmlContent);
// BOM 除去
if (substr($xmlContent, 0, 3) === "\xEF\xBB\xBF") {
    $xmlContent = substr($xmlContent, 3);
}
$xml = @simplexml_load_string($xmlContent);
if ($xml === false) {
    logExit('nu.xml のパースに失敗しました', 0);
}

// HTML が返っている場合は User-Agent を変えて再取得（1回だけ）
if (strtolower((string)$xml->getName()) === 'html') {
    $headers2 = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36\r\nAccept: application/xml, text/xml, */*\r\n";
    $contextRetry = stream_context_create([
        'http' => ['timeout' => 5, 'ignore_errors' => true, 'header' => $headers2],
        'ssl' => ['verify_peer' => false, 'verify_peer_name' => false],
    ]);
    $xmlContent = @file_get_contents($xmlUrl, false, $contextRetry);
    if ($xmlContent !== false && $xmlContent !== '') {
        $xmlContent = trim($xmlContent);
        if (substr($xmlContent, 0, 3) === "\xEF\xBB\xBF") {
            $xmlContent = substr($xmlContent, 3);
        }
        $xml = @simplexml_load_string($xmlContent);
    }
    if ($xml === false || strtolower((string)$xml->getName()) === 'html') {
        logExit('nu.xml の取得先が HTML を返しています。URL・アクセス元の制限を確認してください。', 0);
    }
}

// ルート直下の music（名前空間・構造の違いに対応）
$music = $xml->music ?? null;
if ($music === null) {
    $ns = $xml->getNamespaces(true);
    if (!empty($ns)) {
        $uri = isset($ns['']) ? $ns[''] : reset($ns);
        $music = $xml->children($uri)->music ?? null;
    }
}
if ($music === null) {
    // ルートの直下の最初の子要素を music として扱う（NOA は <onairsong><music> のみ）
    $children = $xml->children();
    if (count($children) > 0) {
        $first = $children[0];
        $music = (strtolower((string)$first->getName()) === 'music') ? $first : null;
    }
}
if (!$music || (!isset($music->onair_time) && !isset($music['onair_time']))) {
    $rootName = $xml->getName();
    logExit('楽曲情報がありません (ルート要素: ' . ($rootName !== '' ? $rootName : '不明') . ')', 0);
}

// onair_time: 子要素優先、無ければ属性
$currentOnairTime = trim((string)($music->onair_time ?? $music['onair_time'] ?? ''));
if ($currentOnairTime === '') {
    logExit('onair_time が空です', 0);
}

// 最新XMLを now.xml として上書き（サイト参照用）
$xmlDir = $baseDir . '/xml';
if (!is_dir($xmlDir)) {
    @mkdir($xmlDir, 0755, true);
}
$nowXmlFile = $xmlDir . '/now.xml';
if (@file_put_contents($nowXmlFile, $xmlContent) === false) {
    logExit("now.xml の書き出しに失敗しました: {$nowXmlFile}", 1);
}

// 既に同じ onair_time を記録済みなら追記しない
$lastRecordedTime = getLastRecordedOnairTime($playedFile);
if ($lastRecordedTime !== null && $lastRecordedTime === $currentOnairTime) {
    logExit('更新なし（同一楽曲）', 0);
}

// music ノードをXML文字列として取得（改行・空白は整形）
$musicXml = trim($music->asXML());
$musicXml = "  " . str_replace("\n", "\n  ", $musicXml) . "\n";

// 追記
$lockFile = $playedFile . '.lock';
$fp = fopen($lockFile, 'c');
if ($fp === false) {
    logExit("ロックファイルの作成に失敗しました: {$lockFile}", 1);
}
if (!flock($fp, LOCK_EX)) {
    fclose($fp);
    logExit('ファイルのロックに失敗しました', 1);
}

if (!file_exists($playedFile) || filesize($playedFile) === 0) {
    $header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<played date=\"{$today}\">\n";
    $footer = "</played>\n";
    $content = $header . $musicXml . $footer;
    $written = @file_put_contents($playedFile, $content) !== false;
} else {
    $content = file_get_contents($playedFile);
    if ($content === false) {
        flock($fp, LOCK_UN);
        fclose($fp);
        logExit('既存ファイルの読み込みに失敗しました', 1);
    }
    $closing = '</played>';
    $pos = strrpos($content, $closing);
    if ($pos === false) {
        flock($fp, LOCK_UN);
        fclose($fp);
        logExit('played ファイルの形式が不正です', 1);
    }
    $content = substr($content, 0, $pos) . $musicXml . $closing . "\n";
    $written = @file_put_contents($playedFile, $content) !== false;
}

flock($fp, LOCK_UN);
fclose($fp);
@unlink($lockFile);

if (!$written) {
    logExit('played ファイルへの書き込みに失敗しました', 1);
}

logExit("追記しました: {$currentOnairTime}", 0);

/**
 * 既存の played ファイルから最後に記録した onair_time を取得
 * @param string $playedFile
 * @return string|null
 */
function getLastRecordedOnairTime($playedFile) {
    if (!file_exists($playedFile) || filesize($playedFile) === 0) {
        return null;
    }
    $content = @file_get_contents($playedFile);
    if ($content === false) {
        return null;
    }
    $xml = @simplexml_load_string($content);
    if ($xml === false) {
        return null;
    }
    $list = $xml->music;
    if ($list === null) {
        return null;
    }
    $last = null;
    foreach ($list as $m) {
        $last = $m;
    }
    if ($last === null) {
        return null;
    }
    $t = isset($last->onair_time) ? trim((string)$last->onair_time) : '';
    return $t !== '' ? $t : null;
}

/**
 * ログ出力して終了
 * @param string $message
 * @param int $code
 */
function logExit($message, $code) {
    $line = date('Y-m-d H:i:s') . ' ' . $message . "\n";
    if (php_sapi_name() === 'cli') {
        echo $line;
    } else {
        error_log(trim($line));
        // ブラウザ実行時も結果を表示（空欄にならないように）
        header('Content-Type: text/plain; charset=UTF-8');
        echo $code === 0 ? "OK: " : "Error: ";
        echo $message;
    }
    exit($code);
}
