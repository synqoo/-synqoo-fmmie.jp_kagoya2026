<?php
/**
 * バナー画像表示用インクルードファイル
 * /_assets/img/bannerz/2025/ 内の画像ファイルを全て表示
 */

// 画像ディレクトリのパス（appsディレクトリから見た相対パス）
$bannerDir = __DIR__ . '/../img/bannerz/2026/';

// 画像ファイルの拡張子
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

// 画像ファイルを取得
$bannerFiles = [];
if (is_dir($bannerDir)) {
  $files = scandir($bannerDir);
  foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    
    $filePath = $bannerDir . $file;
    if (is_file($filePath)) {
      $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
      if (in_array($ext, $allowedExtensions)) {
        $bannerFiles[] = $file;
      }
    }
  }
  
  // ファイル名でソート
  sort($bannerFiles);
}

// 画像がない場合は何も表示しない
if (empty($bannerFiles)) {
  echo '<!-- No banner images found -->';
  return;
}
?>

<ul class="banner-list">
  <?php foreach ($bannerFiles as $file): ?>
    <?php
      $imagePath = '/_assets/img/bannerz/2025/' . $file;
      $imageName = pathinfo($file, PATHINFO_FILENAME);
      $imageAlt = htmlspecialchars($imageName, ENT_QUOTES, 'UTF-8');
    ?>
    <li class="banner-item">
      <img src="<?php echo htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8'); ?>" 
           alt="<?php echo $imageAlt; ?>" 
           class="banner-image">
    </li>
  <?php endforeach; ?>
</ul>

