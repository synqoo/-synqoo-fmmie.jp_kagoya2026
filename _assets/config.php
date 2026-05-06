<?php
/**
 * サイト設定ファイル
 * パス解決用の定数を定義
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
// アソシエイトタグを設定すると、JANコードからAmazon検索リンクを出力します。
// 将来: Product Advertising API で ASIN を取得し /dp/ リンクに差し替え可能
define('AMAZON_AFFILIATE_TAG', 'fmmie'); // 例: 'fmmie-22' （Amazonアソシエイトで取得したタグ）

// Invisible reCAPTCHA v2
define('RECAPTCHA_SITE_KEY',   '6LdZ5I8sAAAAACOpz2q0yRRkCg3l0-HCFOBNk3QX');
define('RECAPTCHA_SECRET_KEY', '6LdZ5I8sAAAAAPBWnjC3Te0fFXlTETy14NyXSV8O');

// アプリケーション関数ファイル
require_once(ASSETS_PATH . '/apps/index_timetable.php');
require_once(ASSETS_PATH . '/apps/functions.php');
require_once(ASSETS_PATH . '/apps/amazon_affiliate.php');
// 302リダイレクト
function topage(string $url): void {
    // 絶対URLでなければサイトルート相対パスとして扱う
    if (!preg_match('#^https?://#i', $url)) {
        $url = '/' . ltrim($url, '/');
    }
    header('Location: ' . $url, true, 302);
    exit;
}

//静的テーマ設定
$staticTheme = 'fmmie'; // 例: 'orange', 'blue', 'purple', '' (デフォルト)
//有効なテーマのリスト（新しいテーマを追加する場合はここに追加）
$validThemes = ['white', 'orange', 'blue', 'purple','warm-orange',"rose","fmmie"];