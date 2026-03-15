<?php
$sub_menu = '300900';
include_once('./_common.php');

// Define path to admin head/tail if not already available via common
if (!defined('G5_ADMIN_PATH')) {
    define('G5_ADMIN_PATH', G5_PATH . '/adm');
}

auth_check_menu($auth, $sub_menu, 'r');

$bo_table = 'online7';
$write_table = $g5['write_prefix'] . $bo_table;

if (!isset($g5['write_prefix'])) {
    die('<p>게시판 테이블 접두어가 설정되지 않았습니다. (g5["write_prefix"])</p>');
}

// Check if table exists
if (!function_exists('get_table_define')) {
    $sql = " SHOW TABLES LIKE '{$write_table}' ";
    $row = sql_fetch($sql);
    if (!isset($row[0])) {
        die('<p><strong>' . $write_table . '</strong> 테이블이 존재하지 않습니다. 먼저 게시판을 생성해 주세요.</p>');
    }
}

$sql_common = " from {$write_table} ";
$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'wr_subject':
        case 'wr_content':
        case 'wr_name':
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
        default:
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst = "wr_num, wr_reply";
    $fod = "";
}

$sql_order = " order by {$sst} {$fod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page = ceil($total_count / $rows);
if ($page < 1) {
    $page = 1;
}
$from_record = ($page - 1) * $rows;

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$g5['title'] = '온라인 접수 리스트';

// Include Admin Head
include_once(G5_ADMIN_PATH . '/admin.head.php');

$colspan = 7;

// Valid Skin Path
$board_skin_path = G5_THEME_PATH . '/skin/adm/online';
$board_skin_url = G5_THEME_URL . '/skin/adm/online';

// Load the skin
include_once($board_skin_path . '/list.skin.php');

// Include Admin Tail
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>