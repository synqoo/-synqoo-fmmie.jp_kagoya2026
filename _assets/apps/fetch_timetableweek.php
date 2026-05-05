<?php
/**
 * 週次番組表XMLを取得して保存するスクリプト
 * コマンドラインまたはWebブラウザから実行可能
 * 今日から7日分のXMLを取得し、曜日ごとに保存
 */

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// 起点日：放送上の「今日」を使う。
// 放送上の1日は朝5:00〜翌朝4:59のため、実時刻が 0:00〜4:59 のときは前日を起点にする。
// これを行わないと、深夜帯に cron が走った場合に「まだ放送中の前日分の曜日XML」が
// 翌週の同曜日データで上書きされる事故が起きる（例：水03:10に走ると 2.xml が
// 火曜深夜放送中なのに翌火曜=20260512のデータで上書きされる）。
$nowH    = (int)date('H');
$baseTs  = ($nowH < 5) ? strtotime('-1 day') : time();
$today   = date('Y-n-j', $baseTs);
$outDir  = __DIR__ . '/../../timetables/_xml/week/';
$messages = [];
$successCount = 0;
$errorCount = 0;

// 出力ディレクトリが存在しない場合は作成
if (!is_dir($outDir)) {
    if (!mkdir($outDir, 0755, true)) {
        $error = "ディレクトリの作成に失敗しました: " . $outDir;
        if (php_sapi_name() === 'cli') {
            echo $error . "\n";
        } else {
            http_response_code(500);
            echo $error;
        }
        exit(1);
    }
}

// 7日分のXMLを取得
for ($i = 0; $i < 7; $i++) {
    $daynum = date('Ymd', strtotime($today . " +" . $i . " days"));
    $weeknum = date('w', strtotime($today . " +" . $i . " days")); // 0=日曜, 6=土曜
    $xmlUrl = 'https://program.jfn-rapt.jp/xml/nu/' . $daynum . '.xml';
    $outfile = $outDir . $weeknum . '.xml';
    
    // XMLファイルを取得（最大3回リトライ）
    $xml = false;
    $retryCount = 0;
    $maxRetries = 3;
    
    while ($retryCount < $maxRetries && $xml === false) {
        $xml = @file_get_contents($xmlUrl);
        
        if ($xml === false || $xml === '') {
            $retryCount++;
            if ($retryCount < $maxRetries) {
                sleep(1); // リトライ前に1秒待機
            }
        }
    }
    
    if ($xml === false || $xml === '') {
        $errorCount++;
        $messages[] = "エラー: " . $daynum . ".xml の取得に失敗しました（" . $weeknum . "曜日）";
        continue;
    }
    
    // ファイルに書き込み
    $fp = @fopen($outfile, 'w');
    if ($fp === false) {
        $errorCount++;
        $messages[] = "エラー: " . $outfile . " の書き込みに失敗しました";
        continue;
    }
    
    fwrite($fp, $xml);
    fclose($fp);
    $successCount++;
    $messages[] = "成功: " . $daynum . ".xml を " . $weeknum . "曜日として保存しました";
}

// 結果を出力
$result = "処理完了: 成功 " . $successCount . "件、失敗 " . $errorCount . "件\n";
$result .= implode("\n", $messages);

if (php_sapi_name() === 'cli') {
    echo $result . "\n";
} else {
    echo "<pre>" . htmlspecialchars($result, ENT_QUOTES, 'UTF-8') . "</pre>";
}

exit($errorCount > 0 ? 1 : 0);
?>