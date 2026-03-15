<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

/**
 * Proxy Content Skin for Company Intro Plugin
 * 
 * Purpose: 
 * Bridges the Core Content System (g5_content) with the Company Intro Plugin (g5_plugin_company_add).
 * Automatically finds the correct Plugin ID based on the current Theme and Language.
 * 
 * Logic:
 * 1. Detects Active Theme (e.g. 'corporate')
 * 2. Detects Language (e.g. 'kr')
 * 3. Constructs Target ID: {Theme}_{Lang}_{ContentID} (e.g. 'corporate_company')
 * 4. Fetches Plugin Data and renders via view.php
 */

// 1. Get Current Theme Name
global $config;
$current_theme = isset($config['cf_theme']) ? $config['cf_theme'] : 'corporate';

// 2. Determine Language (Default: kr)
// Logic: Cookie > GET > Default
$lang = 'kr';
if (isset($g5['lang']))
    $lang = $g5['lang']; // If globally set
if (isset($_GET['lang']))
    $lang = clean_xss_tags($_GET['lang']); // URL override

// 3. Construct Proxy ID
// Logic:
// - Default: Uses 'co_id' from URL (e.g. 'company') -> 'corporate_company'
// - Dynamic: Uses 'pid' parameter if present (e.g. 'ceo') -> 'corporate_ceo'
// This allows ONE core content entry ('company') to serve multiple plugin pages.

$content_key = $co_id; // Default to the co_id (the bridge ID)
if (isset($_GET['pid']) && $_GET['pid']) {
    $content_key = clean_xss_tags($_GET['pid']);
}

$target_id = $current_theme . '_' . $content_key;

// [Fallback Support]
// Sometimes ID might include lang suffix like 'corporate_en_company', but our convention is 'corporate_company' (default lang hidden)
// Let's check DB for exact match first.

// 4. Query Plugin Table
$plugin_table = G5_TABLE_PREFIX . 'plugin_company_add';
$co_row = sql_fetch(" select * from {$plugin_table} where co_id = '{$target_id}' ");

if (!$co_row['co_id']) {
    // Retry with Lang specific
    $target_id_lang = $current_theme . '_' . $lang . '_' . $content_key;
    $co_row = sql_fetch(" select * from {$plugin_table} where co_id = '{$target_id_lang}' ");
}

if (!$co_row['co_id']) {
    // Retry with Raw ID (In case user put 'corporate_company' in the URL directly)
    $co_row = sql_fetch(" select * from {$plugin_table} where co_id = '{$co_id}' ");
}

// 5. Render
if ($co_row['co_id']) {
    // Found Plugin Content!
    // We need to include the plugin's view.php which handles the sophisticated layout
    $plugin_view_path = G5_PLUGIN_PATH . '/company_intro/view.php';
    if (file_exists($plugin_view_path)) {
        // [Important] view.php expects $co_row to be set
        include($plugin_view_path);
    } else {
        echo '<div class="sub-layout-width-height text-center py-5">Plugin View file not found.</div>';
    }
} else {
    // Not Found in Plugin either
    echo '<div class="sub-layout-width-height text-center py-5">';
    echo '<h3>Content Not Found</h3>';
    echo '<p class="mt-3 text-muted">Requested ID: ' . $content_key . '<br>Target Plugin ID: ' . $target_id . '</p>';

    if ($is_admin) {
        echo '<div class="mt-4 alert alert-warning" style="display:inline-block; text-align:left;">';
        echo '<strong>[Admin Debug]</strong><br>';
        echo '1. Please check if ID <code>' . $target_id . '</code> exists in Company Intro Admin.<br>';
        echo '2. Ensure your Theme Name matches the ID prefix.<br>';
        echo '</div>';
    }
    echo '</div>';
}
?>