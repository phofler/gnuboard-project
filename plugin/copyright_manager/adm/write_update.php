<?php
include_once('./_common.php');

$table_name = G5_TABLE_PREFIX . 'plugin_copyright';

$cp_id = isset($_POST['cp_id']) ? clean_xss_tags($_POST['cp_id']) : '';
if (!$cp_id)
    alert('ID가 전달되지 않았습니다.');

if ($w != 'u') {
    // Check for duplicate ID
    $row = sql_fetch(" select count(*) as cnt from {$table_name} where cp_id = '{$cp_id}' ");
    if ($row['cnt'] > 0) {
        alert('이미 존재하는 식별코드입니다.');
    }
}

$logo_url = isset($_POST['logo_url']) ? $_POST['logo_url'] : '';

// Logo Upload
if (isset($_FILES['logo_file']['name']) && is_uploaded_file($_FILES['logo_file']['tmp_name'])) {
    $data_path = G5_DATA_PATH . '/common';
    if (!is_dir($data_path)) {
        @mkdir($data_path, G5_DIR_PERMISSION);
        @chmod($data_path, G5_DIR_PERMISSION);
    }

    if (preg_match("/\.(jpg|jpeg|gif|png)$/i", $_FILES['logo_file']['name'])) {
        $filename = 'footer_logo_' . preg_replace("/[^a-z0-9_]/i", "", $cp_id) . '.' . pathinfo($_FILES['logo_file']['name'], PATHINFO_EXTENSION);
        $dest_file = $data_path . '/' . $filename;
        move_uploaded_file($_FILES['logo_file']['tmp_name'], $dest_file);
        chmod($dest_file, G5_FILE_PERMISSION);
        $logo_url = G5_DATA_URL . '/common/' . $filename;
    }
}

$sql_common = " cp_subject = '" . addslashes($_POST['cp_subject']) . "',
                logo_url = '" . addslashes($logo_url) . "',
                slogan = '" . addslashes($_POST['slogan']) . "',
                addr_label = '" . addslashes($_POST['addr_label']) . "',
                addr_val = '" . addslashes($_POST['addr_val']) . "',
                tel_label = '" . addslashes($_POST['tel_label']) . "',
                tel_val = '" . addslashes($_POST['tel_val']) . "',
                fax_label = '" . addslashes($_POST['fax_label']) . "',
                fax_val = '" . addslashes($_POST['fax_val']) . "',
                email_label = '" . addslashes($_POST['email_label']) . "',
                email_val = '" . addslashes($_POST['email_val']) . "',
                link1_name = '" . addslashes($_POST['link1_name']) . "',
                link1_url = '" . addslashes($_POST['link1_url']) . "',
                link2_name = '" . addslashes($_POST['link2_name']) . "',
                link2_url = '" . addslashes($_POST['link2_url']) . "',
                copyright = '" . addslashes($_POST['copyright']) . "',
                cp_content = '" . addslashes($_POST['cp_content']) . "',
                cp_skin = '" . addslashes($_POST['cp_skin']) . "',
                cp_bgcolor = '" . addslashes($_POST['cp_bgcolor']) . "',
                cp_datetime = '" . G5_TIME_YMDHIS . "' ";

if ($w == 'u') {
    $sql = " update {$table_name} set {$sql_common} where cp_id = '{$cp_id}' ";
} else {
    $sql = " insert into {$table_name} set cp_id = '{$cp_id}', {$sql_common} ";
}

sql_query($sql);

alert('저장되었습니다.', './list.php');
?>