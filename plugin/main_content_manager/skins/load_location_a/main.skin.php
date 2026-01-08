<?php
if (!defined('_GNUBOARD_'))
    exit;

// [Main Content Manager] Skin to Load External 'Company Intro' Content
// Usage: Selects a 'co_id' from admin and renders it using shared Company Intro logic.

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
// Define path to shared header if not already known, but we know it.
// We need to ensure variables are clean.
$view_content = ''; // defined in skin.head.php but initialized here for safety

// Include skin.head.php from Company Intro plugin
// This file expects $co_row to be set.
$company_intro_skin_head = G5_PLUGIN_PATH . '/company_intro/skin.head.php';

if (file_exists($company_intro_skin_head)) {
    include($company_intro_skin_head);
} else {
    // Fallback if plugin is missing
    $view_content = $co_row['co_content'];
}

// 4. Render Output
// We apply specific classes for 'Location A' if needed, generally just full width.
?>
<div class="main-location-section style-a">
    <?php echo $view_content; ?>
</div>