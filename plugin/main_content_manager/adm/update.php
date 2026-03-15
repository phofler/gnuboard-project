<?php
$sub_menu = '950190';
include_once('./_common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

check_demo();

if ($w == 'u')
    check_admin_token();

$ms_id = (int) $_POST['ms_id'];
$ms_title = sql_real_escape_string($_POST['ms_title']);
$ms_subtitle = sql_real_escape_string($_POST['ms_subtitle']);
$ms_lang = sql_real_escape_string($_POST['ms_lang']);
$ms_theme = sql_real_escape_string($_POST['ms_theme']);
$ms_key = sql_real_escape_string($_POST['ms_key']);
$ms_skin = sql_real_escape_string($_POST['ms_skin']);
$ms_sort = (int) $_POST['ms_sort'];
$ms_active = isset($_POST['ms_active']) ? 1 : 0;
$ms_show_title = isset($_POST['ms_show_title']) ? 1 : 0;
$ms_accent_color = isset($_POST['ms_accent_color']) ? sql_real_escape_string($_POST['ms_accent_color']) : '';
$ms_font_mode = isset($_POST['ms_font_mode']) ? sql_real_escape_string($_POST['ms_font_mode']) : '';
$ms_bg_color = sql_real_escape_string($_POST['ms_bg_color']);
$ms_content_source = isset($_POST['ms_content_source']) ? sql_real_escape_string($_POST['ms_content_source']) : '';

// [MIGRATION] Auto-add column if not exists
sql_query(" ALTER TABLE g5_plugin_main_content_sections ADD IF NOT EXISTS ms_bg_color varchar(20) NOT NULL DEFAULT '' AFTER ms_font_mode ", false);
sql_query(" ALTER TABLE g5_plugin_main_content_sections ADD IF NOT EXISTS ms_content_source varchar(50) NOT NULL DEFAULT '' AFTER ms_key ", false);
sql_query(" ALTER TABLE g5_plugin_main_content_sections ADD IF NOT EXISTS ms_subtitle varchar(255) NOT NULL DEFAULT '' AFTER ms_title ", false);

$sql_common = " ms_title = '{$ms_title}',
                ms_subtitle = '{$ms_subtitle}',
                ms_skin = '{$ms_skin}',
                ms_bg_color = '{$ms_bg_color}',
                ms_sort = '{$ms_sort}',
                ms_active = '{$ms_active}',
                ms_lang = '{$ms_lang}',
                ms_theme = '{$ms_theme}',
                ms_key = '{$ms_key}',
                ms_show_title = '{$ms_show_title}',
                ms_accent_color = '{$ms_accent_color}',
                ms_content_source = '{$ms_content_source}',
                ms_font_mode = '{$ms_font_mode}' ";

if ($w == '') {
    $sql = " insert into g5_plugin_main_content_sections set $sql_common ";
    sql_query($sql);
    $ms_id = sql_insert_id();
} else if ($w == 'u') {
    $sql = " update g5_plugin_main_content_sections set $sql_common where ms_id = '{$ms_id}' ";
    sql_query($sql);
} else if ($w == 'd') {
    sql_query(" delete from g5_plugin_main_content_sections where ms_id = '{$ms_id}' ");
    sql_query(" delete from g5_plugin_main_content where ms_id = '{$ms_id}' ");
    goto_url('./list.php');
}

// 아이템 업데이트
$mc_ids = $_POST['mc_id'];
$mc_titles = $_POST['mc_title'];
$mc_descs = $_POST['mc_desc'];
$mc_links = $_POST['mc_link'];
$mc_targets = $_POST['mc_target'];
$mc_image_urls = $_POST['mc_image_url'];
$mc_tags = $_POST['mc_tag'];
$mc_subtitles = $_POST['mc_subtitle'];
$mc_link_texts = $_POST['mc_link_text'];

// 기존 아이템 삭제 전 백업 (필요시)
$mc_id_list = array();
foreach($mc_ids as $id) {
    if(!preg_match('/^new_/', $id)) $mc_id_list[] = (int)$id;
}

if(count($mc_id_list) > 0) {
    $sql_in = implode(',', $mc_id_list);
    sql_query(" delete from g5_plugin_main_content where ms_id = '{$ms_id}' and mc_id not in ($sql_in) ");
} else {
    sql_query(" delete from g5_plugin_main_content where ms_id = '{$ms_id}' ");
}

for ($i = 0; $i < count($mc_ids); $i++) {
    $mc_id = $mc_ids[$i];
    $mc_title = sql_real_escape_string($mc_titles[$mc_id]);
    $mc_desc = sql_real_escape_string($mc_descs[$mc_id]);
    $mc_link = sql_real_escape_string($mc_links[$mc_id]);
    $mc_target = sql_real_escape_string($mc_targets[$mc_id]);
    $mc_image = sql_real_escape_string($mc_image_urls[$mc_id]);
    $mc_tag = sql_real_escape_string($mc_tags[$mc_id]);
    $mc_subtitle = sql_real_escape_string($mc_subtitles[$mc_id]);
    $mc_link_text = sql_real_escape_string($mc_link_texts[$mc_id]);
    $mc_sort = $i + 1;

    // [MIGRATION] Add columns if not exists
    sql_query(" ALTER TABLE g5_plugin_main_content ADD IF NOT EXISTS mc_tag varchar(50) NOT NULL DEFAULT '' ", false);
    sql_query(" ALTER TABLE g5_plugin_main_content ADD IF NOT EXISTS mc_subtitle varchar(255) NOT NULL DEFAULT '' ", false);
    sql_query(" ALTER TABLE g5_plugin_main_content ADD IF NOT EXISTS mc_link_text varchar(50) NOT NULL DEFAULT '' ", false);

    $sql_item = " ms_id = '{$ms_id}',
                  mc_title = '{$mc_title}',
                  mc_desc = '{$mc_desc}',
                  mc_link = '{$mc_link}',
                  mc_target = '{$mc_target}',
                  mc_image = '{$mc_image}',
                  mc_tag = '{$mc_tag}',
                  mc_subtitle = '{$mc_subtitle}',
                  mc_link_text = '{$mc_link_text}',
                  mc_sort = '{$mc_sort}' ";

    if (preg_match('/^new_/', $mc_id)) {
        sql_query(" insert into g5_plugin_main_content set $sql_item ");
    } else {
        sql_query(" update g5_plugin_main_content set $sql_item where mc_id = '{$mc_id}' ");
    }
}

goto_url('./write.php?w=u&ms_id=' . $ms_id);
?>