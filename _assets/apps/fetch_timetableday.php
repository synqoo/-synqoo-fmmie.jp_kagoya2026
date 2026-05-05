<?php
/**
 * 日次番組表XMLを取得して保存するスクリプト
 * コマンドラインまたはWebブラウザから実行可能
 */

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

$today = date('Y-n-j');
$today2 = date('Ymd');
$xmlUrl = 'https://program.jfn-rapt.jp/xml/nu/'.$today2.'.xml';
$outDir = __DIR__ . '/../../timetables/_xml/';
$outfile = $outDir . $today . '.xml';

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

// XMLファイルを取得
$xml = @file_get_contents($xmlUrl);
if ($xml === false) {
    $error = "XMLファイルの取得に失敗しました: " . $xmlUrl;
    if (php_sapi_name() === 'cli') {
        echo $error . "\n";
    } else {
        http_response_code(500);
        echo $error;
    }
    exit(1);
}

// ファイルに書き込み
$fp = @fopen($outfile, 'w');
if ($fp === false) {
    $error = "ファイルの書き込みに失敗しました: " . $outfile;
    if (php_sapi_name() === 'cli') {
        echo $error . "\n";
    } else {
        http_response_code(500);
        echo $error;
    }
    exit(1);
}

fwrite($fp, $xml);
fclose($fp);

// 成功メッセージ
$success = "XMLファイルを保存しました: " . $today . ".xml (取得元: " . $today2 . ")";
if (php_sapi_name() === 'cli') {
    echo $success . "\n";
} else {
    echo $success;
}
exit(0);
?>