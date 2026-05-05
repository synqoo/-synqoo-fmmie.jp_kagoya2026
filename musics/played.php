<?php
/**
 * 放送楽曲一覧ページ
 * _assets/xml/played/yyyy-mm-dd-played.xml を参照し、本日・昨日の放送曲を表示
 */
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');

/** 全角英数字・全角スペースを半角に変換 */
function played_halfwidth($str) {
    return mb_convert_kana((string)$str, 'as', 'UTF-8');
}

$rootPath = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\');
$playedDir = $rootPath . '/_assets/xml/played';

// 本日・昨日の日付
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));

$days = [
    ['label' => '本日', 'date' => $today,  'file' => $playedDir . '/' . $today . '-played.xml'],
    ['label' => '昨日', 'date' => $yesterday, 'file' => $playedDir . '/' . $yesterday . '-played.xml'],
];

$listByDay = [];

foreach ($days as $day) {
    $items = [];
    if (is_readable($day['file'])) {
        $xml = @simplexml_load_file($day['file']);
        if ($xml !== false && isset($xml->music)) {
            foreach ($xml->music as $m) {
                $onair = (string)($m['onair_time'] ?? $m->onair_time ?? '');
                if ($onair !== '') {
                    try {
                        $dt = new DateTime($onair);
                        $onairTime = $dt->format('H:i');
                        $onairSort = $onair;
                    } catch (Exception $e) {
                        $onairTime = $onair;
                        $onairSort = $onair;
                    }
                } else {
                    $onairTime = '--:--';
                    $onairSort = '';
                }
                $musicName = (string)($m->music_name ?? '');
                $janCode  = (string)($m->jan_code ?? $m['jan_code'] ?? '');
                $artist   = (string)($m->artist_name ?? '');
                $program  = '';
                if (isset($m->programinfo->program_name)) {
                    $program = (string)$m->programinfo->program_name;
                }
                $items[] = [
                    'onair_time'  => played_halfwidth($onairTime),
                    'onair_sort'  => $onairSort,
                    'music_name'  => played_halfwidth($musicName),
                    'jan_code'    => played_halfwidth($janCode),
                    'artist_name' => played_halfwidth($artist),
                    'program_name'=> played_halfwidth($program),
                ];
            }
        }
    }
    // 放送時刻の新しい順でソート
    usort($items, function ($a, $b) {
        return strcmp($b['onair_sort'], $a['onair_sort']);
    });
    $listByDay[] = [
        'label' => $day['label'],
        'date'  => $day['date'],
        'items' => $items,
    ];
}
?>
<!doctype html>
<html lang="ja">
  <head>
    <title>放送楽曲一覧 - レディオキューブFM三重</title>
    <link rel="canonical" href="https://fmmie.jp/musics/played.php" />
    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <meta property="og:type" content="article">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="放送楽曲一覧">
    <meta property="og:url" content="https://fmmie.jp/musics/played.php">
    <meta property="og:site_name" content="放送楽曲一覧">
    <meta itemprop="name" content="放送楽曲一覧">
    <link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo $themeParam ?? ''; ?>" />
    <link rel="stylesheet" href="/musics/css/played.css<?php echo $themeParam ?? ''; ?>" />
  </head>
  <body>
    <?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>

    <main class="section">
      <div class="index-container stack">
        <section class="stack">
          <div class="v0-card">
            <div class="v0-preview-card">
              <div class="v0-h1-wrap v0-h1-bracket">
                <svg class="v0-h1-bracket-svg" width="16" height="64" viewBox="0 0 16 64" fill="none" aria-hidden="true">
                  <path d="M14 2H6C3.79 2 2 3.79 2 6V58C2 60.21 3.79 62 6 62H14" stroke="var(--primary-dark)" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
                <div class="v0-h1-textgroup">
                  <span class="v0-h1-subtitle">MUSICS PLAYED</span>
                  <h1 class="v0-h1-title">放送楽曲一覧</h1>
                </div>
                <div class="v0-h1-bracket-accent">
                  <div class="v0-h1-bracket-accent-line"></div>
                  <div class="v0-h1-bracket-accent-dot"></div>
                </div>
              </div>
            </div>
          </div>

          <?php foreach ($listByDay as $day): ?>
          <article class="played-section">
            <h2><?php echo htmlspecialchars($day['label']); ?>（<?php echo htmlspecialchars($day['date']); ?>）</h2>
            <?php if (empty($day['items'])): ?>
              <p class="played-empty">この日の放送楽曲データはありません。</p>
            <?php else: ?>
              <div class="played-table-wrap">
                <table class="played-table">
                  <thead>
                    <tr>
                      <th class="played-col-time" scope="col">放送時刻</th>
                      <th class="played-col-music" scope="col">楽曲名</th>
                      <th class="played-col-artist" scope="col">アーティスト</th>
                      <th class="played-col-program" scope="col">番組名</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($day['items'] as $row): ?>
                    <tr>
                      <td class="played-col-time"><?php echo htmlspecialchars($row['onair_time']); ?></td>
                      <td class="played-col-music"><?php echo played_music_cell_html($row['music_name'], $row['jan_code']); ?></td>
                      <td class="played-col-artist"><?php echo htmlspecialchars($row['artist_name']); ?></td>
                      <td class="played-col-program"><?php echo htmlspecialchars($row['program_name']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </article>
          <?php endforeach; ?>

          <div class="played-search-old-wrap">
            <a href="https://noa.jfn.co.jp/search/view/nu/" class="played-search-old-btn" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-angles-down"></i> これより以前の楽曲を探す</a>
          </div>
        </section>
      </div>
    </main>

    <?php require_once(INCLUDE_FOOTER_PATH); ?>
  </body>
</html>
