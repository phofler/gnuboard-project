<?php
$sub_menu = '300910';
include_once(dirname(__FILE__) . '/../_common.php');

if (!defined('G5_ADMIN_PATH')) {
    define('G5_ADMIN_PATH', G5_PATH . '/adm');
}
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'd'); // 'd' for delete permission check

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (!$id) {
    alert('잘못된 접근입니다.');
}

// DB 테이블
$write_table = G5_PLUGIN_ONLINE_INQUIRY_TABLE;

// 데이터 존재 확인
$sql = " select count(*) as cnt from {$write_table} where id = '{$id}' ";
$row = sql_fetch($sql);
if (!$row['cnt']) {
    alert('존재하지 않는 데이터입니다.');
}

// 삭제
$sql = " delete from {$write_table} where id = '{$id}' ";
sql_query($sql);

// alert 함수 호출 전 CWD 변경 (bbs/alert.php 경로 문제 해결)
chdir(G5_PATH);
alert('삭제되었습니다.', './list.php');
?>