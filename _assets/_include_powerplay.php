<?php
/**
 * Power Play セクションの HTML 出力
 * /musics/powerplay/powerplay_index.json を読み込み、index.php 74-102 形式の HTML を出力する
 */

$json_path = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/musics/powerplay/powerplay_index.json';
$image_base = '/musics/powerplay/albumimages/';

if (!file_exists($json_path)) {
	echo '<!-- powerplay_index.json not found -->';
	return;
}

$json_raw = @file_get_contents($json_path);
if ($json_raw === false) {
	echo '<!-- failed to read powerplay_index.json -->';
	return;
}

$data = json_decode($json_raw, true);
if ($data === null || json_last_error() !== JSON_ERROR_NONE) {
	echo '<!-- invalid powerplay_index.json -->';
	return;
}

$list = isset($data['powerplay_jp']) && is_array($data['powerplay_jp']) ? $data['powerplay_jp'] : array();
$list = array_filter($list, function ($item) {
	return !empty($item['title']) || !empty($item['artist']) || !empty($item['image']);
});

if (empty($list)) {
	echo '<!-- no powerplay items -->';
	return;
}

if (!function_exists('h')) {
	function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}
?>
  <div class="powerplay-list">
<?php foreach ($list as $item): ?>
    <article class="powerplay-card">
      <img src="<?php echo h($image_base . (isset($item['image']) ? $item['image'] : '')); ?>" alt="<?php echo h($item['title'] ?? ''); ?>">
      <div class="powerplay-card-body">
        <h4><?php echo h($item['title'] ?? ''); ?><br /><span class="powerplay-artist"><?php echo h($item['artist'] ?? ''); ?></span></h4>
        <p><?php echo h($item['body'] ?? ''); ?> - <?php echo h($item['desc'] ?? ''); ?></p>
        <p class="text-muted"><?php echo h($item['com'] ?? ''); ?></p>
      </div>
    </article>
<?php endforeach; ?>
  </div>
