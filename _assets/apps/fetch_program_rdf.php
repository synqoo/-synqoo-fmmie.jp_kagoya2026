<?php
/**
 * $rss_list の RDF を巡回し、日時順に整形したリストを JSON で出力する
 * lastRSS クラスが必要。同梱の lastRSS.php を require するか、オートロードで読み込むこと。
 *
 * $mt_log_feed_url を設定した場合、処理開始時に MT ログフィードにアクセスし、
 * スケジュールタスク・再構築のトリガーとする（cron で 1 本化する用途）。
 */
if (!class_exists('lastRSS')) {
	$lastRSS_path = __DIR__ . '/lastRSS.php';
	if (is_file($lastRSS_path)) {
		require_once $lastRSS_path;
	} else {
		trigger_error('lastRSS.php が見つかりません。' . __DIR__ . ' に配置するか、事前に require してください。', E_USER_ERROR);
	}
}
mb_language("Japanese");
mb_internal_encoding("UTF-8");
error_reporting(E_ALL);
set_time_limit(0);

$output_file = (isset($_SERVER['DOCUMENT_ROOT']) ? rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') : dirname(__DIR__, 2)) . '/_assets/xml/_program_rdf.json';
$rss_list = array(
	'program' => array(
		'https://fmmie.jp/programs/hapihapi/rss2.rdf',
		// 'https://fmmie.jp/programs/buzzbuzz/rss2.rdf',
		// 'https://fmmie.jp/programs/FlidayNightFever/rss2.rdf',
		'https://fmmie.jp/programs/weekendcafe2/rss2.rdf',
		'https://fmmie.jp/programs/pomie/rss2.rdf',
		'https://fmmie.jp/programs/andojuku/rss2.rdf',
		'https://fmmie.jp/programs/tsunagaruzikan/rss2.rdf',
		'https://fmmie.jp/programs/talkbeyond/rss2.rdf',
	),
);
$img_ext = array(
);
$noimage = '/_include/img/blog/noimage.gif';
$rss_max = 15;
$rss = new lastRSS; 
$rss->items_limit = $rss_max;
$rss->date_format = 'Y/m/d H:i:s';
$rss->itemtags[] = 'dc:subject';
$rss->itemtags[] = 'dc:date';

$prev_date   = is_file($output_file) ? date("Y/m/d H:i:s", filemtime($output_file)) : null;
$newest_date = false;

// get rss data
$newlist = array();

foreach($rss_list as $kind => $rss_urls){
	$newlist_sub = array();
	$tsunagaru_count = 0;
	foreach($rss_urls as $rss_url){
		
		$rdf_path = is_array($rss_url) ? $rss_url[0] : $rss_url;
		$img_url_fallback = str_replace('rss2.rdf', 'thumb.jpg', $rdf_path);
		if (preg_match('#fmmie\.jp(.*)$#', $img_url_fallback, $m)) {
			$img_url_fallback = 'https://fmmie.jp' . $m[1];
		}
		if ($rs = $rss->get($rdf_path)) {
			$media_content_urls = get_media_content_urls_from_rss($rdf_path);
			$item_index = 0;
			foreach($rs['items'] as $item){
				$title = ($item['dc:subject']) ? $item['dc:subject'] : $rs['title'];
				if (mb_strpos($title, 'つながるジカン') !== false) {
					if ($tsunagaru_count >= 2) {
						$item_index++;
						continue;
					}
					$tsunagaru_count++;
				}
				$description = isset($item['description']) ? $item['description'] : (isset($item['desc']) ? $item['desc'] : '');
				// media:content を優先、なければ description 内の img、なければ fallback
				$img_url = !empty($media_content_urls[$item_index]) ? $media_content_urls[$item_index] : null;
				if ($img_url === null || $img_url === '') {
					$img_url = extract_first_image_url($description);
				}
				if ($img_url === null || $img_url === '') {
					$img_url = $img_url_fallback;
				}
				$item_index++;
				$newlist_sub[] = array(
					'title'       => $title,
					'url'         => $rs['link'],
					'img'         => $img_url,
					'entry_title' => $item['title'],
					'entry_url'   => $item['link'],
					'updated'     => ($item['dc:date'] && ($timestamp = strtotime_php4($item['dc:date'])) !==-1)? date($rss->date_format, $timestamp) : $item['pubDate'],
				);
			}
		}
		// echo "memory1:".memory_get_usage()."<br>\n";
	}
	// echo "loaded(".date("Y/m/d H:i:s").")<br>\n";

	usort($newlist_sub, "sort_by_date");
	$newlist[$kind] = array_slice($newlist_sub, 0, $rss_max);
	unset($newlist_sub);
}
unset($rss_list);

// write to JSON file（JSON を正しくエスケープするため json_encode を使用）
$json_list = array();
foreach($newlist as $kind => $newlist_sub){
	$json_row = array();
	foreach($newlist_sub as $row){
		if(empty($row['img'])){
			foreach($img_ext as $img_ext_val){
				if(preg_match($img_ext_val[0], $row['url']) || preg_match($img_ext_val[0], $row['entry_url'])){
					$row['img'] = $img_ext_val[1];
					break;
				}
			}
		}
		if(empty($row['img'])){
			$row['img'] = $noimage;
		}
		$json_row[] = $row;
	}
	$json_list[$kind] = $json_row;
	unset($newlist_sub);
}
unset($newlist);

$json = json_encode($json_list, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
if ($json === false) {
	$error_msg = 'JSON encode error: ' . json_last_error_msg();
	trigger_error($error_msg, E_USER_WARNING);
	output_result(false, $error_msg);
} else {
	$fp = fopen($output_file, 'w');
	if ($fp !== false) {
		$written = fwrite($fp, $json);
		fclose($fp);
		if ($written !== false && $written === strlen($json)) {
			output_result(true, null, $output_file);
		} else {
			output_result(false, 'ファイル書き込みが不完全です（書き込みバイト数: ' . ($written !== false ? $written : 0) . '）');
		}
	} else {
		output_result(false, 'ファイルを開けません: ' . $output_file . ' （書き込み権限を確認してください）');
	}
}

/**
 * 処理結果を出力する（CLI/Web 両対応）
 * @param bool   $success 成功したか
 * @param string|null $error_msg 失敗時の原因
 * @param string|null $output_file 成功時の出力ファイルパス
 */
function output_result($success, $error_msg = null, $output_file = null) {
	$is_cli = (php_sapi_name() === 'cli');
	$result = array(
		'success' => $success,
		'message'  => $success ? '処理が正常に完了しました' : $error_msg,
		'output'   => $output_file,
		'datetime' => date('Y-m-d H:i:s'),
	);
	if ($is_cli) {
		if ($success) {
			echo "成功: {$result['message']}\n";
			echo "出力先: {$output_file}\n";
		} else {
			echo "失敗: {$error_msg}\n";
		}
	} else {
		header('Content-Type: text/html; charset=UTF-8');
		$status = $success ? '成功' : '失敗';
		$status_class = $success ? 'success' : 'error';
		$msg = $success ? h($result['message']) : h($error_msg);
		$output_info = $output_file ? '<p>出力先: ' . h($output_file) . '</p>' : '';
		echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>fetch_program_rdf - ' . h($status) . '</title></head><body>';
		echo '<h1 class="' . h($status_class) . '">' . h($status) . '</h1>';
		echo '<p>' . $msg . '</p>';
		echo $output_info;
		echo '<p>実行日時: ' . h($result['datetime']) . '</p>';
		echo '</body></html>';
	}
}

// ============================================================

function sort_by_date($a, $b){
    if ($a['updated'] == $b['updated']) {
        return 0;
    }
    return ($a['updated'] > $b['updated']) ? -1 : 1;
}
function h($str) {
	return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}

/**
 * RSS フィードから各 item の media:content の url 属性を抽出する
 * Media RSS 仕様の <media:content url="..."> を想定
 *
 * @param string $rss_url RSS の URL
 * @return array インデックス => URL の連想配列（item の出現順）
 */
function get_media_content_urls_from_rss($rss_url) {
	$urls = array();
	$content = @file_get_contents($rss_url);
	if ($content === false) {
		return $urls;
	}
	if (preg_match_all('/<item\b[^>]*>(.*?)<\/item>/si', $content, $item_matches)) {
		foreach ($item_matches[1] as $item_content) {
			$url = null;
			if (preg_match('/<media:content\b[^>]+url\s*=\s*["\']([^"\']+)["\']/i', $item_content, $m)) {
				$url = trim($m[1]);
			}
			$urls[] = $url;
		}
	}
	return $urls;
}

/**
 * description（HTML）から最初の img の src URL を抽出する
 * RDF/RSS の item description 内の <img src="..."> を想定
 *
 * @param string $html description の HTML 文字列
 * @return string|null 最初の画像 URL、見つからなければ null
 */
function extract_first_image_url($html) {
	if ($html === '' || $html === null) {
		return null;
	}
	if (preg_match('/<img[^>]+src\s*=\s*["\']([^"\']+)["\']/i', $html, $m)) {
		return trim($m[1]);
	}
	return null;
}

function strtotime_php4($text){
	$date = strtotime($text);
	if($date != false && $date != -1){
		return $date;
	}else if(preg_match(
		'/^(\d{4})[-\/]?(\d\d?)[-\/]?(\d\d?)(?:(?:\s+|[-:Tt])(\d\d?):?(\d\d)(?::?(\d\d(?:\.\d*)?))?)?\s*([-+]?\d\d?:?(:?\d\d)?|Z|z)?\s*$/x',
		$text, $matches)){
	
		$year   = (isset($matches[1]))? $matches[1] : 0;
		$month  = (isset($matches[2]))? $matches[2] : 0;
		$day    = (isset($matches[3]))? $matches[3] : 0;
		$hour   = (isset($matches[4]))? $matches[4] : 0;
		$minute = (isset($matches[5]))? $matches[5] : 0;
		$second = (isset($matches[6]))? $matches[6] : 0;
		$tz     = (isset($matches[7]))? $matches[7] : 0;
	
		$tz = strtoupper($tz);
		$offset = 0;
		if($tz == 'GMT' || $tz == 'UTC' || $tz == 'UT' || $tz == 'Z'){
		
		}else if (preg_match('/^([-+])?(\d\d?):?(\d\d)?$/', $tz, $matches2)) {
			$offset = 3600 * $matches2[2];
			if(isset($matches2[3])){
				$offset += 60 * $matches2[3];
			}
			if(isset($matches2[1]) && $matches2[1] == "-"){
				$offset *= -1;
			}
		}
		return gmmktime($hour, $minute, $second, $month, $day, $year) - $offset;
	}else{
		return false;
	}
}
