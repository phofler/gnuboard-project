<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Get Copyright Configuration
 */
function get_copyright_config()
{
    global $g5;
    $table_name = G5_TABLE_PREFIX . 'copyright_config';

    // Check if table exists
    $row = sql_fetch(" SHOW TABLES LIKE '{$table_name}' ");
    if (!$row)
        return array();

    $cp = sql_fetch(" select * from {$table_name} where id = 1 ");
    return $cp;
}

/**
 * Display Footer Information
 * This function handles CSS inclusion and returns skin path
 */
function display_footer_info()
{
    global $g5, $config;

    $plugin_path = G5_PLUGIN_PATH . '/copyright_manager';
    $setting_file = $plugin_path . '/setting.php';

    // Default skin
    $footer_skin = 'style_a';

    if (file_exists($setting_file)) {
        include($setting_file);
    }

    $cp = get_copyright_config();
    if (!$cp)
        return;

    $skin_path = $plugin_path . '/skins/' . $footer_skin;
    $skin_url = G5_PLUGIN_URL . '/copyright_manager/skins/' . $footer_skin;

    if (!file_exists($skin_path . '/footer.skin.php')) {
        return;
    }

    // Include Skin CSS
    if (file_exists($skin_path . '/style.css')) {
        echo '<link rel="stylesheet" href="' . $skin_url . '/style.css?ver=' . time() . '">' . PHP_EOL;
    }

    // Include the skin file
    include($skin_path . '/footer.skin.php');
}
?>