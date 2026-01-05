<?php
define('_GNUBOARD_ADMIN_', true);
include_once('./_common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!defined('G5_IS_ADMIN')) {
    header('Content-Type: application/json');
    die(json_encode(array('result' => false, 'message' => '접근 권한이 없습니다.')));
}

header('Content-Type: application/json');

$del_id = isset($_POST['mi_id']) ? (int) $_POST['mi_id'] : 0;
if (!$del_id) {
    die(json_encode(array('result' => false, 'message' => '삭제할 ID가 없습니다.')));
}

sql_query(" DELETE FROM `g5_plugin_main_image_add` WHERE mi_id = '{$del_id}' ");
die(json_encode(array('result' => true)));
?>