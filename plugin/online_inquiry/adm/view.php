<?php
$sub_menu = '300910';
define('G5_IS_ADMIN', true);
include_once(dirname(__FILE__) . '/../_common.php');

if (!defined('G5_ADMIN_PATH')) {
    define('G5_ADMIN_PATH', G5_PATH . '/adm');
}
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '온라인 문의 상세보기';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$id) {
    alert('잘못된 접근입니다.');
}

// DB 테이블
$write_table = G5_PLUGIN_ONLINE_INQUIRY_TABLE;

// 데이터 조회
$view = sql_fetch(" select * from {$write_table} where id = '{$id}' ");
if (!$view['id']) {
    alert('존재하지 않는 게시물입니다.');
}

include_once(G5_ADMIN_PATH . '/admin.head.php');

// 스킨 로드
$skin_file = ONLINE_INQUIRY_PATH . '/skin/adm/view.skin.php';
$skin_url = ONLINE_INQUIRY_URL . '/skin/adm';

if (file_exists($skin_file)) {
    include_once($skin_file);
} else {
    echo '<p>스킨 파일이 없습니다: ' . $skin_file . '</p>';
}

include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>