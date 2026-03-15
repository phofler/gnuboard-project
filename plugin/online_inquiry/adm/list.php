<?php
$sub_menu = '950300';
define('G5_IS_ADMIN', true); // 관리자 위젯 및 CSS 로드를 위해 정의
include_once(dirname(__FILE__) . '/../_common.php'); // plugin/_common.php

if (!defined('G5_ADMIN_PATH')) {
    define('G5_ADMIN_PATH', G5_PATH . '/adm');
}
include_once(G5_ADMIN_PATH . '/admin.lib.php');
include_once(dirname(__FILE__) . '/../install.php'); // Ensure DB tables/columns exist

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '온라인 문의 관리';

// --- SKIN CONFIGURATION ---
// Configuration is now managed in skin_list.php
// --------------------------------


// DB 테이블
$write_table = G5_PLUGIN_ONLINE_INQUIRY_TABLE;

// 검색 조건
$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'name':
        case 'subject':
        case 'content':
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
        default:
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

// 정렬
if (!$sst) {
    $sst = "id";
    $fod = "desc";
}
$sql_order = " order by {$sst} {$fod} ";

// 페이징
$sql = " select count(*) as cnt from {$write_table} {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 10; // 10개씩 보기
$total_page = ceil($total_count / $rows);
if ($page < 1)
    $page = 1;
$from_record = ($page - 1) * $rows;

// 데이터 조회
$sql = " select * from {$write_table} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

include_once(G5_ADMIN_PATH . '/admin.head.php');

// 스킨 로드
$skin_file = ONLINE_INQUIRY_PATH . '/skin/adm/list.skin.php';
$skin_url = ONLINE_INQUIRY_URL . '/skin/adm';

if (file_exists($skin_file)) {
    include_once($skin_file);
} else {
    echo '<p>스킨 파일이 없습니다: ' . $skin_file . '</p>';
}

include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>