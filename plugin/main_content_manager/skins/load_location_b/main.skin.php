<?php
if (!defined('_GNUBOARD_'))
    exit;

// [Main Content Manager] Skin to Load External 'Company Intro' Content (Location B)

// 1. Get Source ID
$co_id = isset($ms['ms_content_source']) ? $ms['ms_content_source'] : '';

if (!$co_id) {
    if ($g5['is_admin'])
        echo '<div style="text-align:center; padding:20px; background:#fafafa; border:1px dashed #ccc;">[Admin] 회사소개 컨텐츠가 선택되지 않았습니다.</div>';
    return;
}

// 2. Fetch Data
$co_row = sql_fetch(" select * from " . G5_TABLE_PREFIX . "plugin_company_add where co_id = '{$co_id}' ");

if (!$co_row['co_id']) {
    if ($g5['is_admin'])
        echo '<div style="text-align:center; padding:20px; background:#fafafa; border:1px dashed #ccc;">[Admin] 선택된 컨텐츠(ID: ' . $co_id . ')가 존재하지 않습니다.</div>';
    return;
}

// 3. Process Content (Reuse Company Intro Logic)
$view_content = '';
$company_intro_skin_head = G5_PLUGIN_PATH . '/company_intro/skin.head.php';

if (file_exists($company_intro_skin_head)) {
    include($company_intro_skin_head);
} else {
    $view_content = $co_row['co_content'];
}

// 4. Render Output
?>
<div class="main-location-section style-b">
    <?php echo $view_content; ?>
</div>