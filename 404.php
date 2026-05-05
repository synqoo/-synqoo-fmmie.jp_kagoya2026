<?php
http_response_code(404);
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');
?>
<!doctype html>
<html lang="ja" itemscope itemtype="http://schema.org/WebPage">
  <head>
    <title>ページが見つかりません（404） - レディオキューブFM三重</title>
    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="ページが見つかりません - レディオキューブFM三重">
    <link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo $themeParam; ?>" />
    <link rel="stylesheet" href="/_assets/css/index_timetable.css<?php echo $themeParam; ?>">
    <link rel="stylesheet" href="/_assets/css/index_objects.css<?php echo $themeParam; ?>">
  </head>
  <body>
    <?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>

    <!-- メイン -->
    <main class="section">
      <div class="index-container stack">
        <section class="stack">

          <!-- 404エラーメッセージ（中央・大きく） -->
          <div class="card msg-card">
            <p class="msg-code">404</p>
            <p class="msg-body">お探しのページが見つかりませんでした。</p>
            <p class="msg-muted">URLをご確認いただくか、下記リンクからお進みください。</p>
          </div>

          <!-- トピックス・既存ページへの誘導 -->
          <div class="card stack">
            <h3 class="section-title">PICK UP!</h3>
            <?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/topics/_include_topics.php'); ?>
          </div>
          <div class="card stack">
            <hr />
            <?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/_include_programtopics.php'); ?>
          </div>

          <!-- お知らせ -->
          <div class="card stack msg-notice-card">
            <h3 class="section-title">お知らせ</h3>
            <p class="msg-notice-text">この度、サイトリニューアルにおきましてページURLの変更などがあります。お手数ですが、トップページ、ページ上部のメニューからお進み下さい。</p>
          </div>

        </section>
      </div>
    </main>

    <?php require_once(INCLUDE_FOOTER_PATH); ?>
  </body>
</html>
