<?php
/**
 * タイムテーブル関連のユーティリティ関数
 * NOW ON AIR表示と本日の番組表表示で使用
 */

date_default_timezone_set('Asia/Tokyo');
mb_internal_encoding('UTF-8');

/**
 * HTMLエスケープ
 */
if (!function_exists('h')) {
  function h($s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
  }
}

/**
 * テキスト正規化
 */
if (!function_exists('normalizeText')) {
  function normalizeText(string $s): string {
    $s = trim($s);
    $s = preg_replace("/\r\n|\r|\n/", "\n", $s);
    $s = preg_replace("/[ \t]+/", " ", $s);
    return $s;
  }
}

/**
 * サムネイル画像を選択
 * @param SimpleXMLElement $item XMLのitem要素
 * @param bool $isTimetablePage timetables/index.phpで使用する場合true（logo_radiko優先、9分以下はlogo優先）
 * @param bool $isMini 9分以下の番組の場合true（logo優先、timetables/index.phpでのみ有効）
 * @return string サムネイル画像のURL
 */
if (!function_exists('pickThumbnail')) {
  function pickThumbnail(SimpleXMLElement $item, bool $isTimetablePage = false, bool $isMini = false): string {
  // timetables/index.phpでの使用時
  if ($isTimetablePage) {
    if ($isMini) {
      // 9分以下の番組：logo優先
      $candidates = [
        (string)($item->logo ?? ''),
        (string)($item->logo_large ?? ''),
        (string)($item->logo_radiko ?? ''),
        (string)($item->logo_introduction ?? ''),
        (string)($item->logo_rectangle_large ?? ''),
        (string)($item->logo_rectangle ?? ''),
      ];
    } else {
      // 通常の番組：logo_radiko優先
      $candidates = [
        (string)($item->logo_radiko ?? ''),
        (string)($item->logo ?? ''),
        (string)($item->logo_large ?? ''),
        (string)($item->logo_introduction ?? ''),
        (string)($item->logo_rectangle_large ?? ''),
        (string)($item->logo_rectangle ?? ''),
      ];
    }
  } else {
    // NOW ON AIRなど：logo最優先（従来の仕様）
    $candidates = [
      (string)($item->logo ?? ''),
      (string)($item->logo_large ?? ''),
      (string)($item->logo_radiko ?? ''),
      (string)($item->logo_introduction ?? ''),
      (string)($item->logo_rectangle_large ?? ''),
      (string)($item->logo_rectangle ?? ''),
    ];
  }
  
  foreach ($candidates as $url) {
    $url = trim($url);
    if ($url !== '') return $url;
  }
  return '';
  }
}

/**
 * パーソナリティ情報を取得
 */
if (!function_exists('getPersonalities')) {
  function getPersonalities(SimpleXMLElement $item): array {
  $persons = [];
  
  // personality要素を処理
  if (isset($item->personality)) {
    foreach ($item->personality as $p) {
      $name = trim((string)($p->name ?? ''));
      $img  = trim((string)($p->photo ?? ''));
      
      // フォールバック
      if ($img === '') $img = trim((string)($p->image ?? ''));
      if ($img === '') $img = trim((string)($p->img ?? ''));
      
      if ($name === '' && $img === '') continue;
      
      $persons[] = [
        'name' => $name !== '' ? $name : '—',
        'img'  => $img,
      ];
    }
  }
  
  // group_personality要素を処理（personalityが空の場合）
  if (empty($persons) && isset($item->group_personality)) {
    foreach ($item->group_personality as $p) {
      $name = trim((string)($p->name ?? ''));
      $img  = trim((string)($p->photo ?? ''));
      
      if ($img === '') $img = trim((string)($p->image ?? ''));
      if ($img === '') $img = trim((string)($p->img ?? ''));
      
      if ($name === '' && $img === '') continue;
      
      $persons[] = [
        'name' => $name !== '' ? $name : '—',
        'img'  => $img,
      ];
    }
  }
  
  return $persons;
  }
}

/**
 * 日付文字列を取得（yyyymmdd形式）
 */
if (!function_exists('ymdFromItem')) {
  function ymdFromItem(SimpleXMLElement $it): string {
  $d = preg_replace('/\D/', '', trim((string)($it->date_yyyymmdd ?? '')));
  return (string)$d;
  }
}

/**
 * 放送日（Ymd）を取得
 *
 * 放送上の1日は「朝5:00 〜 翌朝4:59」とする。
 * したがって、実時刻が 0:00〜4:59 のときは「前日」を放送日とする。
 */
if (!function_exists('getBroadcastDate')) {
  function getBroadcastDate(): string {
    date_default_timezone_set('Asia/Tokyo');
    $h = (int)date('H');
    if ($h < 5) {
      return date('Ymd', strtotime('-1 day'));
    }
    return date('Ymd');
  }
}

/**
 * 放送日の曜日番号（0=日, 6=土）を取得
 *
 * 実時刻が 0:00〜4:59 のときは前日扱い。
 */
if (!function_exists('getBroadcastDayOfWeek')) {
  function getBroadcastDayOfWeek(): int {
    date_default_timezone_set('Asia/Tokyo');
    $h = (int)date('H');
    if ($h < 5) {
      return (int)date('w', strtotime('-1 day'));
    }
    return (int)date('w');
  }
}

/**
 * タイムテーブル一覧の表示日（Ymd）を取得
 *
 * 一覧用は NOW ON AIR より早く翌日に切り替える運用上の都合で、境界を 4:00 にしている。
 * 「28:00 (= 実時刻 04:00) を過ぎたら、まだ前日の最終番組（28:00-29:00 など）が放送中
 * であっても、一覧側は翌日朝 5:00 以降のラインナップを先取り表示する」という意図。
 * 実時刻が 0:00〜3:59 のときは前日扱い、4:00〜23:59 のときは当日扱い。
 */
if (!function_exists('getTimetableViewDate')) {
  function getTimetableViewDate(): string {
    date_default_timezone_set('Asia/Tokyo');
    $h = (int)date('H');
    if ($h < 4) {
      return date('Ymd', strtotime('-1 day'));
    }
    return date('Ymd');
  }
}

/**
 * タイムテーブル一覧の表示日の曜日番号（0=日, 6=土）を取得
 * 境界は 4:00（getTimetableViewDate と整合）。
 */
if (!function_exists('getTimetableViewDayOfWeek')) {
  function getTimetableViewDayOfWeek(): int {
    date_default_timezone_set('Asia/Tokyo');
    $h = (int)date('H');
    if ($h < 4) {
      return (int)date('w', strtotime('-1 day'));
    }
    return (int)date('w');
  }
}

/**
 * タイムテーブル一覧用の「現在分」（XMLの24:00超表記と直接比較できる値）
 *
 * 0:00〜3:59 のとき: $h+24 して 24:00超表記レンジに合わせる（例 02:54 → 26:54 = 1614）。
 * 4:00〜23:59 のとき: 通常の $h*60+$m を返す（例 04:30 → 270, 14:00 → 840）。
 *
 * これにより、当日 XML を読み込んでいる時刻が
 *   - 0:00〜3:59: 前日XMLの 27:00 番組を「未来」と見做せる
 *   - 4:00〜23:59: 当日XMLの 5:00 番組を「未来」と見做せる
 * ようになる。
 */
if (!function_exists('getTimetableViewNowMinutes')) {
  function getTimetableViewNowMinutes(): int {
    date_default_timezone_set('Asia/Tokyo');
    $h = (int)date('H');
    $m = (int)date('i');
    if ($h < 4) {
      return ($h + 24) * 60 + $m;
    }
    return $h * 60 + $m;
  }
}

/**
 * NOW ON AIR判定
 */
if (!function_exists('isNowOnAir')) {
  function isNowOnAir($it, $selectedDate) {
  date_default_timezone_set('Asia/Tokyo');
  
  // 放送上の1日は朝5:00〜翌朝4:59。
  // 実時刻が 0:00〜4:59 のときは「前日」が放送日となるため、
  // 単純な date('Ymd') ではなく getBroadcastDate() と比較する。
  $broadcastDate = getBroadcastDate();
  if ((string)$selectedDate !== (string)$broadcastDate) return false;
  
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
    if ($s === '') return [null, null];
    if (preg_match('/(\d{1,2}:\d{2})\s*[-～〜]\s*(\d{1,2}:\d{2})/u', $s, $m)) {
      return [$m[1], $m[2]];
    }
    return [null, null];
  };
  
  // 1) start/end をまず見る
  $startStr = trim((string)($it->onair_start ?? ''));
  $endStr   = trim((string)($it->onair_end ?? ''));
  
  // 2) end が無い場合、onair_time をパースして補完
  if ($endStr === '' || $startStr === '') {
    [$rs, $re] = $parseRange((string)($it->onair_time ?? ''));
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
 * XMLファイルを読み込む（リクエスト内キャッシュ付き）
 */
if (!function_exists('loadTimetableXml')) {
  function loadTimetableXml($dayOfWeek) {
    static $xmlCache = [];
    
    // キャッシュがあればそれを返す
    if (isset($xmlCache[$dayOfWeek])) {
      return $xmlCache[$dayOfWeek];
    }
    
    // XMLファイルパス
    $xmlPath = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/timetables/_xml/week/' . $dayOfWeek . '.xml';
    
    if (!file_exists($xmlPath)) {
      $xmlCache[$dayOfWeek] = null;
      return null;
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
    //$xml = simplexml_load_file($xmlPath);
    if ($xml === false) {
      $xmlCache[$dayOfWeek] = null;
      return null;
    }
    
    // キャッシュに保存
    $xmlCache[$dayOfWeek] = $xml;
    return $xml;
  }
}

/**
 * NOW ON AIRの番組を取得
 */
if (!function_exists('getNowOnAirProgram')) {
  function getNowOnAirProgram() {
  // 放送上の1日は朝5:00〜翌朝4:59。
  // 実時刻が 0:00〜4:59 のときは「前日分のXML」を参照する必要がある。
  $broadcastDate      = getBroadcastDate();        // 例: 水02:54 → 20260505（前日）
  $broadcastDayOfWeek = getBroadcastDayOfWeek();   // 例: 水02:54 → 2 (火曜)
  
  // XMLファイルを読み込む（キャッシュ付き）
  $xml = loadTimetableXml($broadcastDayOfWeek);
  if ($xml === null) {
    return null;
  }
  
  $items = $xml->xpath('//item');
  if (!$items || count($items) === 0) {
    return null;
  }
  
  // 注: XML ファイルは曜日（0.xml=日 〜 6.xml=土）でキーされており、
  // 中身のアイテムは「その曜日の番組」であることはファイル構造上保証される。
  // 一方で date_yyyymmdd は更新タイミング次第で「先週分」「翌週分」が入り得る
  // （本番では現に 20260512=翌週火曜になっていた）。
  // よって NOW ON AIR の判定は、date_yyyymmdd の厳密一致では絞り込まず、
  // 曜日XMLの全アイテムから時刻ベース（isNowOnAir 内部の時刻計算）で行う。
  foreach ($items as $it) {
    if (isNowOnAir($it, $broadcastDate)) {
      // 番組情報を構築（XMLフィールド名を確認）
      $title = trim((string)($it->program_name ?? $it->title ?? ''));
      $desc = normalizeText((string)($it->official_publicity ?? $it->description ?? ''));
      $thumb = pickThumbnail($it);
      $programId = trim((string)($it->program_id ?? ''));
      $siteUrl = trim((string)($it->siteurl ?? $it->site_url ?? ''));
      $messageUrl = trim((string)($it->message_url ?? ''));
      
      // logo_radikoが選択されたかどうかを判定
      $logoRadiko = trim((string)($it->logo_radiko ?? ''));
      $isLogoRadiko = ($logoRadiko !== '' && $thumb === $logoRadiko);
      
      // 時間表示
      $startStr = trim((string)($it->onair_start ?? ''));
      $endStr = trim((string)($it->onair_end ?? ''));
      if ($startStr === '' || $endStr === '') {
        $onairTime = trim((string)($it->onair_time ?? ''));
        if ($onairTime !== '') {
          $time = $onairTime;
        } else {
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
          $startStr = $toHHMM($st) ?? '';
          $endStr = $toHHMM($et) ?? '';
          $time = ($startStr && $endStr) ? "{$startStr} - {$endStr}" : '';
        }
      } else {
        $time = "{$startStr} - {$endStr}";
      }
      
      $persons = getPersonalities($it);
      
      return [
        'title' => $title,
        'desc' => $desc,
        'thumb' => $thumb,
        'time' => $time,
        'program_id' => $programId,
        'site_url' => $siteUrl,
        'message_url' => $messageUrl,
        'persons' => $persons,
        'is_logo_radiko' => $isLogoRadiko, // logo_radikoが選択された場合にtrue
      ];
    }
  }
  
  return null;
  }
}

/**
 * NOW ON AIRの診断情報を取得（デバッグ用）
 *
 * 本番環境で getNowOnAirProgram() が null を返す原因を切り分けるために使用する。
 * フェイル時にどこで失敗したかを構造化して返す。
 */
if (!function_exists('getNowOnAirDiagnostics')) {
  function getNowOnAirDiagnostics(): array {
    date_default_timezone_set('Asia/Tokyo');

    $info = [
      'server_now'             => date('Y-m-d H:i:s'),
      'tz'                     => date_default_timezone_get(),
      'broadcast_date'         => getBroadcastDate(),
      'broadcast_dayofweek'    => getBroadcastDayOfWeek(),
      'document_root'          => isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '(not set)',
      'xml_path'               => '',
      'xml_path_exists'        => false,
      'xml_path_readable'      => false,
      'xml_path_mtime'         => '',
      'xml_load_ok'            => false,
      'items_total'            => 0,
      'items_matched_date'     => 0,
      'unique_dates_in_xml'    => [],
      'sample_raw_date_values' => [],
      'matched_titles'         => [],
      'now_on_air_title'       => null,
      'now_on_air_time'        => null,
      'now_on_air_source'      => null,
      'now_minutes'            => ((int)date('H')) * 60 + ((int)date('i')),
    ];

    $xmlPath = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/\\') . '/timetables/_xml/week/' . $info['broadcast_dayofweek'] . '.xml';
    $info['xml_path']          = $xmlPath;
    $info['xml_path_exists']   = file_exists($xmlPath);
    $info['xml_path_readable'] = is_readable($xmlPath);
    if ($info['xml_path_exists']) {
      $mt = @filemtime($xmlPath);
      if ($mt !== false) {
        $info['xml_path_mtime'] = date('Y-m-d H:i:s', $mt);
      }
    }

    $xml = loadTimetableXml($info['broadcast_dayofweek']);
    if ($xml === null) {
      return $info;
    }
    $info['xml_load_ok'] = true;

    $items = $xml->xpath('//item');
    if (!$items) {
      return $info;
    }
    $info['items_total'] = count($items);

    $dateCounts = [];
    $sampleRaw  = [];
    foreach ($items as $idx => $it) {
      // 正規化後の日付
      $d = ymdFromItem($it);
      if (!isset($dateCounts[$d])) $dateCounts[$d] = 0;
      $dateCounts[$d]++;

      // 先頭5件は date_yyyymmdd の生の文字列も拾う（バイト確認用）
      if ($idx < 5) {
        $raw = (string)($it->date_yyyymmdd ?? '');
        $sampleRaw[] = '#' . $idx . ' raw="' . $raw . '" len=' . strlen($raw) . ' normalized="' . $d . '"';
      }

      // 日付一致した分のメタは引き続き記録（XML 鮮度の確認用）
      if ($d === $info['broadcast_date']) {
        $info['items_matched_date']++;
        $title = trim((string)($it->program_name ?? $it->title ?? ''));
        $start = trim((string)($it->onair_start ?? ''));
        $end   = trim((string)($it->onair_end ?? ''));
        $info['matched_titles'][] = "{$start}-{$end} {$title}";
      }

      // 実際の getNowOnAirProgram と同じく、日付に依らず時刻ベースで判定
      if ($info['now_on_air_title'] === null && isNowOnAir($it, $info['broadcast_date'])) {
        $title = trim((string)($it->program_name ?? $it->title ?? ''));
        $start = trim((string)($it->onair_start ?? ''));
        $end   = trim((string)($it->onair_end ?? ''));
        $info['now_on_air_title']  = $title;
        $info['now_on_air_time']   = "{$start}-{$end}";
        $info['now_on_air_source'] = ($d === $info['broadcast_date'])
          ? 'date_match'
          : 'time_only_fallback (xml_date=' . $d . ')';
      }
    }
    foreach ($dateCounts as $d => $c) {
      $info['unique_dates_in_xml'][] = $d . ' (x' . $c . ')';
    }
    $info['sample_raw_date_values'] = $sampleRaw;

    return $info;
  }
}

/**
 * 本日の番組一覧を取得
 */
if (!function_exists('getTodayPrograms')) {
  function getTodayPrograms() {
  // タイムテーブル一覧用の境界は 4:00。
  // 0:00〜3:59 → 前日扱い、4:00〜23:59 → 当日扱い。
  // NOW ON AIR 側（境界 5:00）と異なり、04:00 で機械的に翌日XMLに切り替える。
  // これにより、深夜の前日 28:00-29:00 番組がまだ放送中でも、一覧は翌日 5:00 以降の
  // ラインナップを先取り表示する。
  $viewDayOfWeek = getTimetableViewDayOfWeek();
  
  // XMLファイルを読み込む（キャッシュ付き）
  $xml = loadTimetableXml($viewDayOfWeek);
  if ($xml === null) {
    return [];
  }
  
  $items = $xml->xpath('//item');
  if (!$items || count($items) === 0) {
    return [];
  }
  
  // 注: nowonair と同じく date_yyyymmdd による日付フィルタは行わない。
  // 曜日XMLである時点で曜日は確定しており、date_yyyymmdd は更新タイミング次第で
  // 先週／翌週のものになり得る（本番では実際に発生）。
  // 全アイテムを対象に時刻ベースで判定する。
  $todayItems = [];
  foreach ($items as $it) {
    $todayItems[] = $it;
  }
  
  // 開始時間でソート（onair_starttime は数値で 24:00超表記もそのまま順序が保たれる）
  usort($todayItems, function($a, $b){
    $sa = (int)trim((string)($a->onair_starttime ?? '0'));
    $sb = (int)trim((string)($b->onair_starttime ?? '0'));
    return $sa <=> $sb;
  });
  
  // 一覧用の「現在分」。境界は 4:00。
  // 0:00〜3:59: ($h+24)*60+$m （= 24:00超表記レンジ。前日XMLの 27:00番組などと比較可能）
  // 4:00〜23:59: $h*60+$m       （= 当日XMLの 5:00番組などと比較可能）
  $viewNowMinutes = getTimetableViewNowMinutes();
  
  // 文字列→分（HH:MM形式を分に変換、24:00超表記もそのまま分換算）
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
    if ($s === '') return [null, null];
    if (preg_match('/(\d{1,2}:\d{2})\s*[-～〜]\s*(\d{1,2}:\d{2})/u', $s, $m)) {
      return [$m[1], $m[2]];
    }
    return [null, null];
  };
  
  // 数値（例: 900）をHH:MM形式に変換
  $toHHMM = function($n){
    $n = preg_replace('/\D/', '', (string)$n);
    if ($n === '') return null;
    $v = (int)$n;
    $h = (int)floor($v / 100);
    $m = $v % 100;
    return sprintf('%02d:%02d', $h, $m);
  };
  
  // 番組情報を構築（現在時刻以降のもののみ）
  $programs = [];
  foreach ($todayItems as $it) {
    // 開始時刻を取得
    $startStr = trim((string)($it->onair_start ?? ''));
    
    // startが無い場合、onair_time をパース
    if ($startStr === '') {
      [$rs, $re] = $parseRange((string)($it->onair_time ?? ''));
      if ($rs) $startStr = $rs;
    }
    
    // まだ無い場合、starttime（数値）から作る
    if ($startStr === '') {
      $st = trim((string)($it->onair_starttime ?? ''));
      if ($st !== '') {
        $tmp = $toHHMM($st);
        if ($tmp) $startStr = $tmp;
      }
    }
    
    // 開始時刻が取得できない場合はスキップ
    if ($startStr === '') {
      continue;
    }
    
    // 開始時刻を分単位に変換（24:00超表記もそのまま）
    $startMinutes = $toMin($startStr);
    if ($startMinutes === null) {
      continue;
    }
    
    // 一覧用の現在分以降の番組のみ表示。
    // 例) 実時刻 02:54（前日扱い） → viewNowMinutes = 26:54 = 1614。
    //     前日XMLの onair_start "27:00"(=1620) は 1620 >= 1614 で表示対象。
    // 例) 実時刻 04:30（当日扱い） → viewNowMinutes = 270。
    //     当日XMLの onair_start "05:00"(=300) は 300 >= 270 で表示対象。
    if ($startMinutes < $viewNowMinutes) {
      continue;
    }
    
    // XMLフィールド名を確認（timetables/index.phpと統一）
    $title = trim((string)($it->program_name ?? $it->title ?? ''));
    $desc = normalizeText((string)($it->official_publicity ?? $it->description ?? ''));
    $thumb = pickThumbnail($it);
    $programId = trim((string)($it->program_id ?? ''));
    $siteUrl = trim((string)($it->siteurl ?? $it->site_url ?? ''));
    $messageUrl = trim((string)($it->message_url ?? ''));
    
    // 時間表示
    $endStr = trim((string)($it->onair_end ?? ''));
    if ($endStr === '') {
      $onairTime = trim((string)($it->onair_time ?? ''));
      if ($onairTime !== '') {
        $time = $onairTime;
      } else {
        $et = trim((string)($it->onair_endtime ?? ''));
        $endStr = $toHHMM($et) ?? '';
        $time = ($startStr && $endStr) ? "{$startStr} - {$endStr}" : $startStr;
      }
    } else {
      $time = "{$startStr} - {$endStr}";
    }
    
    // 放送時間を分で計算（9分以下判定用）
    $durationMinutes = null;
    if ($startStr !== '' && $endStr !== '') {
      $startMin = $toMin($startStr);
      $endMin = $toMin($endStr);
      if ($startMin !== null && $endMin !== null) {
        // 深夜跨ぎ対応
        if ($endMin < $startMin) {
          $endMin += 1440; // 24時間 = 1440分
        }
        $durationMinutes = $endMin - $startMin;
      }
    } else {
      // onair_timeから計算を試みる
      $onairTimeStr = trim((string)($it->onair_time ?? ''));
      if ($onairTimeStr !== '') {
        // "HH:MM - HH:MM" 形式をパース
        if (preg_match('/(\d{1,2}):(\d{2})\s*[-～〜]\s*(\d{1,2}):(\d{2})/u', $onairTimeStr, $m)) {
          $startH = (int)$m[1];
          $startM = (int)$m[2];
          $endH = (int)$m[3];
          $endM = (int)$m[4];
          $startMin = $startH * 60 + $startM;
          $endMin = $endH * 60 + $endM;
          
          if ($endMin < $startMin) {
            $endMin += 1440;
          }
          
          $durationMinutes = $endMin - $startMin;
        }
      }
      
      // それでも無い場合、onair_starttime/endtimeから計算
      if ($durationMinutes === null) {
        $startTimeNum = trim((string)($it->onair_starttime ?? ''));
        $endTimeNum = trim((string)($it->onair_endtime ?? ''));
        if ($startTimeNum !== '' && $endTimeNum !== '') {
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
      }
    }
    
    $persons = getPersonalities($it);
    
    $programs[] = [
      'title' => $title,
      'desc' => $desc,
      'thumb' => $thumb,
      'time' => $time,
      'program_id' => $programId,
      'site_url' => $siteUrl,
      'message_url' => $messageUrl,
      'persons' => $persons,
      'duration_minutes' => $durationMinutes,
    ];
  }
  
  return $programs;
  }
}

/**
 * 放送中の楽曲情報を取得
 */
if (!function_exists('getNowPlaying')) {
  function getNowPlaying() {
  $xmlPath = __DIR__ . '/../xml/now.xml';
  
  if (!is_readable($xmlPath)) {
    return null;
  }
  $xmlContent = @file_get_contents($xmlPath);
  if ($xmlContent === false || $xmlContent === '') {
    return null;
  }
  
  // XMLをパース
  libxml_use_internal_errors(true);
  $xml = @simplexml_load_string($xmlContent);
  
  if ($xml === false) {
    return null;
  }
  
  // music要素を取得
  $music = $xml->music ?? null;
  if (!$music) {
    return null;
  }
  
  // 楽曲情報を取得
  $musicName = (string)($music->music_name ?? '');
  $artistName = (string)($music->artist_name ?? '');
  $onairTime = trim((string)($music->onair_time ?? ''));
  
  // nowplaying-text向け: 全角空白＋全角英数字を半角に変換（表示ゆれ対策）
  $musicName = trim(mb_convert_kana($musicName, 'as', 'UTF-8'));
  $artistName = trim(mb_convert_kana($artistName, 'as', 'UTF-8'));
  
  // 時刻を時/分形式に変換
  $timeStr = '';
  if ($onairTime !== '') {
    try {
      $dateTime = new DateTime($onairTime);
      $timeStr = $dateTime->format('H:i');
    } catch (Exception $e) {
      // エラー時は空文字
    }
  }
  
  if ($musicName === '' && $artistName === '') {
    return null;
  }
  
  return [
    'time' => $timeStr,
    'music_name' => $musicName,
    'artist_name' => $artistName,
  ];
  }
}

