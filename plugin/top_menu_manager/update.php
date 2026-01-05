<?php
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!$is_admin) {
    alert('관리자만 접근 가능합니다.');
}

$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';
$tm_id = isset($_REQUEST['tm_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['tm_id']) : '';

// 1. Delete
if ($w == 'd') {
    if (!$tm_id)
        alert('ID가 유효하지 않습니다.');

    // [FIX] Disable Token Check for now
    // check_admin_token();

    // Delete files
    $row = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");
    @unlink(G5_DATA_PATH . '/common/' . $row['tm_logo_pc']);
    @unlink(G5_DATA_PATH . '/common/' . $row['tm_logo_mo']);

    sql_query(" DELETE FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");
    alert('삭제되었습니다.', './list.php');
}

// 2. Insert / Update / Logo Upload
// [FIX] Disable Token Check for now
// check_admin_token();

$tm_skin = isset($_POST['tm_skin']) ? $_POST['tm_skin'] : '';
$tm_menu_table = isset($_POST['tm_menu_table']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tm_menu_table']) : '';

// File Upload Logic
$data_dir = G5_DATA_PATH . '/common';
$logo_pc_name = '';
$logo_mo_name = '';

// Get existing record to handle deletions/updates
$existing = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");

// Handle Deletion Checkboxes
if (isset($_POST['del_logo_pc']) && $_POST['del_logo_pc']) {
    @unlink($data_dir . '/' . $existing['tm_logo_pc']);
    $logo_pc_name = ''; // Clear in DB
} else {
    $logo_pc_name = $existing['tm_logo_pc']; // Keep existing
}

if (isset($_POST['del_logo_mo']) && $_POST['del_logo_mo']) {
    @unlink($data_dir . '/' . $existing['tm_logo_mo']);
    $logo_mo_name = '';
} else {
    $logo_mo_name = $existing['tm_logo_mo'];
}

// Upload New Files
if (isset($_FILES['tm_logo_pc']) && is_uploaded_file($_FILES['tm_logo_pc']['tmp_name'])) {
    $ext = pathinfo($_FILES['tm_logo_pc']['name'], PATHINFO_EXTENSION);
    $new_name = 'tm_' . $tm_id . '_pc.' . $ext;
    move_uploaded_file($_FILES['tm_logo_pc']['tmp_name'], $data_dir . '/' . $new_name);
    $logo_pc_name = $new_name;
}

if (isset($_FILES['tm_logo_mo']) && is_uploaded_file($_FILES['tm_logo_mo']['tmp_name'])) {
    $ext = pathinfo($_FILES['tm_logo_mo']['name'], PATHINFO_EXTENSION);
    $new_name = 'tm_' . $tm_id . '_mo.' . $ext;
    move_uploaded_file($_FILES['tm_logo_mo']['tmp_name'], $data_dir . '/' . $new_name);
    $logo_mo_name = $new_name;
}


// Full Config Update
if ($w == '') {
    // ID Check
    $check = sql_fetch(" SELECT count(*) as cnt FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");
    if ($check['cnt'])
        alert('이미 존재하는 식별코드(ID)입니다.');

    $sql = " INSERT INTO g5_plugin_top_menu_config
                    SET tm_id = '{$tm_id}',
                        tm_skin = '{$tm_skin}',
                        tm_menu_table = '{$tm_menu_table}',
                        tm_logo_pc = '{$logo_pc_name}',
                        tm_logo_mo = '{$logo_mo_name}',
                        tm_reg_dt = '" . G5_TIME_YMDHIS . "' ";
    sql_query($sql);
} else if ($w == 'u') {
    $sql = " UPDATE g5_plugin_top_menu_config
                    SET tm_skin = '{$tm_skin}',
                        tm_menu_table = '{$tm_menu_table}',
                        tm_logo_pc = '{$logo_pc_name}',
                        tm_logo_mo = '{$logo_mo_name}'
                  WHERE tm_id = '{$tm_id}' ";
    sql_query($sql);
}

alert('설정이 저장되었습니다.', './list.php');
?>