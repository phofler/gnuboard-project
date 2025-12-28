<?php
$sub_menu = "800250";
define('G5_IS_ADMIN', true); // 관리자 페이지임을 알림 (중요)

include_once('../../../common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!defined('G5_IS_ADMIN')) {
    alert('관리자만 접근 가능합니다.'); // 혹시 common.php에서 정의 안 됐을 경우 대비
}

if ($is_admin != 'super') {
    // 메뉴 권한 체크
    // $sub_menu(800250) 또는 그룹(800) 권한 확인
    $menu_key = substr($sub_menu, 0, 3);
    if (!isset($auth[$sub_menu]) && (!isset($auth[$menu_key]) || strpos($auth[$menu_key], 'r') === false)) {
        alert('글을 읽을 권한이 없습니다.');
    }
}

// 2차 권한 체크
auth_check_menu($auth, $sub_menu, 'r');
?>