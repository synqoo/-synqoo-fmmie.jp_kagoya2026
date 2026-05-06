<?php
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');

// フォーム名・フォームID（formz_regist.php から t=フォーム名, d=form_id で渡される）
$form_title = isset($_GET['t']) ? trim((string) $_GET['t']) : '';
$form_id    = isset($_GET['d']) ? trim((string) $_GET['d']) : '';
if ($form_title !== '') {
    $form_title = htmlspecialchars($form_title, ENT_QUOTES, 'UTF-8');
}
$heading_text = $form_title !== ''
    ? $form_title . ' への送信ありがとうございました'
    : '送信が完了しました';
?>
<!doctype html>
<html lang="ja" itemscope itemtype="http://schema.org/WebPage">
  <head>
    <title><?php echo $form_title !== '' ? htmlspecialchars($form_title, ENT_QUOTES, 'UTF-8') . ' - ' : ''; ?>送信完了 - レディオキューブFM三重</title>
    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="<?php echo $form_title !== '' ? htmlspecialchars($form_title, ENT_QUOTES, 'UTF-8') . ' - ' : ''; ?>送信完了 - レディオキューブFM三重">
    <link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo $themeParam ?? ''; ?>" />
    <link rel="stylesheet" href="/_assets/css/index_timetable.css<?php echo $themeParam ?? ''; ?>">
    <link rel="stylesheet" href="/_assets/css/index_objects.css<?php echo $themeParam ?? ''; ?>">
  </head>
  <body>
    <?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>

    <!-- メイン -->
    <main class="section">
      <div class="index-container stack">
        <section class="stack">

          <!-- 送信完了メッセージ（中央・大きく） -->
          <div class="card msg-card">
            <p class="msg-heading"><?php echo $heading_text; ?></p>
            <p class="msg-body"><a href="/">トップページへ戻る</a></p>
            <!-- <p class="msg-muted">内容を確認のうえ、担当者よりご連絡させていただきます。</p> -->
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

        </section>
      </div>
    </main>

    <?php require_once(INCLUDE_FOOTER_PATH); ?>
  </body>
</html>
