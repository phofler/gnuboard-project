<?php
$sub_menu = '950200';
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');
include_once(G5_LIB_PATH . '/image.lib.php');

auth_check_menu($auth, $sub_menu, 'w');

if (!defined('G5_PLUGIN_SUB_DESIGN_GROUP_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_GROUP_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_groups');
}
if (!defined('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_items');
}

$w = isset($_POST['w']) ? clean_xss_tags($_POST['w']) : '';
$sd_id = isset($_POST['sd_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['sd_id']) : '';
$old_sd_id = isset($_POST['old_sd_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['old_sd_id']) : '';
$sd_theme = isset($_POST['sd_theme']) ? clean_xss_tags($_POST['sd_theme']) : '';
$sd_lang = isset($_POST['sd_lang']) ? clean_xss_tags($_POST['sd_lang']) : 'kr';
$sd_skin = isset($_POST['sd_skin']) ? clean_xss_tags($_POST['sd_skin']) : 'standard';
$sd_layout = isset($_POST['sd_layout']) ? clean_xss_tags($_POST['sd_layout']) : 'full';
$sd_breadcrumb = (isset($_POST['sd_breadcrumb']) && $_POST['sd_breadcrumb']) ? 1 : 0;
$sd_breadcrumb_skin = isset($_POST['sd_breadcrumb_skin']) ? clean_xss_tags($_POST['sd_breadcrumb_skin']) : 'dropdown';

if (!$sd_id) {
    alert('식별코드(ID)가 없습니다.');
}

if ($w == '' || $w == 'u') {
    $sql_common = " sd_theme = '{$sd_theme}',
                    sd_lang = '{$sd_lang}',
                    sd_skin = '{$sd_skin}',
                    sd_layout = '{$sd_layout}',
                    sd_breadcrumb = '{$sd_breadcrumb}',
                    sd_breadcrumb_skin = '{$sd_breadcrumb_skin}' ";

    if ($w == '') {
        $row = sql_fetch(" SELECT count(*) as cnt FROM " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " WHERE sd_id = '{$sd_id}' ");
        if ($row['cnt']) {
            alert('이미 존재하는 식별코드입니다.');
        }
        sql_query(" INSERT INTO " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " SET sd_id = '{$sd_id}', {$sql_common}, sd_created = '" . G5_TIME_YMDHIS . "', sd_updated = '" . G5_TIME_YMDHIS . "' ");
    } else {
        if ($sd_id != $old_sd_id) {
            $check = sql_fetch(" SELECT count(*) as cnt FROM " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " WHERE sd_id = '{$sd_id}' ");
            if ($check['cnt']) {
                alert('이미 존재하는 식별코드(' . $sd_id . ')입니다.');
            }
        }
        sql_query(" UPDATE " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " SET sd_id = '{$sd_id}', {$sql_common}, sd_updated = '" . G5_TIME_YMDHIS . "' WHERE sd_id = '{$old_sd_id}' ");
    }

    // 메뉴별 세부 설정 저장 (Item List)
    $me_codes = $_POST['me_code'];
    $me_names = $_POST['me_name'];
    $sd_main_texts = $_POST['sd_main_text'];
    $sd_sub_texts = $_POST['sd_sub_text'];
    $sd_tags = $_POST['sd_tag'];
    $sd_visual_urls = $_POST['sd_visual_url'];

    // Effect fields
    $sd_eff_tag_types = $_POST['sd_eff_tag_type'];
    $sd_eff_tag_delays = $_POST['sd_eff_tag_delay'];
    $sd_eff_main_types = $_POST['sd_eff_main_type'];
    $sd_eff_main_delays = $_POST['sd_eff_main_delay'];
    $sd_eff_sub_types = $_POST['sd_eff_sub_type'];
    $sd_eff_sub_delays = $_POST['sd_eff_sub_delay'];

    if (is_array($me_codes)) {
        for ($i = 0; $i < count($me_codes); $i++) {
            $me_code = clean_xss_tags($me_codes[$i]);
            $me_name = clean_xss_tags($me_names[$i]);
            $main_text = clean_xss_tags($sd_main_texts[$i]);
            $sub_text = clean_xss_tags($sd_sub_texts[$i]);
            $tag = clean_xss_tags($sd_tags[$i]);
            $visual_url = clean_xss_tags($sd_visual_urls[$i]);

            // Consolidate effects into JSON
            $effect_data = array(
                'tag' => array('type' => clean_xss_tags($sd_eff_tag_types[$i]), 'delay' => (int)$sd_eff_tag_delays[$i], 'duration' => 1000),
                'main' => array('type' => clean_xss_tags($sd_eff_main_types[$i]), 'delay' => (int)$sd_eff_main_delays[$i], 'duration' => 1000),
                'sub' => array('type' => clean_xss_tags($sd_eff_sub_types[$i]), 'delay' => (int)$sd_eff_sub_delays[$i], 'duration' => 1000)
            );
            $sd_effect = addslashes(json_encode($effect_data));

            // 기존 데이터 확인
            $row = sql_fetch(" SELECT sdi_id FROM " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " WHERE sd_id = '{$sd_id}' AND me_code = '{$me_code}' ");
            
            $sql_item = " sd_main_text = '{$main_text}',
                          sd_sub_text = '{$sub_text}',
                          sd_tag = '{$tag}',
                          sd_visual_url = '{$visual_url}',
                          sd_effect = '{$sd_effect}' ";

            if (isset($row['sdi_id']) && $row['sdi_id']) {
                sql_query(" UPDATE " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " SET {$sql_item} WHERE sdi_id = '{$row['sdi_id']}' ");
            } else {
                sql_query(" INSERT INTO " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " SET sd_id = '{$sd_id}', me_code = '{$me_code}', {$sql_item} ");
            }
        }
    }
}

alert('정상적으로 저장되었습니다.', './write.php?w=u&sd_id=' . $sd_id);
?>