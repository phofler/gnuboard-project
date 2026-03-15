<?php
if (!defined('_GNUBOARD_'))
    exit;

include_once(dirname(__FILE__) . '/_common.php');
include_once(dirname(__FILE__) . '/lib/latest_skin.lib.php');

// Register Admin Menu
// Register Admin Menu (Disabled - Managed by adm/admin.menu950_theme.php)
// add_replace('admin_menu', 'latest_skin_manager_admin_menu');

/*
function latest_skin_manager_admin_menu($menu)
{
    // Add to 'Environment' or 'Board' section? 
    // User wants "보드최근글스킨관리". Let's put it next to Board Skin Manager (300).
    $menu['menu300'][] = array(
        '300910',
        '보드최근글스킨관리',
        G5_PLUGIN_URL . '/latest_skin_manager/adm/list.php',
        'latest_skin_manager'
    );
    return $menu;
}
*/
?>