<?php
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!defined('G5_IS_ADMIN')) {
    die('접근 권한이 없습니다.');
}

$del_id = isset($_POST['mi_id']) ? (int) $_POST['mi_id'] : 0;
if (!$del_id) {
    die('삭제할 ID가 없습니다.');
}

sql_query(" DELETE FROM `g5_plugin_main_image_add` WHERE mi_id = '{$del_id}' ");
echo "OK";
?>