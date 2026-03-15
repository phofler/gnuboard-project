<?php
include_once('./_common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

header('Content-Type: application/json; charset=utf-8');

// [SECURITY] Admin check
if (!$is_admin) {
    echo json_encode(array('error' => '관리자 권한이 없습니다.'));
    exit;
}

// [SECURITY] Token check
if (!check_admin_token()) {
    echo json_encode(array('error' => '토큰이 유효하지 않거나 만료되었습니다.'));
    exit;
}

$mc_id = isset($_POST['mc_id']) ? (int) $_POST['mc_id'] : 0;

if (!$mc_id) {
    echo json_encode(array('error' => '잘못된 접근입니다. (ID 누락)'));
    exit;
}

// [MIGRATION-FREE] Just clear the image path
$sql = " update g5_plugin_main_content set mc_image = '' where mc_id = '{$mc_id}' ";
if (sql_query($sql)) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('error' => '데이터베이스 업데이트에 실패했습니다.'));
}
?>