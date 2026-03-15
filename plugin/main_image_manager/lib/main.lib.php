<?php
if (!defined('_GNUBOARD_'))
    exit;

// Main Image Manager Library - ID Based Rendering (Modularized)

function get_main_visual_config($mi_id = '')
{
    global $g5, $config;
    $config_table = G5_TABLE_PREFIX . 'plugin_main_image_config';

    if (!$mi_id) {
        $mi_id = (isset($config['cf_theme']) && $config['cf_theme']) ? $config['cf_theme'] : 'default';
    }

    $res = sql_query(" SHOW TABLES LIKE '{$config_table}' ");
    if (!sql_num_rows($res))
        return null;

    $row = sql_fetch(" select * from {$config_table} where mi_id = '{$mi_id}' ");

    if (!$row && strpos($mi_id, '_') === false) {
        $row = sql_fetch(" select * from {$config_table} where mi_id = '{$mi_id}_ko' ");
        if (!$row) {
            $row = sql_fetch(" select * from {$config_table} where mi_id = '{$mi_id}_kr' ");
        }
    }

    if (!$row && $mi_id != 'default') {
        $row = sql_fetch(" select * from {$config_table} where mi_id = 'default' ");
    }
    return $row;
}

function get_main_slides($mi_id)
{
    global $g5;
    $data_table = "g5_plugin_main_image_add";

    if (!sql_query(" DESCRIBE {$data_table} ", false)) {
        return array();
    }

    $sql = " select * from {$data_table} where mi_style = '{$mi_id}' order by mi_sort asc, mi_id asc ";
    $result = sql_query($sql);
    $slides = array();
    while ($row = sql_fetch_array($result)) {
        // [Modularized] Use project_utils global helper for asset URL
        $row['img_url'] = function_exists('get_project_asset_url') ? get_project_asset_url($row['mi_image']) : $row['mi_image'];
        
        $mobile_asset = isset($row['mi_image_mobile']) ? $row['mi_image_mobile'] : '';
        $row['img_mobile_url'] = function_exists('get_project_asset_url') ? get_project_asset_url($mobile_asset) : $mobile_asset;
        
        $slides[] = $row;
    }
    return $slides;
}

function display_main_visual($mi_id = '')
{
    global $g5;

    $config = get_main_visual_config($mi_id);
    if (!$config) return;

    $skin_name = $config['mi_skin'];
    $actual_id = $config['mi_id'];

    $slides = get_main_slides($actual_id);
    if (count($slides) == 0) return;

    $skin_path = G5_PLUGIN_PATH . '/main_image_manager/skins/' . $skin_name;
    $skin_url = G5_PLUGIN_URL . '/main_image_manager/skins/' . $skin_name;
    $skin_file = $skin_path . '/main.skin.php';
    $css_file = $skin_path . '/style.css';

    if (file_exists($css_file)) {
        echo '<link rel="stylesheet" href="' . $skin_url . '/style.css?v=' . time() . '">' . PHP_EOL;
    }

    if (file_exists($skin_file)) {
        include($skin_file);
    }
}
