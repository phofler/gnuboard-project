<?php
include_once('./_common.php');

check_admin_token();

$table_name = G5_TABLE_PREFIX . 'plugin_copyright';
$cp_id = 'default';

if (!$cp_id) {
    alert('잘못된 접근입니다.');
}

// Logo Upload Processing
$logo_url = sql_fetch(" select logo_url from {$table_name} where cp_id = '{$cp_id}' ")['logo_url'];
if ($_FILES['logo_file']['name']) {
    $dest_path = G5_DATA_PATH . '/copyright';
    if (!is_dir($dest_path)) {
        mkdir($dest_path, G5_DIR_PERMISSION, true);
        @chmod($dest_path, G5_DIR_PERMISSION);
    }

    $filename = time() . '_' . $_FILES['logo_file']['name'];
    move_uploaded_file($_FILES['logo_file']['tmp_name'], $dest_path . '/' . $filename);
    $logo_url = G5_DATA_URL . '/copyright/' . $filename;
}

$sql = " update {$table_name}
            set slogan = '{$_POST['slogan']}',
                addr_label = '{$_POST['addr_label']}',
                addr_val = '{$_POST['addr_val']}',
                tel_label = '{$_POST['tel_label']}',
                tel_val = '{$_POST['tel_val']}',
                fax_label = '{$_POST['fax_label']}',
                fax_val = '{$_POST['fax_val']}',
                email_label = '{$_POST['email_label']}',
                email_val = '{$_POST['email_val']}',
                link1_name = '{$_POST['link1_name']}',
                link1_url = '{$_POST['link1_url']}',
                link2_name = '{$_POST['link2_name']}',
                link2_url = '{$_POST['link2_url']}',
                copyright = '{$_POST['copyright']}',
                cp_content = '{$_POST['cp_content']}',
                cp_bgcolor = '{$_POST['cp_bgcolor']}',
                logo_url = '{$logo_url}',
                cp_datetime = '" . G5_TIME_YMDHIS . "'
          where cp_id = '{$cp_id}' ";

sql_query($sql);

goto_url('./list.php');
?>