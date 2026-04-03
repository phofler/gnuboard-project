<?php
if (!defined('_GNUBOARD_'))
    exit;
global $is_admin;

/* 
 * [BRIDGE PATTERN] Generic Main Loader (Refactored for Standardization)
 * Purpose: Bridges content from Company Intro Manager with dynamic placeholder expansion.
 */

include_once(G5_PLUGIN_PATH . '/company_intro/lib/company.lib.php');
include_once(G5_LIB_PATH . '/premium_module.lib.php');

// 1. Get Source ID (Bridge)
$bridge_id = '';
if (isset($ms['ms_content_source']) && $ms['ms_content_source']) {
    $bridge_id = $ms['ms_content_source'];
} elseif (isset($ms_content_source) && $ms_content_source) {
    $bridge_id = $ms_content_source;
}

// 2. Fetch Content and expand placeholders
$co = get_plugin_company_content($bridge_id);

if ($co && $co['co_skin']) {
    $skin_file = G5_PLUGIN_PATH . '/company_intro/skin/' . $co['co_skin'] . '.html';
    if (file_exists($skin_file)) {
        // [DYNAMIC EXPANSION]
        $html = file_get_contents($skin_file);
        
        // Use global premium module framework to expand tokens
        if (function_exists('expand_premium_placeholder')) {
            $html = expand_premium_placeholder($html, $bridge_id);
        }
        
        echo $html;
    } else {
        echo '<div class="text-center py-5">Skin file not found: ' . $co['co_skin'] . '</div>';
    }
} else {
    if ($is_admin == 'super') {
        echo '<div style="background:#fff; border:1px dashed #ccc; padding:20px; text-align:center;">';
        echo '<h4 style="color:#e74c3c;">[SYSTEM: Content Bridge Disconnected]</h4>';
        echo '<p>Please link a Company Intro Source (Map, Inquiry, etc.) in <strong>Main Content Manager > Section Settings</strong>.</p>';
        echo '</div>';
    }
}
?>