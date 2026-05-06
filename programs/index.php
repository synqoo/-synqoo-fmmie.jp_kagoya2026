<?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php'); ?>
<!doctype html>
<html lang="ja" itemscope itemtype="http://schema.org/Blog">
  <head>
    <title>番組サイト - レディオキューブFM三重</title>
    
    <link rel="canonical" href="https://fmmie.jp/programs/" />
    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <!--Include module="HTMLヘッダー -->
<!-- Open Graph Protocol -->
    <meta property="og:type" content="article">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="番組サイト">
    <meta property="og:url" content="https://fmmie.jp/programs/">
    
    <meta property="og:site_name" content="番組サイト">
    <meta property="og:image" content="/mt7/mt-static/support/theme_static/theme-from-programs/img/siteicon-sample.png">
    <!-- Microdata -->
    
    <meta itemprop="name" content="番組サイト">

   <link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo $themeParam ?? ''; ?>" />
   <link rel="stylesheet" href="https://fmmie.jp/programs/styles.css<?php echo $themeParam ?? ''; ?>" />
  </head>
  <body>
    <?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>
    
    <!-- メイン -->
    <main class="section">
      <div class="index-container stack">
        <section class="stack">
          
        <!-- ウェルカムカード -->
          <div class="v0-card">
            <div class="v0-preview-card">
        <div class="v0-h1-wrap v0-h1-bracket">
          <?php echo file_get_contents(ASSETS_PATH . '/img/svg/h1-bracket.svg'); ?>
          <div class="v0-h1-textgroup">
            <span class="v0-h1-subtitle">PROGRAMS</span>
            <h1 class="v0-h1-title">番組サイト</h1>
          </div>
          <div class="v0-h1-bracket-accent">
            <div class="v0-h1-bracket-accent-line"></div>
            <div class="v0-h1-bracket-accent-dot"></div>
          </div>
        </div>
      </div>
          </div>
          
          <!-- 番組一覧（programs/index.json から生成） -->
          <article class="program-card-section">
            <div class="program_box">
              <ul class="program-list">
<?php
$programs_json_path = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/programs/index.json';
$programs_data = [];
if (is_file($programs_json_path)) {
  $raw = file_get_contents($programs_json_path);
  if ($raw !== false) {
    $decoded = json_decode($raw, true);
    if (isset($decoded['programs']) && is_array($decoded['programs'])) {
      $programs_data = $decoded['programs'];
    }
  }
}
foreach ($programs_data as $p) {
  $a_url = isset($p['a_url']) ? $p['a_url'] : '';
  $img_url = isset($p['img_url']) ? $p['img_url'] : '';
  $name = isset($p['name']) ? $p['name'] : '';
  $dtime = isset($p['dtime']) ? $p['dtime'] : '';
  $message = !empty($p['message']);
  $message_url = isset($p['message_url']) ? $p['message_url'] : '';
  $a_attr = ' href="' . htmlspecialchars($a_url, ENT_QUOTES, 'UTF-8') . '"';
  if (strpos($a_url, 'http') === 0) {
    $a_attr .= ' target="" rel="noopener noreferrer"';
  }
  $alt_attr = $name !== '' ? ' alt="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '"' : '';
?>
                <li class="program-card">
                  <a class="program-card__thumb-link"<?php echo $a_attr; ?>><span class="program-card__thumb"><img src="<?php echo htmlspecialchars($img_url, ENT_QUOTES, 'UTF-8'); ?>"<?php echo $alt_attr; ?> /></span></a>
                  <div class="program-card__body">
                    <?php if ($dtime !== '') { ?><p class="program-card__dtime"><?php echo htmlspecialchars($dtime, ENT_QUOTES, 'UTF-8'); ?></p><?php } ?>
                    <p class="program-card__name"><?php if ($name !== '') { echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); } ?></p>
                    <?php if ($message && $message_url !== '') { ?><div class="program-links"><a href="<?php echo htmlspecialchars($message_url, ENT_QUOTES, 'UTF-8'); ?>" class="program-link" target="_blank" rel="noopener" aria-label="メッセージ送信"><i class="fa-regular fa-envelope" aria-hidden="true"></i> メッセージ送信<span class="sr-only">メッセージ送信</span></a></div><?php } ?>
                  </div>
                </li>
<?php } ?>
              </ul>
            </div>
          </article>
          
        </section>
      </div>
    </main>
    
    <?php require_once(INCLUDE_FOOTER_PATH); ?>
    
  </body>
</html>
