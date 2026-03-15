<?php
// adm/ajax.unified_image_delete.php
// 그누보드 핵심 정의를 가장 먼저 선언하여 인증 우회나 리다이렉트를 방지합니다.
define('_GNUBOARD_', true);
define('G5_IS_ADMIN', true);
define('_GNUBOARD_ADMIN_', true);

include_once('../common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

header('Content-Type: application/json; charset=utf-8');

// [SECURITY] 최고관리자 또는 관리자 권한 체크
if (!$is_admin) {
    die(json_encode(array('error' => '관리자 권한이 없습니다. 다시 로그인해 주세요.')));
}

// [SECURITY] 토큰 체크
if (!check_admin_token()) {
    die(json_encode(array('error' => '보안 토큰이 만료되었습니다. 페이지를 새로고침 후 다시 시도해 주세요.')));
}

$type = isset($_POST['type']) ? clean_xss_tags($_POST['type']) : '';
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

if (!$type || !$id) {
    die(json_encode(array('error' => '잘못된 접근입니다.')));
}

// 라이브러리 로드 (절대 경로 사용)
$lib_file = G5_PATH.'/extend/project_image.extend.php';
if (!function_exists('clear_plugin_item_image')) {
    if (file_exists($lib_file)) {
        include_once($lib_file);
    }
}

if (function_exists('clear_plugin_item_image')) {
    if (clear_plugin_item_image($type, $id)) {
        die(json_encode(array('success' => true)));
    } else {
        die(json_encode(array('error' => 'DB 업데이트 중 오류가 발생했습니다.')));
    }
} else {
    die(json_encode(array('error' => '필수 라이브러리 함수를 찾을 수 없습니다.')));
}
?>