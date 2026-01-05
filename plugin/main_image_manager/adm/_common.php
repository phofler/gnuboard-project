<?php
define('G5_IS_ADMIN', true);
include_once('../../../common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

// Initialize admin menu cookie array to prevent Undefined Array Key warning in admin.head.php
$adm_menu_cookie = array(
    'container' => '',
    'gnb' => '',
    'btn_gnb' => '',
);
?>