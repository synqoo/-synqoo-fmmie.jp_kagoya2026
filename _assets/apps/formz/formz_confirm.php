<?php
/**
 * フォーム送信確認画面（共通）
 * formztemp.csv と _setbody.txt から項目名称を取得し、
 * 入力データの一覧を表示。戻る/送信で次のアクションへ。
 */
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');
session_start();
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/functions.php');

$formz_caller = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '/';
$formz_caller_dir = 'https://fmmie.jp' . rtrim(dirname($formz_caller), '/\\') . '/';

// 直接アクセスまたはPOSTデータがない場合は入力フォームへリダイレクト
if (empty($_POST) || !isset($_POST['act']) || $_POST['act'] != '1') {
    header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $formz_caller));
    exit;
}

$fm_id = isset($_POST['form_id']) ? (int)$_POST['form_id'] : 0;
formz_config($fm_id);

$form_title = isset($_POST['form_title']) ? $_POST['form_title'] : '入力の確認';

// formztemp.csv を読み込み（項目番号[0]、デフォルト項目名称[1]、フィールド名[2]）
viewformztemp();

// _setbody.txt から項目名称のオーバーライドを取得
$configUrl = 'https://backsite.pro/fmmie/storage/formzconfig/' . $fm_id . '_setbody.txt';
$context = stream_context_create([
    'http' => ['timeout' => 5, 'method' => 'GET'],
    'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
]);
$setbodyContent = @file_get_contents($configUrl, false, $context);

$labelOverrides = [];
if ($setbodyContent !== false) {
    $lines = explode("\n", $setbodyContent);
    foreach ($lines as $line) {
        $line = str_replace(["\r\n", "\r", "\n"], '', $line);
        if (trim($line) === '') continue;
        $cols = explode(",", $line);
        $itemNum = isset($cols[0]) ? trim($cols[0]) : '';
        $customLabel = isset($cols[1]) ? trim($cols[1]) : '';
        if (is_numeric($itemNum) && $customLabel !== '') {
            $labelOverrides[(int)$itemNum] = $customLabel;
        }
    }
}

// プレゼント（64番/x_prez）の数値→名称マッピングを構築
$prezValueToName = [];
$prezUrl = 'https://backsite.pro/fmmie/storage/formzconfig/' . $fm_id . '_prez.txt';
$prezContent = @file_get_contents($prezUrl, false, $context);
if ($prezContent !== false) {
    $prezLines = array_filter(array_map('trim', explode("\n", $prezContent)));
    foreach ($prezLines as $prezLine) {
        $parts = explode(';', $prezLine);
        if (isset($parts[0]) && isset($parts[1]) && $parts[0] !== '') {
            $prezValueToName[trim($parts[1])] = trim($parts[0]);
        }
    }
}

$typeNames = ['number', 'varchar', 'text', 'date', 'ind'];

$fieldLabels = [];
if (isset($formztemp) && is_array($formztemp)) {
    foreach ($formztemp as $row) {
        $itemNum = isset($row[0]) ? (int)$row[0] : null;
        $fieldName = isset($row[2]) ? trim($row[2]) : '';
        $defaultLabel = isset($row[1]) ? trim($row[1]) : '';
        $options = isset($row[4]) ? strtolower(trim($row[4])) : '';
        if ($fieldName === '' || $options === 'hidden') continue;
        if (in_array(strtolower($fieldName), $typeNames)) continue;
        $label = isset($labelOverrides[$itemNum]) ? $labelOverrides[$itemNum] : $defaultLabel;
        if ($label !== '') {
            $fieldLabels[$fieldName] = $label;
        }
    }
}

// フォームID別: 確認画面の項目名・選択値の表示カスタム（任意ファイル）
$confirmDisplayHook = null;
$confirmDisplayPath = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/confirm_display/' . $fm_id . '.php';
if (is_file($confirmDisplayPath)) {
    $loadedHook = require $confirmDisplayPath;
    $confirmDisplayHook = is_array($loadedHook) ? $loadedHook : null;
}

$orderedFields = [];
foreach ($formztemp as $row) {
    $fieldName = isset($row[2]) ? trim($row[2]) : '';
    if ($fieldName === '' || (isset($row[4]) && strtolower(trim($row[4])) === 'hidden')) continue;
    if (in_array(strtolower($fieldName), $typeNames)) continue;
    $orderedFields[] = $fieldName;
}

$displayRowByField = [];
$seenBuild = [];
foreach ($orderedFields as $fn) {
    if (isset($seenBuild[$fn])) continue;
    $seenBuild[$fn] = true;
    if (!isset($_POST[$fn])) continue;
    $label = isset($fieldLabels[$fn]) ? $fieldLabels[$fn] : $fn;
    if ($confirmDisplayHook !== null && !empty($confirmDisplayHook['label_overrides'][$fn])) {
        $label = $confirmDisplayHook['label_overrides'][$fn];
    }
    $value = $_POST[$fn];
    if (is_array($value)) {
        $value = implode(', ', $value);
    } elseif ($confirmDisplayHook !== null && !empty($confirmDisplayHook['value_maps'][$fn])) {
        $valueKey = (string)$value;
        $map = $confirmDisplayHook['value_maps'][$fn];
        if (isset($map[$valueKey])) {
            $value = $map[$valueKey];
        }
    }
    if ($fn === 'x_prez' && !empty($prezValueToName)) {
        $valueKey = (string)$value;
        $value = isset($prezValueToName[$valueKey]) ? $prezValueToName[$valueKey] : $value;
    }
    $displayRowByField[$fn] = ['label' => $label, 'value' => $value];
}

$displayRows = [];
if ($confirmDisplayHook !== null && !empty($confirmDisplayHook['display_order']) && is_array($confirmDisplayHook['display_order'])) {
    $usedInOrder = [];
    foreach ($confirmDisplayHook['display_order'] as $orderFn) {
        $orderFn = is_string($orderFn) ? trim($orderFn) : '';
        if ($orderFn === '' || !isset($displayRowByField[$orderFn])) {
            continue;
        }
        $displayRows[] = $displayRowByField[$orderFn];
        $usedInOrder[$orderFn] = true;
    }
    $seenTail = [];
    foreach ($orderedFields as $fn) {
        if (isset($seenTail[$fn])) {
            continue;
        }
        $seenTail[$fn] = true;
        if (isset($usedInOrder[$fn]) || !isset($displayRowByField[$fn])) {
            continue;
        }
        $displayRows[] = $displayRowByField[$fn];
    }
} else {
    $seenOut = [];
    foreach ($orderedFields as $fn) {
        if (isset($seenOut[$fn])) {
            continue;
        }
        $seenOut[$fn] = true;
        if (!isset($displayRowByField[$fn])) {
            continue;
        }
        $displayRows[] = $displayRowByField[$fn];
    }
}

function renderHiddenFields($post, $excludeKeys = []) {
    $exclude = array_flip(array_merge($excludeKeys, ['submit', '戻る']));
    foreach ($post as $k => $v) {
        if (isset($exclude[$k])) continue;
        if (is_array($v)) {
            foreach ($v as $vk => $vv) {
                echo '<input type="hidden" name="' . htmlspecialchars($k) . '[' . htmlspecialchars($vk) . ']" value="' . htmlspecialchars($vv) . '" />' . "\n";
            }
        } else {
            echo '<input type="hidden" name="' . htmlspecialchars($k) . '" value="' . htmlspecialchars($v) . '" />' . "\n";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja" itemscope itemtype="http://schema.org/Blog">
  <head>
    <meta charset="UTF-8">
    <title>入力の確認 - <?php echo htmlspecialchars($form_title); ?> - レディオキューブFM三重</title>
    <link rel="canonical" href="<?php echo htmlspecialchars($formz_caller_dir); ?>">
    <?php require_once(INCLUDE_HTMLHEAD_PATH); ?>
    <meta property="og:type" content="article">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="入力の確認 - <?php echo htmlspecialchars($form_title); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($formz_caller_dir); ?>">
    <meta property="og:site_name" content="<?php echo htmlspecialchars($form_title); ?>">
    <meta property="og:image" content="/mt7/mt-static/support/theme_static/rainier/img/siteicon-sample.png">
    <meta itemprop="name" content="<?php echo htmlspecialchars($form_title); ?>">
    <link rel="stylesheet" href="/_assets/css/mt-core.css<?php echo isset($themeParam) ? $themeParam : ''; ?>" />
    <link rel="stylesheet" href="<?php echo htmlspecialchars($formz_caller_dir); ?>styles.css<?php echo isset($themeParam) ? $themeParam : ''; ?>" />
    <style>
    .formz-confirm-table { width:100%; border-collapse:collapse; }
    .formz-confirm-th, .formz-confirm-td { padding:0.5rem 1rem; border:1px solid #ddd; text-align:left; vertical-align:top; }
    .formz-confirm-th { background:#f5f5f5; font-weight:600; }
    .formz-confirm-label { width:30%; }
    .formz-confirm-value { word-break:break-all; }
    .form-actions { margin-top:1.5rem; }
    .form-actions form { flex-shrink: 0; }
    .form-actions .formz-btn { min-width: 8em; white-space: nowrap; width: auto; }
    </style>
  </head>
  <body>
<?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>
<main class="section">
  <div class="index-container stack">
    <section class="stack">
      <article class="entry-card stack card-color container stack-lg" role="main">
        <h2 class="entry-title" itemprop="name">入力の確認</h2>
        <p class="stack-md"style="color:red;font-weight:strong">【まだお申込みは完了していません。】</p>
        <p class="stack-md">入力内容をご確認ください。問題なければ「送信」を、修正する場合は「戻る」をクリックしてください。</p>

        <div class="formz-confirm-table-wrapper stack-md">
          <table class="formz-confirm-table">
            <thead>
              <tr>
                <th class="formz-confirm-th">項目名称</th>
                <th class="formz-confirm-th">入力内容</th>
              </tr>
            </thead>
            <tbody>
<?php foreach ($displayRows as $r): ?>
              <tr>
                <td class="formz-confirm-td formz-confirm-label"><?php echo htmlspecialchars($r['label']); ?></td>
                <td class="formz-confirm-td formz-confirm-value"><?php echo nl2br(htmlspecialchars($r['value'])); ?></td>
              </tr>
<?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="form-actions cluster cluster-gap-md">
          <form action="<?php echo htmlspecialchars($formz_caller); ?>" method="post" enctype="multipart/form-data" style="display:inline;">
            <?php renderHiddenFields($_POST, ['g-recaptcha-response']); ?>
            <input type="hidden" name="act" value="0" />
            <input type="hidden" name="formz_confirm_back" value="1" />
            <button type="submit" class="formz-btn formz-btn-back" name="back"><i class="fa-solid fa-angles-left"></i> 戻 る</button>
          </form>
          <form action="<?php echo htmlspecialchars($formz_caller); ?>" method="post" enctype="multipart/form-data" style="display:inline;">
            <?php renderHiddenFields($_POST, ['g-recaptcha-response']); ?>
            <input type="hidden" name="act" value="1" />
            <input type="hidden" name="formz_do_regist" value="1" />
            <button type="submit" class="formz-btn" name="submit">送 信 <i class="fa-solid fa-angles-right"></i></button>
          </form>
        </div>
      </article>
    </section>
  </div>
</main>
<?php require_once(INCLUDE_FOOTER_PATH); ?>
  </body>
</html>
