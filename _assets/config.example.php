<?php
/**
 * サイト設定ファイル（テンプレート）
 * このファイルを config.php にコピーし、reCAPTCHA のキーを設定してください。
 */

// ドキュメントルートのパス（末尾のスラッシュを除去）
define('ROOT_PATH', rtrim($_SERVER['DOCUMENT_ROOT'], '/\\'));

// アセットディレクトリのパス
define('ASSETS_PATH', ROOT_PATH . '/_assets');

// インクルードファイルのパス
define('INCLUDE_HTMLHEAD_PATH', ASSETS_PATH . '/_include_htmlhead.php');
define('INCLUDE_GLOBALHEADER_PATH', ASSETS_PATH . '/_include_globalheader.php');
define('INCLUDE_FOOTER_PATH', ASSETS_PATH . '/_include_footer.php');

// Amazonアフィリエイト（商品リンク用）
define('AMAZON_AFFILIATE_TAG', 'fmmie');

// Invisible reCAPTCHA v2
define('RECAPTCHA_SITE_KEY',   '');
define('RECAPTCHA_SECRET_KEY', '');

// アプリケーション関数ファイル
require_once(ASSETS_PATH . '/apps/index_timetable.php');
require_once(ASSETS_PATH . '/apps/functions.php');
require_once(ASSETS_PATH . '/apps/amazon_affiliate.php');

function topage(string $url): void {
    if (!preg_match('#^https?://#i', $url)) {
        $url = '/' . ltrim($url, '/');
    }
    header('Location: ' . $url, true, 302);
    exit;
}

$staticTheme = 'fmmie';
$validThemes = ['white', 'orange', 'blue', 'purple', 'warm-orange', 'rose', 'fmmie'];
