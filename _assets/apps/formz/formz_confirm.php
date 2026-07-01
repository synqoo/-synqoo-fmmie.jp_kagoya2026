<?php
/**
 * フォーム送信確認画面（formdef.json 統一スキーム検証用）
 *
 * 本番 formz_confirm.php は触らず、並走テスト用に本ファイルを使用する。
 * テストフォームの PHP から require すること:
 *   require_once(...'/formz_confirm_test.php');
 *
 * データ取得:
 *   formz_load_config_file / formz_load_config_file_with_fallback（functions.php 経由）
 *   1. formdef.json … fmmie.backsite.pro（kinkyuformz=1 時はローカル formzconfig）
 *   2. フォールバック … backsite.pro レガシー setbody + formztemp（§6-1）
 *
 * 優先順位（ラベル・値・並び）:
 *   formdef 自動 → confirm_display/{id}.php 手動上書き（最優先）→ x_prez 特例
 *
 * 本番化: ファイル名から _test を除き formz_confirm.php にリネーム（または差し替え）。
 *          リネーム時は下記 $formzConfirmShowDebug を false に変更する。
 *
 * @see backsite.pro/docs/21_formdef-json-unified-impl.md §4-1
 */
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/config.php');
session_start();
require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/functions.php');

// --- 本番化時は false（黄色デバッグバナー・[TEST] タイトル接頭辞を非表示） ---
$formzConfirmShowDebug = false;

$formz_caller = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '/';
$formz_caller_dir = 'https://fmmie.jp' . rtrim(dirname($formz_caller), '/\\') . '/';

if (empty($_POST) || !isset($_POST['act']) || $_POST['act'] != '1') {
    header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $formz_caller));
    exit;
}

$fm_id = isset($_POST['form_id']) ? (int)$_POST['form_id'] : 0;
formz_config($fm_id);

$form_title = isset($_POST['form_title']) ? $_POST['form_title'] : '入力の確認';

viewformztemp();

/**
 * 選択肢 index → 文言。非数値は生値のまま（旧 p_sex='女性' 混在対策。21 §3-4）
 *
 * @param  list<string>  $choices
 */
function formz_confirm_test_resolve_choice_label(array $choices, $value): string
{
    if ($value === null || $value === '') {
        return '';
    }
    if ($choices === []) {
        return (string)$value;
    }
    $valueString = trim((string)$value);
    if ($valueString === '') {
        return '';
    }
    if (!preg_match('/^\d+$/', $valueString)) {
        return $valueString;
    }
    $idx = (int)$valueString;

    return isset($choices[$idx]) ? (string)$choices[$idx] : $valueString;
}

/**
 * setbody.txt（=fm_body）を行単位で解析し、フィールド名キーのラベル・選択肢・順序を得る。
 *
 * @param  string|false  $setbodyContent
 * @param  array<int|string, array<int, string>>  $formztemp
 * @return array{
 *     fieldLabels: array<string, string>,
 *     fieldChoices: array<string, list<string>>,
 *     orderedFields: list<string>,
 *     explicitLabels: array<string, string>
 * }
 */
function formz_confirm_test_parse_setbody_maps($setbodyContent, array $formztemp, array $typeNames): array
{
    $fieldLabels = [];
    $fieldChoices = [];
    $orderedFields = [];
    $explicitLabels = [];
    $seenNames = [];

    if ($setbodyContent === false) {
        return [
            'fieldLabels' => $fieldLabels,
            'fieldChoices' => $fieldChoices,
            'orderedFields' => $orderedFields,
            'explicitLabels' => $explicitLabels,
        ];
    }

    foreach (explode("\n", (string) $setbodyContent) as $line) {
        $line = trim(str_replace(["\r\n", "\r", "\n"], '', $line));
        if ($line === '') {
            continue;
        }

        $cols = explode(',', $line);
        $itemRaw = trim((string) ($cols[0] ?? ''));
        if ($itemRaw === 'h' || $itemRaw === 'r') {
            continue;
        }
        if (! preg_match('/^(\d+)/', $itemRaw, $matches)) {
            continue;
        }

        $fieldId = (int) $matches[1];
        $tempRow = $formztemp[$fieldId] ?? $formztemp[(string) $fieldId] ?? null;
        if (! is_array($tempRow)) {
            continue;
        }

        $fieldName = trim((string) ($tempRow[2] ?? ''));
        if ($fieldName === '') {
            continue;
        }

        $options = strtolower(trim((string) ($tempRow[4] ?? '')));
        if ($options === 'hidden') {
            continue;
        }
        if (in_array(strtolower($fieldName), $typeNames, true)) {
            continue;
        }
        if (isset($seenNames[$fieldName])) {
            continue;
        }
        $seenNames[$fieldName] = true;

        $labelOverride = trim((string) ($cols[1] ?? ''));
        $defaultLabel = trim((string) ($tempRow[1] ?? ''));
        $label = $labelOverride !== '' ? $labelOverride : $defaultLabel;
        if ($labelOverride !== '') {
            $explicitLabels[$fieldName] = $labelOverride;
        }
        if ($label !== '') {
            $fieldLabels[$fieldName] = $label;
        }

        $choicesRaw = trim((string) ($cols[3] ?? ''));
        $choices = [];
        if ($choicesRaw !== '') {
            foreach (explode(';', $choicesRaw) as $part) {
                $part = trim($part);
                if ($part !== '') {
                    $choices[] = $part;
                }
            }
        }
        $fieldChoices[$fieldName] = $choices;
        $orderedFields[] = $fieldName;
    }

    return [
        'fieldLabels' => $fieldLabels,
        'fieldChoices' => $fieldChoices,
        'orderedFields' => $orderedFields,
        'explicitLabels' => $explicitLabels,
    ];
}

/**
 * formdef.json の fields[] からラベル・選択肢・順序を得る。
 *
 * @param  array<string, mixed>  $formDef
 * @return array{
 *     fieldLabels: array<string, string>,
 *     fieldChoices: array<string, list<string>>,
 *     orderedFields: list<string>,
 *     displayOrder: list<string>
 * }
 */
function formz_confirm_test_parse_formdef_maps(array $formDef): array
{
    $fieldLabels = [];
    $fieldChoices = [];
    $orderedFields = [];

    $fieldsSorted = $formDef['fields'] ?? [];
    if (! is_array($fieldsSorted)) {
        $fieldsSorted = [];
    }
    usort($fieldsSorted, static function (array $a, array $b): int {
        return ((int) ($a['order'] ?? 0)) <=> ((int) ($b['order'] ?? 0));
    });

    foreach ($fieldsSorted as $field) {
        if (! is_array($field)) {
            continue;
        }
        $name = isset($field['name']) ? trim((string) $field['name']) : '';
        if ($name === '') {
            continue;
        }
        $orderedFields[] = $name;

        $label = isset($field['label']) ? trim((string) $field['label']) : '';
        if ($label !== '') {
            $fieldLabels[$name] = $label;
        }

        $choices = [];
        if (! empty($field['choices']) && is_array($field['choices'])) {
            foreach ($field['choices'] as $choiceLabel) {
                $choices[] = (string) $choiceLabel;
            }
        }
        $fieldChoices[$name] = $choices;
    }

    $displayOrder = $orderedFields;
    if (! empty($formDef['confirm']['display_order']) && is_array($formDef['confirm']['display_order'])) {
        $displayOrder = $formDef['confirm']['display_order'];
    }

    return [
        'fieldLabels' => $fieldLabels,
        'fieldChoices' => $fieldChoices,
        'orderedFields' => $orderedFields,
        'displayOrder' => $displayOrder,
    ];
}

// --- formdef.json 取得（新環境。未生成時は setbody フォールバック） ---
$formDef = formz_load_config_formdef($fm_id);
$formDefFetchStatus = $formDef !== null ? 'ok' : 'failed';

$configSource = 'none';
$fieldLabels = [];
$fieldChoices = [];
$orderedFields = [];
$formDefDisplayOrder = [];
$setbodySource = '';

$typeNames = ['number', 'varchar', 'text', 'date', 'ind'];

// setbody は formdef 成否にかかわらず取得（フォールバック／ラベル補完用）
$setbodyContent = formz_load_config_file_with_fallback($fm_id, 'setbody.txt', $setbodySource);
$setbodyMaps = formz_confirm_test_parse_setbody_maps($setbodyContent, $formztemp, $typeNames);

if ($formDef !== null && ! empty($formDef['fields']) && is_array($formDef['fields'])) {
    $configSource = 'formdef';
    $formdefMaps = formz_confirm_test_parse_formdef_maps($formDef);
    $fieldLabels = $formdefMaps['fieldLabels'];
    $fieldChoices = $formdefMaps['fieldChoices'];
    $orderedFields = $formdefMaps['orderedFields'];
    $formDefDisplayOrder = $formdefMaps['displayOrder'];

    // setbody の col1 明示ラベルは formdef より優先（fm_body 直近保存分を反映）
    foreach ($setbodyMaps['explicitLabels'] as $name => $setbodyLabel) {
        if ($setbodyLabel !== '') {
            $fieldLabels[$name] = $setbodyLabel;
        }
    }
    foreach ($setbodyMaps['fieldLabels'] as $name => $setbodyLabel) {
        if ($setbodyLabel !== '' && ! isset($fieldLabels[$name])) {
            $fieldLabels[$name] = $setbodyLabel;
        }
    }
    foreach ($setbodyMaps['fieldChoices'] as $name => $setbodyChoices) {
        if ($setbodyChoices !== [] && (! isset($fieldChoices[$name]) || $fieldChoices[$name] === [])) {
            $fieldChoices[$name] = $setbodyChoices;
        }
    }
} elseif ($setbodyContent !== false) {
    $configSource = 'setbody';
    $fieldLabels = $setbodyMaps['fieldLabels'];
    $fieldChoices = $setbodyMaps['fieldChoices'];
    $orderedFields = $setbodyMaps['orderedFields'];
    $formDefDisplayOrder = [];
} else {
    // 最終フォールバック: formztemp のみ（従来 formz_confirm.php 相当）
    if (isset($formztemp) && is_array($formztemp)) {
        foreach ($formztemp as $row) {
            $fieldName = isset($row[2]) ? trim($row[2]) : '';
            if ($fieldName === '' || (isset($row[4]) && strtolower(trim($row[4])) === 'hidden')) {
                continue;
            }
            if (in_array(strtolower($fieldName), $typeNames, true)) {
                continue;
            }
            $defaultLabel = isset($row[1]) ? trim($row[1]) : '';
            if ($defaultLabel !== '') {
                $fieldLabels[$fieldName] = $defaultLabel;
            }
        }
    }
    foreach ($formztemp as $row) {
        $fieldName = isset($row[2]) ? trim($row[2]) : '';
        if ($fieldName === '' || (isset($row[4]) && strtolower(trim($row[4])) === 'hidden')) {
            continue;
        }
        if (in_array(strtolower($fieldName), $typeNames, true)) {
            continue;
        }
        $orderedFields[] = $fieldName;
    }
}

// --- 以下、旧 setbody ブロック削除済み ---

// --- プレゼント（x_prez）: formz_load_config_file_with_fallback（新環境 → レガシー） ---
$prezValueToName = [];
$prezContent = formz_load_config_file_with_fallback($fm_id, 'prez.txt');
if ($prezContent !== false) {
    $prezLines = array_filter(array_map('trim', explode("\n", $prezContent)));
    foreach ($prezLines as $prezLine) {
        $parts = explode(';', $prezLine);
        if (isset($parts[0], $parts[1]) && $parts[0] !== '') {
            $prezValueToName[trim($parts[1])] = trim($parts[0]);
        }
    }
}

// --- confirm_display/{id}.php（手動上書き・最優先） ---
$confirmDisplayHook = null;
$confirmDisplayPath = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/formz/confirm_display/' . $fm_id . '.php';
if (is_file($confirmDisplayPath)) {
    $loadedHook = require $confirmDisplayPath;
    $confirmDisplayHook = is_array($loadedHook) ? $loadedHook : null;
}

// --- 表示行の組み立て ---
$displayRowByField = [];
$seenBuild = [];
foreach ($orderedFields as $fn) {
    if (isset($seenBuild[$fn])) {
        continue;
    }
    $seenBuild[$fn] = true;
    if (!isset($_POST[$fn])) {
        continue;
    }

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
    } elseif (isset($fieldChoices[$fn]) && $fieldChoices[$fn] !== []) {
        $value = formz_confirm_test_resolve_choice_label($fieldChoices[$fn], $value);
    }

    if ($fn === 'x_prez' && !empty($prezValueToName)) {
        $valueKey = (string)$value;
        $value = isset($prezValueToName[$valueKey]) ? $prezValueToName[$valueKey] : $value;
    }

    $displayRowByField[$fn] = ['label' => $label, 'value' => $value];
}

// --- 並び順: confirm_display → formdef.confirm.display_order → orderedFields ---
$displayRows = [];
$orderList = [];

if ($confirmDisplayHook !== null && !empty($confirmDisplayHook['display_order']) && is_array($confirmDisplayHook['display_order'])) {
    $orderList = $confirmDisplayHook['display_order'];
} elseif ($formDefDisplayOrder !== []) {
    $orderList = $formDefDisplayOrder;
} else {
    $orderList = $orderedFields;
}

if ($orderList !== []) {
    $usedInOrder = [];
    foreach ($orderList as $orderFn) {
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

function renderHiddenFields($post, $excludeKeys = [])
{
    $exclude = array_flip(array_merge($excludeKeys, ['submit', '戻る']));
    foreach ($post as $k => $v) {
        if (isset($exclude[$k])) {
            continue;
        }
        if (is_array($v)) {
            foreach ($v as $vk => $vv) {
                echo '<input type="hidden" name="' . htmlspecialchars($k) . '[' . htmlspecialchars($vk) . ']" value="' . htmlspecialchars($vv) . '" />' . "\n";
            }
        } else {
            echo '<input type="hidden" name="' . htmlspecialchars($k) . '" value="' . htmlspecialchars($v) . '" />' . "\n";
        }
    }
}

$configSourceLabel = [
    'formdef' => 'formdef.json（fmmie.backsite.pro）',
    'setbody' => 'setbody.txt フォールバック',
    'none' => '設定未取得（formztemp のみ）',
];
$configFileSourceLabels = [
    'remote' => 'fmmie.backsite.pro',
    'local' => 'local formzconfig',
    'legacy' => 'backsite.pro (legacy)',
    'none' => 'なし',
];
$setbodySourceLabel = isset($configFileSourceLabels[$setbodySource])
    ? $configFileSourceLabels[$setbodySource]
    : ($setbodySource === '' ? 'なし' : $setbodySource);
?>
<!DOCTYPE html>
<html lang="ja" itemscope itemtype="http://schema.org/Blog">
  <head>
    <meta charset="UTF-8">
    <title><?php echo !empty($formzConfirmShowDebug) ? '[TEST] ' : ''; ?>入力の確認 - <?php echo htmlspecialchars($form_title); ?> - レディオキューブFM三重</title>
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
    <?php if (!empty($formzConfirmShowDebug)): ?>
    .formz-confirm-test-banner { background:#fff3cd; border:1px solid #ffc107; padding:0.5rem 1rem; font-size:0.875rem; color:#664d03; }
    <?php endif; ?>
    </style>
  </head>
  <body>
<?php require_once(INCLUDE_GLOBALHEADER_PATH); ?>
<main class="section">
  <div class="index-container stack">
    <section class="stack">
      <article class="entry-card stack card-color container stack-lg" role="main">
        <?php if (!empty($formzConfirmShowDebug)): ?>
        <p class="formz-confirm-test-banner" role="status">
          <strong>formz_confirm_test</strong> — form_id=<?php echo (int)$fm_id; ?> /
          設定ソース: <?php echo htmlspecialchars($configSourceLabel[$configSource] ?? $configSource); ?>
          / formdef取得: <?php echo htmlspecialchars($formDefFetchStatus); ?>
          / setbody: <?php echo htmlspecialchars($setbodySourceLabel); ?>
          <?php if ($confirmDisplayHook !== null): ?> / confirm_display 上書きあり<?php endif; ?>
          <?php if ($configSource !== 'formdef'): ?>
          <br /><small>※「性別2」等の旧ラベルは formdef 未取得時の formztemp デフォルトです。fmmie.backsite.pro に <?php echo (int)$fm_id; ?>_formdef.json を公開してください。</small>
          <?php endif; ?>
        </p>
        <?php endif; ?>
        <h2 class="entry-title" itemprop="name">入力の確認</h2>
        <p class="stack-md" style="color:red;font-weight:strong">【まだお申込みは完了していません。】</p>
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
