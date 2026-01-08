<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Top Menu Manager Shared Header
 * - Loads Menu Data
 * - Calculates Logo Source (PC/Mobile/Custom)
 */

// 1. Menu Data Load (Fallback)
if (!isset($menu_datas) || empty($menu_datas)) {
    // get_menu_db function should be available from lib.php included in index/setup
    if (function_exists('get_menu_db')) {
        $menu_datas = get_menu_db(0, true);
    }
}

// 2. Logo Logic
$logo_src = G5_IMG_URL . '/logo.png'; // Default Core Logo
$custom_logo_path = G5_DATA_PATH . '/common/top_logo_dark.png'; // Plugin Custom Logo

if (isset($top_logo_pc) && $top_logo_pc) {
    // Use Configured Logo from DB/Config
    $logo_src = $top_logo_pc . '?v=' . time();
} else if (file_exists($custom_logo_path)) {
    $logo_src = G5_DATA_URL . '/common/top_logo_dark.png?v=' . time();
} else {
    // Windows Path Fallback Check
    $custom_logo_path_win = str_replace('/', '\\', $custom_logo_path);
    if (file_exists($custom_logo_path_win)) {
        $logo_src = G5_DATA_URL . '/common/top_logo_dark.png?v=' . time();
    }
}

// 3. Helper Variables
$is_admin_check = (isset($is_admin) && $is_admin === 'super');
?>