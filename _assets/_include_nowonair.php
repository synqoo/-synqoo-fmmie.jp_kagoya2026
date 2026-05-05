<?php
/**
 * NOW ON AIR 表示用インクルードファイル
 * トップページなどで使用
 *
 * 仕様:
 *   - 番組が見つからない場合でも、タイムテーブル等の下層は表示し続ける（exit しない）。
 *   - _assets/_nowonair_debug.flag が存在するときは、状況把握のため
 *     ビュー・ソースで読める HTML コメント診断を埋め込む。
 */
$program       = null;
$nowonairError = null;
$nowDiag       = null;

try {
  require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');
  require_once(__DIR__ . '/apps/index_timetable.php');

  $program = getNowOnAirProgram();
} catch (Throwable $e) {
  $nowonairError = $e->getMessage();
}

// デバッグフラグが置かれているときだけ詳細診断を実行
$nowonairDebug = file_exists(__DIR__ . '/_nowonair_debug.flag');
if ($nowonairDebug && function_exists('getNowOnAirDiagnostics')) {
  try {
    $nowDiag = getNowOnAirDiagnostics();
  } catch (Throwable $e) {
    $nowDiag = ['diagnostics_error' => $e->getMessage()];
  }
}

$currentMonth = (int)date('n');
$currentDay   = (int)date('j');
?>
<?php if ($nowonairDebug): ?>
<!-- NOW ON AIR DEBUG (begin)
program_is_null: <?php echo ($program === null) ? 'true' : 'false'; ?>

error: <?php echo $nowonairError !== null ? $nowonairError : '(none)'; ?>

<?php if (is_array($nowDiag)): ?>
<?php foreach ($nowDiag as $k => $v): ?>
<?php
  if (is_array($v)) {
    echo $k . ":\n";
    foreach ($v as $vv) {
      echo '  - ' . $vv . "\n";
    }
  } else {
    echo $k . ': ' . (is_bool($v) ? ($v ? 'true' : 'false') : (string)$v) . "\n";
  }
?>
<?php endforeach; ?>
<?php endif; ?>
NOW ON AIR DEBUG (end) -->
<?php endif; ?>
<?php if ($program === null): ?>
<!-- NOW ON AIR: No program on air<?php echo $nowonairError !== null ? ' (error: ' . htmlspecialchars($nowonairError, ENT_QUOTES, 'UTF-8') . ')' : ''; ?> -->
<?php endif; ?>
<div class="index-header-background">
  <div class="index-header">
    <?php if ($program !== null): ?>
    <div class="index-header-nowonair">
      <div class="nowonair-widget" id="nowonair-widget">
        <div class="nowonair-header">
          
          <?php if ($program['time'] !== ''): ?>
            <!-- <span class="nowonair-time" id="nowonair-time">
              <?php echo $currentMonth; ?>月<?php echo $currentDay; ?>日 <?php echo h($program['time']); ?></span> -->
            <span class="nowonair-time" id="nowonair-time">
              <?php echo h($program['time']); ?> <div class="blinking-dot"></div> NOW ON AIR</span>
          <?php endif; ?>
          <span class="nowonair-badge">NOW ON AIR</span>
        </div>
        
        <div class="nowonair-content">
          <div class="nowonair-info">
            <h2 class="nowonair-title" id="nowonair-title">
              <?php if ($program['program_id'] !== ''): ?>
                <?php echo h(mb_convert_kana((string)$program['title'], 's', 'UTF-8')); ?>
              <?php else: ?>
                <span><?php echo h(mb_convert_kana((string)$program['title'], 's', 'UTF-8')); ?></span>
              <?php endif; ?>
            </h2>
            
            <?php if (!empty($program['persons'])): ?>
              <div class="nowonair-personality" id="nowonair-personality">
                <?php foreach ($program['persons'] as $p): ?>
                  <div class="nowonair-person">
                    <?php if ($p['img']): ?>
                      <img src="<?php echo h($p['img']); ?>" alt="<?php echo h($p['name']); ?>" class="nowonair-person-photo">
                    <?php endif; ?>
                    <span class="nowonair-person-name"><?php echo h($p['name']); ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <div class="nowonair-links" id="nowonair-links">
              <?php if ($program['desc'] !== ''): ?>
                <!-- <button type="button" class="nowonair-link nowonair-desc-toggle" id="nowonair-desc-toggle" aria-label="番組説明を表示">
                  <i class="fa-regular fa-file-text" aria-hidden="true"></i>
                  <span class="sr-only">説明</span>
                </button> -->
              <?php endif; ?>
              <?php if ($program['site_url'] !== ''): ?>
                <!-- <a href="<?php echo h($program['site_url']); ?>" target="_blank" rel="noopener" class="nowonair-link" id="nowonair-site-link" aria-label="番組サイト">
                  <i class="fa-solid fa-house" aria-hidden="true"></i>
                  <span class="sr-only">サイト</span>
                </a> -->
              <?php endif; ?>
              
              <?php if ($program['message_url'] !== ''): ?>
                <a href="<?php echo h($program['message_url']); ?>" target="_blank" rel="noopener" class="nowonair-link message-button" id="nowonair-message-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none">
      <rect x="3" y="5" width="18" height="14" rx="2" fill="currentColor" fill-opacity="0.5"></rect>
      <path d="M21 7L12 13L3 7M3 5H21C22.1 5 23 5.9 23 7V19C23 20.1 22.1 21 21 21H3C1.9 21 1 20.1 1 19V7C1 5.9 1.9 5 3 5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>　メッセージを送る</a>
              <?php endif; ?>
            </div>
          </div>

          <?php if ($program['desc'] !== ''): ?>
            <div class="nowonair-desc-popup" id="nowonair-desc-popup">
              <div class="nowonair-desc-popup-content">
                <button type="button" class="nowonair-desc-popup-close" aria-label="閉じる">
                  <i class="fa-solid fa-times"></i>
                </button>
                <div class="nowonair-desc" id="nowonair-desc"><?php echo strip_tags($program['desc'], '<a><p><br><strong><em><b><i><u><span>'); ?></div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <?php
    if ($program !== null && $program['thumb']): ?>
      <div class="nowonair-thumb<?php echo (!empty($program['is_logo_radiko'])) ? ' is-logo-radiko' : ''; ?>">
        <img src="<?php echo h($program['thumb']); ?>" alt="<?php echo h($program['title']); ?>" id="nowonair-thumb-img">
      </div>
    <?php endif; ?>
    <?php
    $nowPlaying = function_exists('getNowPlaying') ? getNowPlaying() : null;
    ?>
    <div class="index-header-timetable">
      <div class="index-header-timetable-title"><?php echo $currentMonth; ?>月<?php echo $currentDay; ?>日 - TimeTable</div>
      <div class="timetable-scroll-container">
        <?php require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/_include_timetable.php'); ?>
      </div>
    </div>
    
    
  </div>
</div>

<!-- <hr class="hr-line" /> -->
<div class="nowplaying">
  <?php if ($nowPlaying): ?>
    <img src="/_assets/img/eq_icon_150.gif" alt="Now Playing" class="nowplaying-icon">NOW <br class="sp-only">PLAYING:
    <span class="nowplaying-text">
    <wbr> <?php echo h($nowPlaying['time']); ?> <?php echo h($nowPlaying['music_name']); ?> - <?php echo h($nowPlaying['artist_name']); ?>
    </span>
    <a href="/musics/played.php" class="nowplaying-search" aria-label="再生履歴を検索"><i class="fa-solid fa-magnifying-glass"></i></a>
  <?php endif; ?>
</div>
