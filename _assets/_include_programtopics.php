<?php
/**
 * プログラムトピック表示
 * _program_rdf.jsonからデータを読み込んで表示
 */

// functions.phpを読み込む（既に読み込まれている場合はスキップ）
if (!function_exists('load_program_rdf')) {
    require_once(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/_assets/apps/functions.php');
}

// JSONファイルからデータを読み込む
$programs = load_program_rdf();

// データが取得できなかった場合は何も表示しない
if ($programs === false || empty($programs)) {
    echo '<!-- プログラムトピックデータが見つかりません -->';
    return;
}

// 表示件数を制限（必要に応じて調整）
$displayLimit = 8;
$programs = array_slice($programs, 0, $displayLimit);

?>
<div class="topic-corner-grid">
<?php foreach ($programs as $program): ?>
    <a href="<?php echo h($program['entry_url'] ?? $program['url'] ?? '#'); ?>" class="topic-corner">
        <div class="topic-corner__thumb">
            <img src="<?php echo h($program['img'] ?? ''); ?>" alt="<?php echo h($program['title'] ?? ''); ?>">
        </div>
<?php if (!empty($program['entry_title'])): ?>
<?php
    $entryTitle = $program['entry_title'];
    if (mb_strlen($entryTitle) > 36) {
        $entryTitle = mb_substr($entryTitle, 0, 36) . '...';
    }
?>
        <p class="topic-corner-desc"><?php echo h($entryTitle); ?></p>
<?php endif; ?>
        <div class="topic-corner-meta">
            <span class="topic-corner-meta__item">
<?php if (!empty($program['updated'])): ?>
<?php
    // 日付を month/day 形式に変換
    $dateStr = $program['updated'];
    // "2026/01/24 21:07:28" から "01/24" に変換
    if (preg_match('/^(\d{4})\/(\d{2})\/(\d{2})/', $dateStr, $matches)) {
        $formattedDate = $matches[2] . '/' . $matches[3];
    } else {
        $formattedDate = $dateStr;
    }
?>
                <span class="topic-corner-meta__date"><?php echo h($formattedDate); ?></span>
<?php endif; ?>
                <span class="topic-corner-meta__title"><?php echo h($program['title'] ?? ''); ?></span>
            </span>
        </div>
    </a>
<?php endforeach; ?>
</div>