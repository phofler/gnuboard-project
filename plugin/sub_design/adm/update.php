<?php
$sub_menu = '800200';
include_once(dirname(__FILE__) . '/../../../common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!defined('G5_PLUGIN_SUB_DESIGN_GROUP_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_GROUP_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_groups');
}
if (!defined('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_items');
}

check_admin_token();

$w = isset($_POST['w']) ? clean_xss_tags($_POST['w']) : '';
$sd_id = isset($_POST['sd_id']) ? clean_xss_tags($_POST['sd_id']) : '';
$old_sd_id = isset($_POST['old_sd_id']) ? clean_xss_tags($_POST['old_sd_id']) : '';
$sd_theme = isset($_POST['sd_theme']) ? clean_xss_tags($_POST['sd_theme']) : '';
$sd_lang = isset($_POST['sd_lang']) ? clean_xss_tags($_POST['sd_lang']) : 'kr';
$sd_skin = isset($_POST['sd_skin']) ? clean_xss_tags($_POST['sd_skin']) : 'standard';

if (!$sd_id)
    alert('필수 데이터가 누락되었습니다.');

// Handle Group Deletion (if requested via list.php)
if ($w == 'd' && $sd_id) {
    $upload_dir = G5_DATA_PATH . '/sub_visual'; // Define upload_dir for deletion context
    // Delete Items Visual Files first
    $res = sql_query(" SELECT sd_visual_img FROM " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " WHERE sd_id = '{$sd_id}' ");
    while ($row = sql_fetch_array($res)) {
        if ($row['sd_visual_img'] && file_exists($upload_dir . '/' . $row['sd_visual_img'])) {
            @unlink($upload_dir . '/' . $row['sd_visual_img']);
        }
    }
    sql_query(" DELETE FROM " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " WHERE sd_id = '{$sd_id}' ");
    sql_query(" DELETE FROM " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " WHERE sd_id = '{$sd_id}' ");
} else {
    // [1] Save Group Metadata
    if ($w == 'u') {
        $sql = " UPDATE " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . "
                    SET sd_id = '{$sd_id}',
                        sd_theme = '{$sd_theme}',
                        sd_lang = '{$sd_lang}',
                        sd_skin = '{$sd_skin}',
                        sd_updated = '" . G5_TIME_YMDHIS . "'
                    WHERE sd_id = '{$old_sd_id}' ";
        sql_query($sql);

        // If ID changed, update items
        if ($sd_id != $old_sd_id) {
            sql_query(" UPDATE " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " SET sd_id = '{$sd_id}' WHERE sd_id = '{$old_sd_id}' ");
        }
    } else {
        // Check duplication
        $dupe = sql_fetch(" SELECT sd_id FROM " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " WHERE sd_id = '{$sd_id}' ");
        if ($dupe)
            alert('이미 존재하는 식별코드입니다. 다른 이름을 사용해주세요.');

        $sql = " INSERT INTO " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . "
                    SET sd_id = '{$sd_id}',
                        sd_theme = '{$sd_theme}',
                        sd_lang = '{$sd_lang}',
                        sd_skin = '{$sd_skin}',
                        sd_created = '" . G5_TIME_YMDHIS . "',
                        sd_updated = '" . G5_TIME_YMDHIS . "' ";
        sql_query($sql);
    }

    // [2] Save Items
    $count = count($_POST['me_code']);
    $upload_dir = G5_DATA_PATH . '/sub_visual';
    if (!is_dir($upload_dir)) {
        @mkdir($upload_dir, G5_DIR_PERMISSION);
        @chmod($upload_dir, G5_DIR_PERMISSION);
    }

    for ($i = 0; $i < $count; $i++) {
        $me_code = sql_real_escape_string($_POST['me_code'][$i]);
        $sd_main_text = sql_real_escape_string($_POST['sd_main_text'][$i]);
        $sd_sub_text = sql_real_escape_string($_POST['sd_sub_text'][$i]);
        $sd_visual_url = sql_real_escape_string($_POST['sd_visual_url'][$i]);

        // Get current item data
        $row = sql_fetch(" SELECT sd_visual_img FROM " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " WHERE sd_id = '{$sd_id}' AND me_code = '{$me_code}' ");
        $sd_visual_img = $row ? $row['sd_visual_img'] : '';

        // File Upload
        $file_field = 'sd_visual_img_' . $i;
        if (isset($_FILES[$file_field]) && is_uploaded_file($_FILES[$file_field]['tmp_name'])) {
            // Delete old
            if ($sd_visual_img && file_exists($upload_dir . '/' . $sd_visual_img)) {
                @unlink($upload_dir . '/' . $sd_visual_img);
            }

            $ext = strtolower(pathinfo($_FILES[$file_field]['name'], PATHINFO_EXTENSION));
            $new_name = 'sv_' . $sd_id . '_' . $me_code . '_' . time() . '.' . $ext;

            if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'webp'))) {
                move_uploaded_file($_FILES[$file_field]['tmp_name'], $upload_dir . '/' . $new_name);
                chmod($upload_dir . '/' . $new_name, G5_FILE_PERMISSION);
                $sd_visual_img = $new_name;
            }
        }

        if ($me_code) {
            $sql = " INSERT INTO " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . "
                        SET sd_id = '{$sd_id}',
                            me_code = '{$me_code}',
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
    }
}

goto_url('./list.php');
?>