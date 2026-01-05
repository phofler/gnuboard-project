<?php
include_once('./_common.php');

$table_name = G5_TABLE_PREFIX . 'plugin_copyright';

if ($w == 'u') {
    $cp_id = $_POST['cp_id'];
} else {
    $cp_id = $_POST['cp_id'];
    // Check for duplicate ID
    $row = sql_fetch(" select count(*) as cnt from {$table_name} where cp_id = '{$cp_id}' ");
    if ($row['cnt'] > 0) {
        alert('이미 존재하는 식별코드입니다.');
    }
}

$logo_url = $_POST['logo_url'];

// Logo Upload
if (isset($_FILES['logo_file']['name']) && is_uploaded_file($_FILES['logo_file']['tmp_name'])) {
    $data_path = G5_DATA_PATH . '/common';
    if (!is_dir($data_path)) {
        @mkdir($data_path, G5_DIR_PERMISSION);
        @chmod($data_path, G5_DIR_PERMISSION);
    }

    if (preg_match("/\.(jpg|jpeg|gif|png)$/i", $_FILES['logo_file']['name'])) {
        $filename = 'footer_logo_' . $cp_id . '.' . pathinfo($_FILES['logo_file']['name'], PATHINFO_EXTENSION);
        $dest_file = $data_path . '/' . $filename;
        move_uploaded_file($_FILES['logo_file']['tmp_name'], $dest_file);
        chmod($dest_file, G5_FILE_PERMISSION);
        $logo_url = G5_DATA_URL . '/common/' . $filename;
    }
}

$sql_common = " cp_subject = '{$_POST['cp_subject']}',
                logo_url = '{$logo_url}',
                cp_content = '{$_POST['cp_content']}',
                cp_skin = '{$_POST['cp_skin']}',
                cp_bgcolor = '{$_POST['cp_bgcolor']}',
                cp_datetime = '" . G5_TIME_YMDHIS . "' ";

// Only update structured fields if they exist in the POST (to support both consolidated and streamlined views)
if (isset($_POST['addr_val'])) {
    $sql_common .= ", addr_label = '{$_POST['addr_label']}', addr_val = '{$_POST['addr_val']}' ";
}
if (isset($_POST['tel_val'])) {
    $sql_common .= ", tel_label = '{$_POST['tel_label']}', tel_val = '{$_POST['tel_val']}' ";
}
if (isset($_POST['fax_val'])) {
    $sql_common .= ", fax_label = '{$_POST['fax_label']}', fax_val = '{$_POST['fax_val']}' ";
}
if (isset($_POST['email_val'])) {
    $sql_common .= ", email_label = '{$_POST['email_label']}', email_val = '{$_POST['email_val']}' ";
}
if (isset($_POST['slogan'])) {
    $sql_common .= ", slogan = '{$_POST['slogan']}' ";
}
if (isset($_POST['copyright'])) {
    $sql_common .= ", copyright = '{$_POST['copyright']}' ";
}
if (isset($_POST['link1_name'])) {
    $sql_common .= ", link1_name = '{$_POST['link1_name']}', link1_url = '{$_POST['link1_url']}' ";
}
if (isset($_POST['link2_name'])) {
    $sql_common .= ", link2_name = '{$_POST['link2_name']}', link2_url = '{$_POST['link2_url']}' ";
}

if ($w == 'u') {
    $sql = " update {$table_name} set {$sql_common} where cp_id = '{$cp_id}' ";
} else {
    $sql = " insert into {$table_name} set cp_id = '{$cp_id}', {$sql_common} ";
}

sql_query($sql);

alert('저장되었습니다.', './list.php');
?>