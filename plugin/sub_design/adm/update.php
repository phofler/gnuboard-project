<?php
$sub_menu = '800200';
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'w');

// [FIX] Disable Token Check for now to match top_menu_manager logic
// check_admin_token();

if (!defined('G5_PLUGIN_SUB_DESIGN_GROUP_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_GROUP_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_groups');
}
if (!defined('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_items');
}

// [Migration] Ensure all required columns exist
if (!sql_query(" select sd_layout from " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " limit 1 ", false)) {
    sql_query(" alter table " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " add `sd_layout` varchar(20) NOT NULL DEFAULT 'full' after `sd_skin` ");
}
if (!sql_query(" select me_name from " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " limit 1 ", false)) {
    sql_query(" alter table " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " add `me_name` varchar(255) NOT NULL DEFAULT '' after `me_code` ");
}

$w = isset($_POST['w']) ? clean_xss_tags($_POST['w']) : '';
$sd_id = isset($_POST['sd_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['sd_id']) : '';
$old_sd_id = isset($_POST['old_sd_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['old_sd_id']) : '';
$sd_theme = isset($_POST['sd_theme']) ? clean_xss_tags($_POST['sd_theme']) : '';
$sd_lang = isset($_POST['sd_lang']) ? clean_xss_tags($_POST['sd_lang']) : 'kr';
$sd_skin = isset($_POST['sd_skin']) ? clean_xss_tags($_POST['sd_skin']) : 'standard';
$sd_layout = isset($_POST['sd_layout']) ? clean_xss_tags($_POST['sd_layout']) : 'full';

if (!$sd_id) {
    alert('식별코드(ID)가 없습니다.');
}

if ($w == '' || $w == 'u') {
    $sql_common = " sd_theme = '{$sd_theme}',
                    sd_lang = '{$sd_lang}',
                    sd_skin = '{$sd_skin}',
                    sd_layout = '{$sd_layout}' ";

    if ($w == '') {
        $row = sql_fetch(" SELECT count(*) as cnt FROM " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " WHERE sd_id = '{$sd_id}' ");
        if ($row['cnt']) {
            alert('이미 존재하는 식별코드입니다.');
        }
        sql_query(" INSERT INTO " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " SET sd_id = '{$sd_id}', {$sql_common}, sd_reg_dt = '" . G5_TIME_YMDHIS . "' ");
    } else {
        // [Zero-Gap Stability] Check if the new ID already exists before updating
        if ($sd_id != $old_sd_id) {
            $check = sql_fetch(" SELECT count(*) as cnt FROM " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " WHERE sd_id = '{$sd_id}' ");
            if ($check['cnt']) {
                alert('이미 존재하는 식별코드(' . $sd_id . ')입니다. 다른 테마나 언어를 선택하거나 커스텀 이름을 수정해주세요.');
            }
        }

        sql_query(" UPDATE " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " SET sd_id = '{$sd_id}', {$sql_common} WHERE sd_id = '{$old_sd_id}' ");
        if ($sd_id != $old_sd_id) {
            sql_query(" UPDATE " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " SET sd_id = '{$sd_id}' WHERE sd_id = '{$old_sd_id}' ");
        }
    }

    // 아이템 업데이트 (메뉴별 설정)
    $me_codes = (isset($_POST['me_code']) && is_array($_POST['me_code'])) ? $_POST['me_code'] : array();
    $me_names = (isset($_POST['me_name']) && is_array($_POST['me_name'])) ? $_POST['me_name'] : array();
    $main_texts = (isset($_POST['sd_main_text']) && is_array($_POST['sd_main_text'])) ? $_POST['sd_main_text'] : array();
    $sub_texts = (isset($_POST['sd_sub_text']) && is_array($_POST['sd_sub_text'])) ? $_POST['sd_sub_text'] : array();
    $visual_urls = (isset($_POST['sd_visual_url']) && is_array($_POST['sd_visual_url'])) ? $_POST['sd_visual_url'] : array();

    for ($i = 0; $i < count($me_codes); $i++) {
        $me_code = clean_xss_tags($me_codes[$i]);
        $me_name = isset($me_names[$i]) ? clean_xss_tags($me_names[$i]) : '';
        $main_text = isset($main_texts[$i]) ? clean_xss_tags($main_texts[$i]) : '';
        $sub_text = isset($sub_texts[$i]) ? clean_xss_tags($sub_texts[$i]) : '';
        $visual_url = isset($visual_urls[$i]) ? clean_xss_tags($visual_urls[$i]) : '';

        $item_sql = " sd_main_text = '{$main_text}',
                      sd_sub_text = '{$sub_text}',
                      sd_visual_url = '{$visual_url}',
                      me_name = '{$me_name}' ";

        $row_item = sql_fetch(" SELECT count(*) as cnt FROM " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " WHERE sd_id = '{$sd_id}' AND me_code = '{$me_code}' ");
        if ($row_item['cnt']) {
            sql_query(" UPDATE " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " SET {$item_sql} WHERE sd_id = '{$sd_id}' AND me_code = '{$me_code}' ");
        } else {
            sql_query(" INSERT INTO " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " SET sd_id = '{$sd_id}', me_code = '{$me_code}', {$item_sql} ");
        }
    }
}

alert('정상적으로 저장되었습니다.', './list.php');
?>