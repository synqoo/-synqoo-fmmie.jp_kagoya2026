<?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php'); ?>
<!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8" />
    <title>レディオキューブFM三重 JONU78.9MHz</title>
    <meta name="color-scheme" content="light dark" />
    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?> 
    
    <!-- 重要なCSSを優先的に読み込む（FOUC防止） -->
    <link rel="preload" href="/_assets/css/index_timetable.css<?php echo $themeParam ?? ''; ?>" as="style" />
    <link rel="preload" href="/_assets/css/index_objects.css<?php echo $themeParam ?? ''; ?>" as="style" />
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" as="style" />
    
    <link rel="stylesheet" href="/_assets/css/index_timetable.css<?php echo $themeParam ?? ''; ?>">
    <link rel="stylesheet" href="/_assets/css/index_objects.css<?php echo $themeParam ?? ''; ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="/_assets/js/index_timetable.js" defer></script>
    <script src="/_assets/js/index_objects.js" defer></script>
  </head>
  <body>
    <?php require_once(INCLUDE_GLOBALHEADER_PATH); ?> 

    <main class="section">
      <div class="index-container stack">
        <section class="stack">
            <?php include_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/_include_nowonair.php'); ?>
            <?php include_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/_include_attention.php'); ?>
          <div class="topbannerz">
            <?php include_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/_include_topbannerz.php'); ?>
          </div>

          <div class="card stack">
            <h3 class="section-title">PICK UP!</h3>
            <?php include_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/topics/_include_topics.php'); ?>
          </div>
          <div class="card stack">
          <hr />
            <?php include_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/_include_programtopics.php'); ?>
          </div>

          <div class="card stack combannerz-card">
            <?php include_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/_include_combannerz.php'); ?>
          </div>
          <div class="card-newsrelease ">
            <?php include_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/_include_news.php'); ?>
            <?php include_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/_include_service.php'); ?>
          </div>
          
          <div class="powerplay-section">
            <h3 class="section-title">POWERPLAY</h3>
            <?php include_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/_include_powerplay.php'); ?>
          </div>
          <div class="card stack card-color">
            <?php include_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/_include_bannerz.php'); ?>
          </div>
        </section>
      </div>
    </main>

    <?php require_once(INCLUDE_FOOTER_PATH); ?>
  </body>
</html>
