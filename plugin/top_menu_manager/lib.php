<?php
if (!defined('_GNUBOARD_'))
    exit;

function display_top_menu()
{
    global $g5, $is_member, $is_admin, $config; // Globals needed for the menu skins

    $plugin_path = G5_PLUGIN_PATH . '/top_menu_manager';
    $setting_file = $plugin_path . '/setting.php';

    // Default skin
    $top_menu_skin = 'basic';

    // Load saved setting if exists
    if (file_exists($setting_file)) {
        include($setting_file);
    }

    $skin_path = $plugin_path . '/skins/' . $top_menu_skin;
    $skin_url = G5_PLUGIN_URL . '/top_menu_manager/skins/' . $top_menu_skin;

    // Check if skin exists
    if (!file_exists($skin_path . '/menu.skin.php')) {
        echo '<!-- Selected Top Menu Skin (' . $top_menu_skin . ') not found. -->';
        return;
    }

    // Add Skin CSS
    if (file_exists($skin_path . '/style.css')) {
        echo '<link rel="stylesheet" href="' . $skin_url . '/style.css?ver=' . time() . '">' . PHP_EOL;
    }

    // Include the skin file
    include($skin_path . '/menu.skin.php');
}
?>