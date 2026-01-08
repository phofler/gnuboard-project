<?php
if (!defined('_GNUBOARD_'))
    exit;

// Main Image Manager Library - ID Based Rendering

function get_main_visual_config($mi_id = '')
{
    global $g5, $config;
    $config_table = G5_TABLE_PREFIX . 'plugin_main_image_config';

    // If ID is empty, try active theme name first
    if (!$mi_id) {
        $mi_id = (isset($config['cf_theme']) && $config['cf_theme']) ? $config['cf_theme'] : 'default';
    }

    // Check if table exists
    $res = sql_query(" SHOW TABLES LIKE '{$config_table}' ");
    if (!sql_num_rows($res))
        return null;

    $row = sql_fetch(" select * from {$config_table} where mi_id = '{$mi_id}' ");
    if (!$row && $mi_id != 'default') {
        // Fallback to 'default' if the requested ID doesn't exist
        $row = sql_fetch(" select * from {$config_table} where mi_id = 'default' ");
    }
    return $row;
}

function get_main_slides($mi_id)
{
    global $g5;
    $data_table = "g5_plugin_main_image_add";

    // Table check
    if (!sql_query(" DESCRIBE {$data_table} ", false)) {
        return array();
    }

    // Query slides belonging to the specific Group ID
    $sql = " select * from {$data_table} where mi_style = '{$mi_id}' order by mi_sort asc, mi_id asc ";
    $result = sql_query($sql);
    $slides = array();
    while ($row = sql_fetch_array($result)) {
        $img_src = '';
        if ($row['mi_image']) {
            if (preg_match("/^(http|https):/i", $row['mi_image'])) {
                $img_src = $row['mi_image'];
            } else {
                // Priority: common_assets -> main_visual (legacy)
                if (file_exists(G5_DATA_PATH . '/common_assets/' . $row['mi_image'])) {
                    $img_src = G5_DATA_URL . '/common_assets/' . $row['mi_image'];
                } else if (file_exists(G5_DATA_PATH . '/main_visual/' . $row['mi_image'])) {
                    $img_src = G5_DATA_URL . '/main_visual/' . $row['mi_image'];
                } else {
                    $img_src = G5_DATA_URL . '/common_assets/' . $row['mi_image']; // Fallback
                }
            }
        }
        $row['img_url'] = $img_src;
        $slides[] = $row;
    }
    return $slides;
}

function display_main_visual($mi_id = '')
{
    global $g5;

    // 1. Get Group Configuration
    $config = get_main_visual_config($mi_id);
    if (!$config)
        return;

    $skin_name = $config['mi_skin'];
    $actual_id = $config['mi_id']; // Use the actual ID found (might be 'default' fallback)

    // 2. Get Data for this ID
    $slides = get_main_slides($actual_id);

    // If no slides, do nothing
    if (count($slides) == 0)
        return;

    // 3. Skin Path & URL
    $skin_path = G5_PLUGIN_PATH . '/main_image_manager/skins/' . $skin_name;
    $skin_url = G5_PLUGIN_URL . '/main_image_manager/skins/' . $skin_name;
    $skin_file = $skin_path . '/main.skin.php';
    $css_file = $skin_path . '/style.css';

    // 4. Load Skin CSS
    if (file_exists($css_file)) {
        add_stylesheet('<link rel="stylesheet" href="' . $skin_url . '/style.css?v=' . time() . '">', 0);
    }

    // 5. Include Skin PHP
    if (file_exists($skin_file)) {
        include($skin_file);
    } else {
        echo "<!-- Main Image Skin not found: {$skin_name} -->";
    }
}
?>