<?php
if (!defined('_GNUBOARD_'))
    exit;

// Define Constants
define('MAP_API_PATH', G5_PLUGIN_PATH . '/map_api');
define('MAP_API_URL', G5_PLUGIN_URL . '/map_api');

// Load Library
include_once(MAP_API_PATH . '/lib/map.lib.php');

// Register Admin Menu
add_replace('admin_menu', 'map_api_admin_menu');

function map_api_admin_menu($menu)
{
    // Add under 'Environment Settings' (menu100)
    $menu['menu100'][] = array(
        '100900',
        '지도 API 관리',
        MAP_API_URL . '/adm/config_form.php',
        'map_api_config'
    );
    return $menu;
}
?>