<?php
if (!defined('_GNUBOARD_'))
    exit;

if (isset($menu['menu800'])) {
    $menu['menu800'][] = array('800350', '카피라이트 관리', G5_PLUGIN_URL . '/copyright_manager/adm/list.php', 'copyright_manager');
}
?>