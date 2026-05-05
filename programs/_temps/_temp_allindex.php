<$mt:Var name="entries_per_page" value="3"$>
<?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php'); ?>
<!doctype html>
<html lang="<$mt:BlogLanguage$>" itemscope itemtype="http://schema.org/Blog">
  <head>
    <title><$mt:BlogName encode_html="1"$> - レディオキューブFM三重</title>
    <mt:If tag="BlogDescription">
      <meta name="description" content="<$mt:BlogDescription remove_html="1" encode_html="1"$>" />
    </mt:If>
    <link rel="canonical" href="<$mt:BlogURL encode_html="1"$>" />
    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <$mt:Include module="HTMLヘッダー"$>
  </head>
  <body>
    <?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>
    
    <!-- メイン -->
    <main class="section">
      <div class="index-container stack">
        <section class="stack">
          
        <$mt:Include module="バナーヘッダー"$>
          
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
