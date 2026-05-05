<?php
/**
 * 本日分のシンプルな番組表（インクルード用）
 * トップページなどで使用
 */
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');
require_once(__DIR__ . '/apps/index_timetable.php');

// 本日の番組一覧を取得
$programs = getTodayPrograms();

// 番組がない場合
if (empty($programs)) {
  //echo '<p>本日の番組表データが見つかりません。</p>';
  //return;
}

// 現在の日付を取得（月日のみ）
$currentMonth = (int)date('n'); // 1-12
$currentDay = (int)date('j');   // 1-31
?>

<link rel="stylesheet" href="/_assets/css/index_timetable.css">

<div class="oneday_timetable">
  <!-- <h2><?php echo $currentMonth; ?>月<?php echo $currentDay; ?>日 - TimeTable</h2> -->
  <table class="program-table">
    <!-- <thead>
      <tr>
        <th>時間</th>
        <th>番組情報</th>
      </tr>
    </thead> -->
    <tbody>
<?php foreach ($programs as $program): ?>
<?php
  // 9分以下かどうか判定
  $isMini = (isset($program['duration_minutes']) && $program['duration_minutes'] !== null && $program['duration_minutes'] <= 9);
  $rowClass = $isMini ? 'program-row-mini' : '';
  // タイトル: 全角スペース・全角英数を半角に変換
  $title = mb_convert_kana($program['title'], 'as', 'UTF-8');
?>
        <tr class="<?php echo h($rowClass); ?>">
          <td class="program-time-cell">
            <?php
              // 時間表示: "10:00 ~ <!--10:30-->" 形式
              $timeDisplay = h($program['time']);
              if (preg_match('/^(\d{1,2}:\d{2})\s*[-～〜]\s*(\d{1,2}:\d{2})$/u', $timeDisplay, $matches)) {
                echo $matches[1] . ' ~ <!--' . $matches[2] . '-->';
              } else {
                echo $timeDisplay;
              }
            ?>
          </td>
          <td class="program-info-cell">
            <div class="program-content">
<?php if ($program['thumb']): ?>
                <div class="program-thumbnail">
                  <img src="<?php echo h($program['thumb']); ?>" alt="<?php echo h($title); ?>">
                </div>
<?php endif; ?>
              <div class="program-details">
                <div class="program-title"><?php echo h($title); ?></div>
<?php if ($program['desc'] !== ''): ?><!-- <div class="program-description"><?php echo h($program['desc']); ?></div> -->
<?php endif; ?>
<?php if (!empty($program['persons'])): ?>
                  <div class="program-personality">
<?php foreach ($program['persons'] as $p): ?>
                      <div class="personality-item">
<?php if ($p['img']): ?>
                          <!-- <img src="<?php echo h($p['img']); ?>" alt="<?php echo h($p['name']); ?>" class="personality-photo"> -->
<?php endif; ?>
                        <span class="personality-name"><?php echo h($p['name']); ?></span>
                      </div>
<?php endforeach; ?>
                  </div>
<?php endif; ?>
                <div class="program-links" style="display:none">
<?php if ($program['site_url'] !== ''): ?>
                    <a href="<?php echo h($program['site_url']); ?>" target="_blank" rel="noopener" class="program-link">番組サイト</a>
<?php endif; ?>
<?php if ($program['message_url'] !== ''): ?>
                    <a href="<?php echo h($program['message_url']); ?>" target="_blank" rel="noopener" class="program-link">メッセージ</a>
<?php endif; ?>
                </div>
              </div>
            </div>
          </td>
        </tr>
<?php endforeach; ?>
        <tr>
          <td colspan="2" class="timetable-week-cell"><a href="/timetables/" class="timetable-week-link"><i class="fa-regular fa-file-lines"></i> 週間タイムテーブル <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></td>
        </tr>
    </tbody>
  </table>
</div>

