<?php
$sub_menu = "800195";
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'w');

// CSRF Check (Simplified for prototype, real production should check token)
// check_admin_token();

$bs_id = isset($_POST['bs_id']) ? (int) $_POST['bs_id'] : 0;
$w = isset($_POST['w']) ? $_POST['w'] : '';

$bs_title = isset($_POST['bs_title']) ? trim($_POST['bs_title']) : '';
$bs_skin = isset($_POST['bs_skin']) ? trim($_POST['bs_skin']) : '';
$bs_bo_table = isset($_POST['bs_bo_table']) ? trim($_POST['bs_bo_table']) : '';
$bs_count = isset($_POST['bs_count']) ? (int) $_POST['bs_count'] : 4;
$bs_subject_len = isset($_POST['bs_subject_len']) ? (int) $_POST['bs_subject_len'] : 30;
$bs_options = isset($_POST['bs_options']) ? trim($_POST['bs_options']) : '';
$bs_active = isset($_POST['bs_active']) ? 1 : 0;
$bs_sort = isset($_POST['bs_sort']) ? (int) $_POST['bs_sort'] : 0;

$sql_common = " bs_title = '{$bs_title}',
                bs_skin = '{$bs_skin}',
                bs_bo_table = '{$bs_bo_table}',
                bs_count = '{$bs_count}',
                bs_subject_len = '{$bs_subject_len}',
                bs_options = '{$bs_options}',
                bs_active = '{$bs_active}',
                bs_sort = '{$bs_sort}' ";

if ($w == '') {
    $sql = " insert into " . G5_PLUGIN_BOARD_SKIN_TABLE . " set {$sql_common} ";
    sql_query($sql);
    $bs_id = sql_insert_id();
} else if ($w == 'u') {
    $sql = " update " . G5_PLUGIN_BOARD_SKIN_TABLE . " set {$sql_common} where bs_id = '{$bs_id}' ";
    sql_query($sql);
} else if ($w == 'd') {
    $sql = " delete from " . G5_PLUGIN_BOARD_SKIN_TABLE . " where bs_id = '{$bs_id}' ";
    sql_query($sql);
}

goto_url('./list.php');
?>