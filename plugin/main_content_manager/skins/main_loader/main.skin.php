<?php
if (!defined('_GNUBOARD_'))
    exit;
global $is_admin;

/* 
 * [BRIDGE PATTERN] Generic Main Loader
 * Purpose: Bridges content from Company Intro Manager (Manifesto, Map, Inquiry, etc.)
 */

include_once(G5_PLUGIN_PATH . '/company_intro/lib/company.lib.php');

// 1. Get Source ID (Bridge)
$bridge_id = '';
if (isset($ms['ms_content_source']) && $ms['ms_content_source']) {
    $bridge_id = $ms['ms_content_source'];
} elseif (isset($ms_content_source) && $ms_content_source) {
    $bridge_id = $ms_content_source;
}

// 2. Fetch Content
$co = get_plugin_company_content($bridge_id);

// 3. Render
if ($co && $co['co_skin']) {
    $skin_file = G5_PLUGIN_PATH . '/company_intro/skin/' . $co['co_skin'] . '.html';
    if (file_exists($skin_file)) {
        // Pass context if needed
        include($skin_file);
    } else {
        echo '<div class="text-center py-5">Skin file not found: ' . $co['co_skin'] . '</div>';
    }
} else {
    // Fallback: If no bridge connected
    if ($is_admin == 'super') {
        echo '<div style="background:#fff; border:1px dashed #ccc; padding:20px; text-align:center;">';
        echo '<h4 style="color:#e74c3c;">[SYSTEM: Content Bridge Disconnected]</h4>';
        echo '<p>Please link a Company Intro Source (Map, Inquiry, etc.) in <strong>Main Content Manager > Section Settings</strong>.</p>';
        echo '</div>';
    }
}
?>