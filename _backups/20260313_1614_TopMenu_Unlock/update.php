<?php
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!$is_admin) {
    alert('관리자만 접근 가능합니다.');
}

$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';
$tm_id = isset($_REQUEST['tm_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['tm_id']) : '';
$tm_id_org = isset($_REQUEST['tm_id_org']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['tm_id_org']) : '';

// 0. 타겟 ID 결정 (수정 시에는 원본 ID 기준)
$tm_id_target = ($w == 'u') ? ($tm_id_org ? $tm_id_org : $tm_id) : $tm_id;

if ($w == 'd') {
    if (!$tm_id) alert('ID가 유효하지 않습니다.');
    $row = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");
    if ($row) {
        @unlink(G5_DATA_PATH . '/common/' . $row['tm_logo_pc']);
        @unlink(G5_DATA_PATH . '/common/' . $row['tm_logo_mo']);
        sql_query(" DELETE FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");
    }
    alert('삭제되었습니다.', './list.php');
}

// 신규 추가 필드
$tm_theme = isset($_POST['tm_theme']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tm_theme']) : '';
$tm_lang = isset($_POST['tm_lang']) ? preg_replace('/[^a-z]/', '', $_POST['tm_lang']) : '';
$tm_custom = isset($_POST['tm_id_custom']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tm_id_custom']) : '';

$tm_skin = isset($_POST['tm_skin']) ? $_POST['tm_skin'] : '';
$tm_menu_table = isset($_POST['tm_menu_table']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tm_menu_table']) : '';

$data_dir = G5_DATA_PATH . '/common';
$existing = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id_target}' ");

// [로고 처리]
$logo_pc_name = $existing['tm_logo_pc'];
if (isset($_POST['del_logo_pc']) && $_POST['del_logo_pc']) {
    if ($existing['tm_logo_pc']) @unlink($data_dir . '/' . $existing['tm_logo_pc']);
    $logo_pc_name = '';
}
if (isset($_FILES['tm_logo_pc']) && is_uploaded_file($_FILES['tm_logo_pc']['tmp_name'])) {
    if ($existing['tm_logo_pc']) @unlink($data_dir . '/' . $existing['tm_logo_pc']);
    $ext = pathinfo($_FILES['tm_logo_pc']['name'], PATHINFO_EXTENSION);
    $new_name = 'tm_' . $tm_id_target . '_pc.' . $ext;
    move_uploaded_file($_FILES['tm_logo_pc']['tmp_name'], $data_dir . '/' . $new_name);
    $logo_pc_name = $new_name;
}

$logo_mo_name = $existing['tm_logo_mo'];
if (isset($_POST['del_logo_mo']) && $_POST['del_logo_mo']) {
    if ($existing['tm_logo_mo']) @unlink($data_dir . '/' . $existing['tm_logo_mo']);
    $logo_mo_name = '';
}
if (isset($_FILES['tm_logo_mo']) && is_uploaded_file($_FILES['tm_logo_mo']['tmp_name'])) {
    if ($existing['tm_logo_mo']) @unlink($data_dir . '/' . $existing['tm_logo_mo']);
    $ext = pathinfo($_FILES['tm_logo_mo']['name'], PATHINFO_EXTENSION);
    $new_name = 'tm_' . $tm_id_target . '_mo.' . $ext;
    move_uploaded_file($_FILES['tm_logo_mo']['tmp_name'], $data_dir . '/' . $new_name);
    $logo_mo_name = $new_name;
}

if ($w == '') {
    // INSERT
    $check = sql_fetch(" SELECT count(*) as cnt FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");
    if ($check['cnt']) alert('이미 존재하는 식별코드(ID)입니다.');

    $sql = " INSERT INTO g5_plugin_top_menu_config
                SET tm_id = '{$tm_id}',
                    tm_theme = '{$tm_theme}',
                    tm_lang = '{$tm_lang}',
                    tm_custom = '{$tm_custom}',
                    tm_skin = '{$tm_skin}',
                    tm_menu_table = '{$tm_menu_table}',
                    tm_logo_pc = '{$logo_pc_name}',
                    tm_logo_mo = '{$logo_mo_name}',
                    tm_reg_dt = '" . G5_TIME_YMDHIS . "' ";
    sql_query($sql);
} else if ($w == 'u') {
    // UPDATE (ID 자체는 변경 불가로 정책 결정)
    $sql = " UPDATE g5_plugin_top_menu_config
                SET tm_theme = '{$tm_theme}',
                    tm_lang = '{$tm_lang}',
                    tm_custom = '{$tm_custom}',
                    tm_skin = '{$tm_skin}',
                    tm_menu_table = '{$tm_menu_table}',
                    tm_logo_pc = '{$logo_pc_name}',
                    tm_logo_mo = '{$logo_mo_name}'
              WHERE tm_id = '{$tm_id_target}' ";
    sql_query($sql);
}

alert('설정이 저장되었습니다.', './list.php');
?>