<?php
/**
 * Amazonアフィリエイトリンク生成
 *
 * JANコードからAmazon商品ページへのアフィリエイトリンクを返します。
 * 現状: 検索URL（/s?k=JAN&tag=xxx）を返却。
 * 将来: Product Advertising API で EAN/JAN → ASIN を取得し、
 *       /dp/{ASIN}?tag=xxx の直接リンクに差し替え可能。
 *
 * @see https://affiliate.amazon.co.jp/
 * @see Product Advertising API 5.0 (SearchItems by Keywords/EAN)
 */

if (!defined('ROOT_PATH')) {
    return;
}

/**
 * JANコードに対応するAmazonアフィリエイトURLを返す
 *
 * @param string $jan_code JAN/EANコード（13桁等）
 * @return string|null アフィリエイトURL。タグ未設定またはJANが空の場合は null
 */
function get_amazon_affiliate_url($jan_code) {
    $jan_code = trim((string) $jan_code);
    if ($jan_code === '') {
        return null;
    }
    $tag = defined('AMAZON_AFFILIATE_TAG') ? trim((string) AMAZON_AFFILIATE_TAG) : '';
    if ($tag === '') {
        return null;
    }
    $encoded = rawurlencode($jan_code);
    return 'https://www.amazon.co.jp/s?k=' . $encoded . '&tag=' . rawurlencode($tag);
}

/**
 * 楽曲セル用: 楽曲名＋JANの表示HTMLを生成（アフィリエイトリンク付きの場合はリンクでラップ）
 *
 * @param string $music_name 楽曲名
 * @param string $jan_code JANコード
 * @return string HTML（エスケープ済みテキスト＋必要なら a タグ）
 */
function played_music_cell_html($music_name, $jan_code) {
    $music_name = htmlspecialchars($music_name, ENT_QUOTES, 'UTF-8');
    $jan_code_s = htmlspecialchars($jan_code, ENT_QUOTES, 'UTF-8');
    $url = get_amazon_affiliate_url($jan_code);
    if ($url !== null && $jan_code !== '') {
        $link = '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" class="played-amazon-link" target="_blank" rel="noopener noreferrer nofollow" aria-label="Amazonで検索"><i class="fa-brands fa-amazon"></i></a>';
        return $music_name . ' [ ' . $link . ' ]';
    }
    if ($jan_code !== '') {
        return $music_name . ' (' . $jan_code_s . ')';
    }
    return $music_name;
}
