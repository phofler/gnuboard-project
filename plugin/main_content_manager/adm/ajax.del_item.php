<?php
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!defined('G5_IS_ADMIN')) {
    die('접근 권한이 없습니다.');
}

$del_id = isset($_POST['mc_id']) ? (int) $_POST['mc_id'] : 0;
if (!$del_id) {
    die('삭제할 ID가 없습니다.');
}

// 이미지 파일 삭제 로직 추가 (선택사항이나 권장)
$row = sql_fetch(" select mc_image from g5_plugin_main_content where mc_id = '{$del_id}' ");
if ($row['mc_image'] && !preg_match("/^(http|https):/i", $row['mc_image'])) {
    $upload_dir = G5_DATA_PATH . '/main_content';
    @unlink($upload_dir . '/' . $row['mc_image']);
}

sql_query(" DELETE FROM `g5_plugin_main_content` WHERE mc_id = '{$del_id}' ");
echo "OK";
?>