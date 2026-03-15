<?php
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!$is_admin) {
    alert('愿由ъ옄留??묎렐 媛?ν빀?덈떎.');
}

$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';
$tm_id = isset($_REQUEST['tm_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['tm_id']) : '';
$tm_id_org = isset($_REQUEST['tm_id_org']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['tm_id_org']) : '';

// 0. Target ID 寃곗젙 (?섏젙 紐⑤뱶??寃쎌슦 ?먮낯 ID ?곗꽑, ?놁쑝硫??꾩옱 ID)
$tm_id_target = ($w == 'u') ? ($tm_id_org ? $tm_id_org : $tm_id) : $tm_id;

// 1. Delete
if ($w == 'd') {
    if (!$tm_id) alert('ID媛 ?좏슚?섏? ?딆뒿?덈떎.');
    $row = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");
    if ($row) {
        @unlink(G5_DATA_PATH . '/common/' . $row['tm_logo_pc']);
        @unlink(G5_DATA_PATH . '/common/' . $row['tm_logo_mo']);
        sql_query(" DELETE FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");
    }
    alert('??젣?섏뿀?듬땲??', './list.php');
}

// 2. Insert / Update Logic
$tm_skin = isset($_POST['tm_skin']) ? $_POST['tm_skin'] : '';
$tm_menu_table = isset($_POST['tm_menu_table']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['tm_menu_table']) : '';

$data_dir = G5_DATA_PATH . '/common';
$existing = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id_target}' ");

// [PC 濡쒓퀬 泥섎━]
$logo_pc_name = $existing['tm_logo_pc'];
if (isset($_POST['del_logo_pc']) && $_POST['del_logo_pc']) {
    if ($existing['tm_logo_pc']) @unlink($data_dir . '/' . $existing['tm_logo_pc']);
    $logo_pc_name = '';
}
if (isset($_FILES['tm_logo_pc']) && is_uploaded_file($_FILES['tm_logo_pc']['tmp_name'])) {
    if ($existing['tm_logo_pc']) @unlink($data_dir . '/' . $existing['tm_logo_pc']); // ???뚯씪 ?낅줈????湲곗〈 ?뚯씪 ??젣
    $ext = pathinfo($_FILES['tm_logo_pc']['name'], PATHINFO_EXTENSION);
    $new_name = 'tm_' . $tm_id . '_pc.' . $ext; // ?뚯씪紐낆? ??긽 理쒖떊 ID 湲곗?
    move_uploaded_file($_FILES['tm_logo_pc']['tmp_name'], $data_dir . '/' . $new_name);
    $logo_pc_name = $new_name;
}

// [紐⑤컮??濡쒓퀬 泥섎━]
$logo_mo_name = $existing['tm_logo_mo'];
if (isset($_POST['del_logo_mo']) && $_POST['del_logo_mo']) {
    if ($existing['tm_logo_mo']) @unlink($data_dir . '/' . $existing['tm_logo_mo']);
    $logo_mo_name = '';
}
if (isset($_FILES['tm_logo_mo']) && is_uploaded_file($_FILES['tm_logo_mo']['tmp_name'])) {
    if ($existing['tm_logo_mo']) @unlink($data_dir . '/' . $existing['tm_logo_mo']);
    $ext = pathinfo($_FILES['tm_logo_mo']['name'], PATHINFO_EXTENSION);
    $new_name = 'tm_' . $tm_id . '_mo.' . $ext;
    move_uploaded_file($_FILES['tm_logo_mo']['tmp_name'], $data_dir . '/' . $new_name);
    $logo_mo_name = $new_name;
}

// [ID 蹂寃???? ?뚯씪紐??대쫫蹂寃?
if ($w == 'u' && $tm_id_org && $tm_id !== $tm_id_org) {
    if ($logo_pc_name && strpos($logo_pc_name, 'tm_' . $tm_id_org . '_pc') !== false) {
        $old_pc = $logo_pc_name;
        $ext = pathinfo($old_pc, PATHINFO_EXTENSION);
        $new_pc = 'tm_' . $tm_id . '_pc.' . $ext;
        if (file_exists($data_dir . '/' . $old_pc)) {
            rename($data_dir . '/' . $old_pc, $data_dir . '/' . $new_pc);
            $logo_pc_name = $new_pc;
        }
    }
    if ($logo_mo_name && strpos($logo_mo_name, 'tm_' . $tm_id_org . '_mo') !== false) {
        $old_mo = $logo_mo_name;
        $ext = pathinfo($old_mo, PATHINFO_EXTENSION);
        $new_mo = 'tm_' . $tm_id . '_mo.' . $ext;
        if (file_exists($data_dir . '/' . $old_mo)) {
            rename($data_dir . '/' . $old_mo, $data_dir . '/' . $new_mo);
            $logo_mo_name = $new_mo;
        }
    }
}

if ($w == '') {
    // Insert
    $check = sql_fetch(" SELECT count(*) as cnt FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");
    if ($check['cnt']) alert('?대? 議댁옱?섎뒗 ?앸퀎肄붾뱶(ID)?낅땲??');

    $sql = " INSERT INTO g5_plugin_top_menu_config
                SET tm_id = '{$tm_id}',
                    tm_skin = '{$tm_skin}',
                    tm_menu_table = '{$tm_menu_table}',
                    tm_logo_pc = '{$logo_pc_name}',
                    tm_logo_mo = '{$logo_mo_name}',
                    tm_reg_dt = '" . G5_TIME_YMDHIS . "' ";
    sql_query($sql);
} else if ($w == 'u') {
    // Update
    $sql = " UPDATE g5_plugin_top_menu_config
                SET tm_id = '{$tm_id}', -- ID ?먯껜???낅뜲?댄듃 (蹂寃??덉슜)
                    tm_skin = '{$tm_skin}',
                    tm_menu_table = '{$tm_menu_table}',
                    tm_logo_pc = '{$logo_pc_name}',
                    tm_logo_mo = '{$logo_mo_name}'
              WHERE tm_id = '{$tm_id_target}' ";
    sql_query($sql);
}

alert('?ㅼ젙????λ릺?덉뒿?덈떎.', './list.php');
?>