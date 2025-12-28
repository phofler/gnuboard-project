<?php
$sub_menu = '800200';
include_once(dirname(__FILE__) . '/../../../common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!defined('G5_PLUGIN_SUB_DESIGN_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design');
}

check_admin_token();

$count = count($_POST['me_code']);
$upload_dir = G5_DATA_PATH . '/sub_visual';

if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, G5_DIR_PERMISSION);
    @chmod($upload_dir, G5_DIR_PERMISSION);
}

for ($i = 0; $i < $count; $i++) {
    $me_code = $_POST['me_code'][$i];
    $sd_main_text = $_POST['sd_main_text'][$i];
    $sd_sub_text = $_POST['sd_sub_text'][$i];
    $sd_visual_url = $_POST['sd_visual_url'][$i]; // [NEW]

    // Get current data
    $row = sql_fetch(" SELECT * FROM " . G5_PLUGIN_SUB_DESIGN_TABLE . " WHERE me_code = '{$me_code}' ");
    $sd_visual_img = $row['sd_visual_img'];

    // File Delete
    if (isset($_POST['sd_visual_img_del'][$i]) && $_POST['sd_visual_img_del'][$i]) {
        if ($sd_visual_img && file_exists($upload_dir . '/' . $sd_visual_img)) {
            @unlink($upload_dir . '/' . $sd_visual_img);
        }
        $sd_visual_img = '';
    }

    // File Upload
    $file_name = 'sd_visual_img_' . $i;
    if (isset($_FILES[$file_name]) && is_uploaded_file($_FILES[$file_name]['tmp_name'])) {
        if ($sd_visual_img && file_exists($upload_dir . '/' . $sd_visual_img)) {
            @unlink($upload_dir . '/' . $sd_visual_img);
        }

        $ext = strtolower(pathinfo($_FILES[$file_name]['name'], PATHINFO_EXTENSION));
        $new_name = 'sub_visual_' . $me_code . '_' . time() . '.' . $ext;

        // Allowed Extensions
        if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'webp'))) {
            move_uploaded_file($_FILES[$file_name]['tmp_name'], $upload_dir . '/' . $new_name);
            chmod($upload_dir . '/' . $new_name, G5_FILE_PERMISSION);
            $sd_visual_img = $new_name;
        }
    }

    $sql = " INSERT INTO " . G5_PLUGIN_SUB_DESIGN_TABLE . "
                SET me_code = '{$me_code}',
                    sd_main_text = '{$sd_main_text}',
                    sd_sub_text = '{$sd_sub_text}',
                    sd_visual_img = '{$sd_visual_img}',
                    sd_visual_url = '{$sd_visual_url}'
                ON DUPLICATE KEY UPDATE
                    sd_main_text = '{$sd_main_text}',
                    sd_sub_text = '{$sd_sub_text}',
                    sd_visual_img = '{$sd_visual_img}',
                    sd_visual_url = '{$sd_visual_url}' ";
    sql_query($sql);
}

goto_url('./list.php');
?>