<?php
/**
 * DOCXファイルを読み取ってHTMLに変換する関数
 * 
 * @param string $docxPath DOCXファイルのパス
 * @return string HTML形式のコンテンツ
 */
function parseDocxToHtml($docxPath) {
    if (!file_exists($docxPath)) {
        return '<p class="error">DOCXファイルが見つかりません: ' . h($docxPath) . '</p>';
    }
    
    // ZIPアーカイブとして開く
    $zip = new ZipArchive();
    if ($zip->open($docxPath) !== TRUE) {
        return '<p class="error">DOCXファイルを開けませんでした。</p>';
    }
    
    // word/document.xmlを読み取る
    $documentXml = $zip->getFromName('word/document.xml');
    if ($documentXml === false) {
        $zip->close();
        return '<p class="error">DOCXファイルの内容を読み取れませんでした。</p>';
    }
    
    $zip->close();
    
    // XMLをパース
    libxml_use_internal_errors(true);
    $xml = simplexml_load_string($documentXml);
    if ($xml === false) {
        $errors = libxml_get_errors();
        libxml_clear_errors();
        return '<p class="error">XMLの解析に失敗しました。</p>';
    }
    
    // Wordの名前空間を定義
    $xml->registerXPathNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
    
    // 段落を取得
    $paragraphs = $xml->xpath('//w:p');
    
    $html = '';
    foreach ($paragraphs as $paragraph) {
        $paragraph->registerXPathNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        
        // 段落内のテキストを取得
        $runs = $paragraph->xpath('.//w:t');
        $text = '';
        foreach ($runs as $run) {
            $text .= (string)$run;
        }
        
        $text = trim($text);
        if (empty($text)) {
            continue; // 空の段落はスキップ
        }
        
        // 見出しスタイルをチェック
        $pStyle = $paragraph->xpath('.//w:pStyle/@w:val');
        $style = !empty($pStyle) ? (string)$pStyle[0] : '';
        
        // 太字や斜体などのスタイルをチェック
        $isBold = !empty($paragraph->xpath('.//w:b'));
        $isItalic = !empty($paragraph->xpath('.//w:i'));
        
        // 見出しレベルの判定（簡易版）
        if (strpos($style, 'Heading1') !== false || strpos($style, '見出し1') !== false) {
            $html .= '<h1>' . h($text) . '</h1>' . "\n";
        } elseif (strpos($style, 'Heading2') !== false || strpos($style, '見出し2') !== false) {
            $html .= '<h2>' . h($text) . '</h2>' . "\n";
        } elseif (strpos($style, 'Heading3') !== false || strpos($style, '見出し3') !== false) {
            $html .= '<h3>' . h($text) . '</h3>' . "\n";
        } else {
            // 通常の段落
            $tag = 'p';
            $attrs = '';
            if ($isBold && $isItalic) {
                $text = '<strong><em>' . h($text) . '</em></strong>';
            } elseif ($isBold) {
                $text = '<strong>' . h($text) . '</strong>';
            } elseif ($isItalic) {
                $text = '<em>' . h($text) . '</em>';
            } else {
                $text = h($text);
            }
            $html .= '<' . $tag . $attrs . '>' . $text . '</' . $tag . '>' . "\n";
        }
    }
    
    return $html;
}

/**
 * DOCXファイルからタイトルを抽出
 * 
 * @param string $docxPath DOCXファイルのパス
 * @return string タイトル
 */
function extractDocxTitle($docxPath) {
    if (!file_exists($docxPath)) {
        return '無題のドキュメント';
    }
    
    $zip = new ZipArchive();
    if ($zip->open($docxPath) !== TRUE) {
        return basename($docxPath, '.docx');
    }
    
    // word/document.xmlを読み取る
    $documentXml = $zip->getFromName('word/document.xml');
    if ($documentXml === false) {
        $zip->close();
        return basename($docxPath, '.docx');
    }
    
    $zip->close();
    
    // XMLをパース
    libxml_use_internal_errors(true);
    $xml = simplexml_load_string($documentXml);
    if ($xml === false) {
        return basename($docxPath, '.docx');
    }
    
    // 最初の段落をタイトルとして使用
    $xml->registerXPathNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
    $paragraphs = $xml->xpath('//w:p');
    
    if (!empty($paragraphs)) {
        $firstParagraph = $paragraphs[0];
        $firstParagraph->registerXPathNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $runs = $firstParagraph->xpath('.//w:t');
        $title = '';
        foreach ($runs as $run) {
            $title .= (string)$run;
        }
        $title = trim($title);
        if (!empty($title)) {
            return $title;
        }
    }
    
    return basename($docxPath, '.docx');
}

/**
 * HTMLエスケープ関数（既存のh()関数がない場合のフォールバック）
 */
if (!function_exists('h')) {
    function h($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
