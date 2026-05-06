<?php
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/index_timetable.php');
// ===== Debug (必要ならON) =====
// ini_set('display_errors', '1');
// error_reporting(E_ALL);
date_default_timezone_set('Asia/Tokyo');
mb_internal_encoding('UTF-8');

/**
 * 日付文字列を取得（yyyymmdd形式）
 */
if (!function_exists('ymdFromItem')) {
  function ymdFromItem($it) {
    $d = preg_replace('/\D/', '', trim((string)($it->date_yyyymmdd ?? '')));
    return (string)$d;
  }
}

/**
 * NOW ON AIR判定
 */
if (!function_exists('isNowOnAir')) {
  function isNowOnAir($it, $selectedDate) {
    date_default_timezone_set('Asia/Tokyo');
    
    // 表示日が今日のときだけNOW判定
    $today = date('Ymd');
    if ((string)$selectedDate !== (string)$today) return false;
    
    // 文字列→分
    $toMin = function($hhmm){
      $hhmm = trim((string)$hhmm);
      if ($hhmm === '') return null;
      $parts = explode(':', $hhmm);
      $h = isset($parts[0]) ? (int)$parts[0] : 0;
      $m = isset($parts[1]) ? (int)$parts[1] : 0;
      return $h * 60 + $m;
    };
    
    // onair_time から "HH:MM - HH:MM" を抜く
    $parseRange = function($s){
      $s = trim((string)$s);
      if ($s === '') return array(null, null);
      if (preg_match('/(\d{1,2}:\d{2})\s*[-～〜]\s*(\d{1,2}:\d{2})/u', $s, $m)) {
        return array($m[1], $m[2]);
      }
      return array(null, null);
    };
    
    // 1) start/end をまず見る
    $startStr = trim((string)($it->onair_start ?? ''));
    $endStr   = trim((string)($it->onair_end ?? ''));
    
    // 2) end が無い場合、onair_time をパースして補完
    if ($endStr === '' || $startStr === '') {
      list($rs, $re) = $parseRange((string)($it->onair_time ?? ''));
      if ($startStr === '' && $rs) $startStr = $rs;
      if ($endStr === '' && $re)   $endStr   = $re;
    }
    
    // 3) まだ end が無い場合、starttime/endtime（数値）から作る
    if ($endStr === '' || $startStr === '') {
      $st = trim((string)($it->onair_starttime ?? ''));
      $et = trim((string)($it->onair_endtime ?? ''));
      $toHHMM = function($n){
        $n = preg_replace('/\D/', '', (string)$n);
        if ($n === '') return null;
        $v = (int)$n;
        $h = (int)floor($v / 100);
        $m = $v % 100;
        return sprintf('%02d:%02d', $h, $m);
      };
      if ($startStr === '' && $st !== '') {
        $tmp = $toHHMM($st);
        if ($tmp) $startStr = $tmp;
      }
      if ($endStr === '' && $et !== '') {
        $tmp = $toHHMM($et);
        if ($tmp) $endStr = $tmp;
      }
    }
    
    // ここまで来ても揃わないなら判定不可
    if ($startStr === '' || $endStr === '') return false;
    
    $s = $toMin($startStr);
    $e = $toMin($endStr);
    if ($s === null || $e === null) return false;
    
    // 現在時刻（分）
    $now = ((int)date('H')) * 60 + ((int)date('i'));
    
    // 24:00超表記対応
    if ($e >= 1440 && $now < 360) {
      $now += 1440;
    }
    
    // end < start（跨ぎ）対応
    if ($e < $s) $e += 1440;
    
    return ($now >= $s && $now < $e);
  }
}

/**
 * fmmieの番組かどうかを判定
 */
if (!function_exists('isFmmieProgram')) {
  function isFmmieProgram($it) {
    // 型チェック
    if (!($it instanceof SimpleXMLElement)) {
      return false;
    }
    
    // siteurlにfmmie.jpが含まれているかチェック
    $siteUrl = trim((string)$it->siteurl);
    if ($siteUrl !== '' && stripos($siteUrl, 'fmmie.jp') !== false) {
      return true;
    }
    
    // key_stationが1023の場合もfmmie（補完）
    $keyStation = trim((string)$it->key_station);
    if ($keyStation === '1023') {
      return true;
    }
    
    return false;
  }
}

// ===== 曜日設定 =====
$weekDays = array(
  0 => '日曜',
  1 => '月曜',
  2 => '火曜',
  3 => '水曜',
  4 => '木曜',
  5 => '金曜',
  6 => '土曜',
);

// ===== 放送日関連の基準値 =====
// 放送上の1日は朝5:00〜翌朝4:59。深夜帯は前日扱いで前日の曜日XMLを参照する。
$broadcastDayOfWeek = getBroadcastDayOfWeek();
$broadcastDate      = getBroadcastDate();

// ===== 選択された曜日 =====
// デフォルトは「放送日」の曜日（深夜0:00〜4:59は前日の曜日が初期表示される）
$selectedDay = isset($_GET['day']) ? (int)$_GET['day'] : $broadcastDayOfWeek;
if ($selectedDay < 0 || $selectedDay > 6) {
  $selectedDay = $broadcastDayOfWeek;
}

// 閲覧中の曜日が放送日と一致するとき、NOW ON AIR バッジを出す対象になる。
$isViewingBroadcastDay = ($selectedDay === $broadcastDayOfWeek);

$today = date('Ymd');
$nowHi = date('Hi');
echo "<!-- today={$today} nowHi={$nowHi} broadcastDate={$broadcastDate} broadcastDow={$broadcastDayOfWeek} selectedDay={$selectedDay} viewingBroadcastDay=" . ($isViewingBroadcastDay ? '1' : '0') . " -->";

// ===== XMLファイルパス =====
$xmlPath = __DIR__ . '/_xml/week/' . $selectedDay . '.xml';

// ===== Load XML =====
if (!file_exists($xmlPath)) {
  http_response_code(500);
  echo "XML file not found: " . h($xmlPath);
  exit;
}

libxml_use_internal_errors(true);
// ココから　1. まずはファイル（またはURL）の内容を取得
$raw_data = file_get_contents($xmlPath);
if ($raw_data !== false) {
    // 2. XMLで許可されていない制御文字を削除する正規表現
    // (タブ、改行以外の 0x00-0x1F を除去)
    $clean_data = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $raw_data);
    // 3. 文字列からXMLを読み込む
    $xml = simplexml_load_string($clean_data);
    if ($xml === false) {
        echo "XMLエラー";
    } else {
        //echo "正常に読み込めました。";
    }
}
//ココまで

if ($xml === false) {
  http_response_code(500);
  echo "Failed to parse XML.\n";
  foreach (libxml_get_errors() as $err) {
    echo h($err->message) . "\n";
  }
  exit;
}

// ★ ここが重要：xpathで item を取る（階層差に強い）
$allItems = $xml->xpath('//item');
if (!$allItems || count($allItems) === 0) {
  echo "No program items found.";
  exit;
}

// ===== fmmieの番組だけを抽出 =====
$items = array();
foreach ($allItems as $it) {
  if (isFmmieProgram($it)) {
    $items[] = $it;
  }
}

if (count($items) === 0) {
  echo "fmmieの番組が見つかりませんでした。";
  exit;
}

// ===== Build dates (yyyymmdd => label) =====
$dateLabels = array();
foreach ($items as $it) {
  $d = ymdFromItem($it);
  if ($d === '') continue;
  if (!isset($dateLabels[$d])) {
    $label = trim((string)($it->date_text ?? ''));
    $dateLabels[$d] = ($label !== '') ? $label : $d;
  }
}
$dates = array_keys($dateLabels);
sort($dates);

// ===== Selected date =====
$selectedDate = isset($_GET['date']) ? preg_replace('/\D/', '', (string)$_GET['date']) : '';
if ($selectedDate === '' || !in_array($selectedDate, $dates, true)) {
  $selectedDate = $dates[0];
}

// ===== Filter day programs =====
$dayPrograms = array();
$dateText = '';

foreach ($items as $it) {
  $d = (string)ymdFromItem($it);
  if ($d === (string)$selectedDate) {
    $dayPrograms[] = $it;
    if ($dateText === '') $dateText = trim((string)($it->date_text ?? ''));
  }
}

// ★フォールバック：0件なら全件表示（空画面回避）
if (count($dayPrograms) === 0) {
  $dayPrograms = $items;
  if ($dateText === '') $dateText = $dateLabels[$selectedDate] ?? $selectedDate;
}

// ===== Sort by start time (onair_starttime) =====
usort($dayPrograms, function($a, $b){
  $sa = (int)trim((string)($a->onair_starttime ?? '0'));
  $sb = (int)trim((string)($b->onair_starttime ?? '0'));
  return $sa <=> $sb;
});

// タイトルに曜日名を含める
$titleDate = ($dateText !== '') ? $dateText : $selectedDate;
$pageTitle = $titleDate;

// ====== 時間帯グルーピング ======
$groupedPrograms = array(
    'Morning'   => array(),
    'Daytime'   => array(),
    'Afternoon' => array(),
    'Evening'   => array(),
  );
  
  function hhmmToInt($hhmm) {
    // "05:00" → 500, "18:30" → 1830
    $hhmm = trim((string)$hhmm);
    if ($hhmm === '') return 0;
    $parts = explode(':', $hhmm);
    $h = isset($parts[0]) ? (int)$parts[0] : 0;
    $m = isset($parts[1]) ? (int)$parts[1] : 0;
    return $h * 100 + $m;
  }
  
  function getGroupNameByStart($startHHMM) {
    $t = hhmmToInt($startHHMM);
    // 05:00-08:59
    if ($t >= 500 && $t < 900) return 'Morning';
    // 09:00-11:59
    if ($t >= 900 && $t < 1200) return 'Daytime';
    // 12:00-17:59
    if ($t >= 1200 && $t < 1800) return 'Afternoon';
    // 18:00-28:59（深夜は evening扱い）
    return 'Evening';
  }
  
  // $dayPrograms を各グループに振り分け
  foreach ($dayPrograms as $it) {
    $start = (string)($it->onair_start ?? ''); // 例: "05:00"
    $group = getGroupNameByStart($start);
    $groupedPrograms[$group][] = $it;
  }
  
  // 各グループ内を開始時刻順にソート
  foreach ($groupedPrograms as $g => $arr) {
    usort($arr, function($a, $b){
      $sa = hhmmToInt((string)($a->onair_start ?? ''));
      $sb = hhmmToInt((string)($b->onair_start ?? ''));
      return $sa <=> $sb;
    });
    $groupedPrograms[$g] = $arr;
  }

  $labels = array(
    'Morning' => '朝(5:00〜)',
    'Daytime' => '午前(9:00〜)',
    'Afternoon' => '午後(12:00〜)',
    'Evening' => '夜(18:00〜)',
  );

// ===== Debug comment =====
echo "<!-- items=" . count($items) .
     " dates=" . count($dates) .
     " selectedDate={$selectedDate}" .
     " dayPrograms=" . count($dayPrograms) .
     " firstItemDate=" . h(ymdFromItem($items[0])) .
     " -->";
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?php echo h($pageTitle); ?>｜fmmie番組表</title>
  <!-- レスポンシブ -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="format-detection" content="telephone=no" />
  <!-- 説明文 -->
  <meta name="description" content="FM三重（fmmie）の番組表" />

<?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo $themeParam ?? ''; ?>" />
<script>
(function () {
  // 自動スクロール機能を無効化（通常表示に変更）
  // ハッシュ指定がある場合のみスクロール
  window.addEventListener('load', function () {
    const hashTarget = location.hash ? document.getElementById(location.hash.slice(1)) : null;
    
    // ハッシュ指定がある場合のみスクロール
    if (hashTarget) {
      hashTarget.scrollIntoView({ behavior: 'auto', block: 'start' });
    }
  });
})();
</script>
</head>
<body>
<?php require_once(INCLUDE_GLOBALHEADER_PATH); ?> 

<div class="wrap">
<?php
  // 曜日ナビゲーション
  $currentUrl = $_SERVER['PHP_SELF'];
  // 放送中番組へのアンカーリンク用
  // 深夜0:00〜4:59は放送日が前日にあたるため、リンク先の ?day= は
  // 実時刻ベースの date('w') ではなく getBroadcastDayOfWeek() を使う。
  // 例) 水02:54 → ?day=2（昨日の火曜）にリンクする。
  $nowOnAir = getNowOnAirProgram();
  $nowOnAirDay = $broadcastDayOfWeek;
  $nowOnAirAnchor = $nowOnAir ? ($currentUrl . '?day=' . $nowOnAirDay . '#now-on-air') : '';
  ?>
  
  <div class="day-title-header">

<!-- ウェルカムカード -->
<div class="v0-card">
      <div class="v0-preview-card">
        <div class="v0-h1-wrap v0-h1-bracket">
          <svg class="v0-h1-bracket-svg" width="16" height="64" viewBox="0 0 16 64" fill="none" aria-hidden="true">
            <path d="M14 2H6C3.79 2 2 3.79 2 6V58C2 60.21 3.79 62 6 62H14" stroke="var(--primary-dark)" stroke-width="2.5" stroke-linecap="round"/>
          </svg>
          <div class="v0-h1-title-row">
            <div class="v0-h1-textgroup">
              <span class="v0-h1-subtitle">SELF TIMETABLES</span>
              <h1 class="v0-h1-title">FM三重制作の番組</h1>
            </div>
            <div class="day-title-right">
              <?php if ($nowOnAirAnchor): ?>
                <!-- <a href="<?php echo h($nowOnAirAnchor); ?>" class="now-on-air-link orenge"><i class="fa-solid fa-tower-broadcast"></i> 放送中の番組</a> -->
              <?php endif; ?>
              <a href="<?php echo trim(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/_assets/_pdf-timetable.php')); ?>" target="_blank" class="pdf-timetable-link">
                <i class="fa-solid fa-file-pdf"></i> PDF版タイムテーブル
              </a>
            </div>
          </div>
          <div class="v0-h1-bracket-accent">
            <div class="v0-h1-bracket-accent-line"></div>
            <div class="v0-h1-bracket-accent-dot"></div>
          </div>
        </div>
      </div>
  </div>
  </div>
<div class="card nav-panel">
  
  <?php
  // 曜日ナビゲーション
  $currentUrl = $_SERVER['PHP_SELF'];
  ?>
  
  <nav class="week-nav" aria-label="曜日ナビゲーション">
    <?php foreach ($weekDays as $dayNum => $dayName): ?>
      <a href="<?php echo h($currentUrl); ?>?day=<?php echo $dayNum; ?>" 
         class="week-nav-link <?php echo ($selectedDay === $dayNum) ? 'active' : ''; ?>">
        <?php echo h($dayName); ?>
      </a>
    <?php endforeach; ?>
  </nav>

  <?php
  // 時間帯ナビゲーション用：プログラムが存在するグループのみ表示
  $availableGroups = array();
  foreach ($groupedPrograms as $groupName => $programs) {
    if (!empty($programs)) {
      $availableGroups[$groupName] = $labels[$groupName] ?? $groupName;
    }
  }
  ?>

  <?php if (!empty($availableGroups)): ?>
  <nav style="display:none" class="time-nav" aria-label="時間帯ナビゲーション">
    <?php foreach ($availableGroups as $groupName => $label): ?>
      <a href="#group-<?php echo h($groupName); ?>" class="time-nav-link">
        <?php echo h($label); ?>
      </a>
    <?php endforeach; ?>
  </nav>
  <?php endif; ?>
</div>

<!-- <h1 class="day-title"><?php echo h($pageTitle); ?> のfmmie番組表</h1> -->

<?php foreach ($groupedPrograms as $groupName => $programs): ?>
  <?php if (empty($programs)) continue; ?>

  <div id="group-<?php echo h($groupName); ?>" class="time-group"></div>
  <div class="time-section-wrapper time-section-<?php echo h(strtolower($groupName)); ?>">

  <?php 
    $prevHour = null; // 前の番組の時刻（時）を保持
    foreach ($programs as $it): 
  ?>
    <?php
      $programId = (string)($it->program_id ?? '');
      $time = (string)($it->onair_time ?? '');
      $title = (string)($it->program_name ?? '');
      $desc = (string)($it->official_publicity ?? '');
      // HTMLタグを保持するため、normalizeTextは使用しない（改行や空白の正規化のみ）
      $desc = preg_replace("/\r\n|\r|\n/", "\n", $desc);
      $desc = preg_replace("/[ \t]+/", " ", $desc);
      $desc = trim($desc);
      $siteUrl    = trim((string)($it->siteurl ?? ''));
      $messageUrl = trim((string)($it->message_url ?? ''));
      
      // 現在の番組の開始時刻（時）を取得
      $currentHour = null;
      $startStr = trim((string)($it->onair_start ?? ''));
      if ($startStr !== '') {
        $parts = explode(':', $startStr);
        $currentHour = isset($parts[0]) ? (int)$parts[0] : null;
      } else {
        // onair_startが無い場合、onair_starttimeから取得
        $startTimeNum = trim((string)($it->onair_starttime ?? ''));
        if ($startTimeNum !== '') {
          $st = (int)preg_replace('/\D/', '', $startTimeNum);
          $currentHour = (int)floor($st / 100);
        }
      }
      
      // 1時間ごとに時刻見出しを表示
      if ($currentHour !== null) {
        $hourId = 'hour-' . (int)$currentHour;
      } else {
        $hourId = '';
      }

      if ($prevHour !== null && $currentHour !== null && $currentHour !== $prevHour) {
        echo '<h2' . ($hourId ? ' id="' . h($hourId) . '"' : '') . ' class="hour-heading">' . $currentHour . ':00~</h2>';
      } elseif ($prevHour === null && $currentHour !== null) {
        // 最初の番組の場合も時刻を表示
        echo '<h2' . ($hourId ? ' id="' . h($hourId) . '"' : '') . ' class="hour-heading">' . $currentHour . ':00~</h2>';
      }
      $prevHour = $currentHour;
      
      // 放送時間を分で計算（10分以下判定用）
      $durationMinutes = null;
      $endStr = trim((string)($it->onair_end ?? ''));
      $onairTimeStr = trim((string)($it->onair_time ?? ''));
      $startTimeNum = trim((string)($it->onair_starttime ?? ''));
      $endTimeNum = trim((string)($it->onair_endtime ?? ''));
      
      if ($startStr !== '' && $endStr !== '') {
        // "HH:MM"形式を分に変換
        $toMinutes = function($hhmm) {
          $parts = explode(':', $hhmm);
          $h = isset($parts[0]) ? (int)$parts[0] : 0;
          $m = isset($parts[1]) ? (int)$parts[1] : 0;
          return $h * 60 + $m;
        };
        
        $startMin = $toMinutes($startStr);
        $endMin = $toMinutes($endStr);
        
        if ($endMin < $startMin) {
          $endMin += 1440;
        }
        
        $durationMinutes = $endMin - $startMin;
      } elseif ($onairTimeStr !== '') {
        // onair_time から "HH:MM - HH:MM" をパース
        if (preg_match('/(\d{1,2}:\d{2})\s*[-～〜]\s*(\d{1,2}:\d{2})/u', $onairTimeStr, $m)) {
          $toMinutes = function($hhmm) {
            $parts = explode(':', $hhmm);
            $h = isset($parts[0]) ? (int)$parts[0] : 0;
            $m = isset($parts[1]) ? (int)$parts[1] : 0;
            return $h * 60 + $m;
          };
          
          $startMin = $toMinutes($m[1]);
          $endMin = $toMinutes($m[2]);
          
          if ($endMin < $startMin) {
            $endMin += 1440;
          }
          
          $durationMinutes = $endMin - $startMin;
        }
      } elseif ($startTimeNum !== '' && $endTimeNum !== '') {
        $st = (int)preg_replace('/\D/', '', $startTimeNum);
        $et = (int)preg_replace('/\D/', '', $endTimeNum);
        
        $startH = (int)floor($st / 100);
        $startM = $st % 100;
        $endH = (int)floor($et / 100);
        $endM = $et % 100;
        
        $startMin = $startH * 60 + $startM;
        $endMin = $endH * 60 + $endM;
        
        if ($endMin < $startMin) {
          $endMin += 1440;
        }
        
        $durationMinutes = $endMin - $startMin;
      }
      
      // 9分以下かどうか（明示的にbooleanにキャスト）
      $isMini = ($durationMinutes !== null && $durationMinutes <= 9) ? true : false;
      
      // サムネ
      // $thumb = pickThumbnail($it);
      $thumb = pickThumbnail($it, true, $isMini);

      // パーソナリティ（名前＋写真）
      $persons = getPersonalities($it);

    ?>
    <?php
    // NOW ON AIR バッジ判定。
    // 閲覧中の曜日（$selectedDay）が放送日の曜日（$broadcastDayOfWeek）と一致するときのみ判定する。
    // isNowOnAir は内部で「$selectedDate === broadcastDate」を見るため、
    // ここでは XML の date_yyyymmdd（=$selectedDate）に依存せず、$broadcastDate を直接渡す。
    $isNow = $isViewingBroadcastDay && isNowOnAir($it, $broadcastDate);
    ?>
    <?php 
      // クラス名を構築
      $cardClasses = 'card card-color-nomargin';
      if ($isNow) $cardClasses .= ' now-on-air';
      if ($isMini) $cardClasses .= ' card-mini';
    ?>
    <article class="<?php echo $cardClasses; ?>"
    <?php echo $isNow ? 'id="now-on-air"' : ''; ?>>

      <div class="program-row">
        <div class="thumb">
          <?php if ($thumb): ?>
            <img src="<?php echo h($thumb); ?>" alt="<?php echo h($title); ?>">
          <?php endif; ?>
        </div>

        <div class="program-info">
          <div class="program-time">
            <?php echo h($time); ?>
            <?php if ($isNow): ?>
                <span class="now-badge">NOW ON AIR</span>
            <?php endif; ?>
            </div>
            
          <h2 class="program-title">
            <!-- <a href="tb_detail.php?id=<?php echo h($programId); ?>"> -->
              <?php echo h($title); ?>
            <!-- </a> -->
          </h2>

          <?php if (!empty($persons)): ?>
            <div class="personality">
              <?php foreach ($persons as $p): ?>
                <div class="p-icon">
                  <?php if ($p['img']): ?>
                    <img src="<?php echo h($p['img']); ?>" alt="">
                  <?php endif; ?>
                </div>
                <div><?php echo h($p['name']); ?></div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
            
          <div class="program-desc"><?php echo $desc; // HTMLを有効にする ?></div>

          <?php
          // コーナー情報を取得して表示
          $corners = array();
          if (isset($it->corner)) {
            foreach ($it->corner as $corner) {
              $cornerStart = trim((string)($corner->corner_start ?? ''));
              $cornerName = trim((string)($corner->corner_name ?? ''));
              $cornerMessageUrl = trim((string)($corner->message_url ?? ''));
              if ($cornerStart !== '' || $cornerName !== '') {
                $corners[] = array(
                  'start' => $cornerStart,
                  'name' => $cornerName,
                  'message_url' => $cornerMessageUrl,
                );
              }
            }
          }
          ?>
          <?php if (!empty($corners)): ?>
            <div class="program-corners">
              <ul class="corner-list">
                <?php foreach ($corners as $corner): ?>
                  <li class="corner-item">
                    <?php if ($corner['start'] !== ''): ?>
                      <span class="corner-time"><?php echo h($corner['start']); ?></span>
                    <?php endif; ?>
                    <span class="corner-name-wrapper">
                      <?php if ($corner['name'] !== ''): ?>
                        <span class="corner-name"><?php echo h($corner['name']); ?></span>
                      <?php endif; ?>
                      <?php if ($corner['message_url'] !== ''): ?>
                        <a href="<?php echo h($corner['message_url']); ?>" class="program-link" target="_blank" rel="noopener" aria-label="メッセージ送信">
                          <i class="fa-regular fa-envelope" aria-hidden="true"></i> メッセージ送信
                          <span class="sr-only">メッセージ送信</span>
                        </a>
                      <?php endif; ?>
                    </span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <?php if ($siteUrl !== '' || $messageUrl !== ''): ?>
            <div class="program-links">
                <?php if ($siteUrl !== ''): ?>
                <a href="<?php echo h($siteUrl); ?>" class="program-link" target="_blank" rel="noopener" aria-label="番組サイト">
                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                    <span class="sr-only">番組サイト</span>
                </a>
                <?php endif; ?>

                <?php if ($messageUrl !== ''): ?>
                <a href="<?php echo h($messageUrl); ?>" class="program-link" target="_blank" rel="noopener" aria-label="メッセージ送信">
                    <i class="fa-regular fa-envelope" aria-hidden="true"></i> メッセージ送信
                    <span class="sr-only">メッセージ送信</span>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
      </div>
    </article>
    
  <?php endforeach; ?>
  </div>
<?php endforeach; ?>

</div>

<?php require_once(INCLUDE_FOOTER_PATH); ?>
</body>
</html>
