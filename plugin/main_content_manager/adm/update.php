<?php
$sub_menu = "800190";
include_once('./_common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

check_demo();
auth_check_menu($auth, $sub_menu, 'w');
// check_admin_token();

$w = isset($_POST['w']) ? $_POST['w'] : (isset($_GET['w']) ? $_GET['w'] : '');
$ms_id = isset($_POST['ms_id']) ? (int) $_POST['ms_id'] : (isset($_GET['ms_id']) ? (int) $_GET['ms_id'] : 0);

$upload_dir = G5_DATA_PATH . '/common_assets';
if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, G5_DIR_PERMISSION);
    @chmod($upload_dir, G5_DIR_PERMISSION);
}

// 1. 섹션 정보 삭제
if ($w == 'd') {
    // 상품 이미지 삭제
    $sql = " select mc_image from g5_plugin_main_content where ms_id = '{$ms_id}' ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result)) {
        if ($row['mc_image'] && !preg_match("/^(http|https):/i", $row['mc_image'])) {
            @unlink($upload_dir . '/' . $row['mc_image']);
        }
    }
    // DB 삭제
    sql_query(" delete from g5_plugin_main_content_sections where ms_id = '{$ms_id}' ");
    sql_query(" delete from g5_plugin_main_content where ms_id = '{$ms_id}' ");
    goto_url('./list.php');
}

// 2. 개별 아이템 삭제 (섹션 내에서 호출)
if ($w == 'di') {
    $mc_id = (int) $_GET['mc_id'];
    $sql = " select mc_image from g5_plugin_main_content where mc_id = '{$mc_id}' ";
    $row = sql_fetch($sql);
    if ($row['mc_image'] && !preg_match("/^(http|https):/i", $row['mc_image'])) {
        @unlink($upload_dir . '/' . $row['mc_image']);
    }
    sql_query(" delete from g5_plugin_main_content where mc_id = '{$mc_id}' ");
    goto_url('./write.php?w=u&ms_id=' . $ms_id);
}

// 3. 섹션 정보 저장 (Update/Insert)
$ms_title = sql_real_escape_string($_POST['ms_title']);
$ms_skin = sql_real_escape_string($_POST['ms_skin']);
$ms_sort = (int) $_POST['ms_sort'];
$ms_active = isset($_POST['ms_active']) ? 1 : 0;
$ms_show_title = isset($_POST['ms_show_title']) ? 1 : 0;
$ms_accent_color = sql_real_escape_string($_POST['ms_accent_color']);
$ms_font_mode = sql_real_escape_string($_POST['ms_font_mode']);
$ms_bg_color = sql_real_escape_string($_POST['ms_bg_color']);
$ms_content_source = isset($_POST['ms_content_source']) ? sql_real_escape_string($_POST['ms_content_source']) : '';

// [MIGRATION] Auto-add column if not exists
sql_query(" ALTER TABLE g5_plugin_main_content_sections ADD IF NOT EXISTS ms_bg_color varchar(20) NOT NULL DEFAULT '' AFTER ms_font_mode ", false);
sql_query(" ALTER TABLE g5_plugin_main_content_sections ADD IF NOT EXISTS ms_content_source varchar(50) NOT NULL DEFAULT '' AFTER ms_key ", false);

$sql_common = " ms_title = '{$ms_title}',
                ms_skin = '{$ms_skin}',
                ms_bg_color = '{$ms_bg_color}',
                ms_content_source = '{$ms_content_source}',
                ms_sort = '{$ms_sort}',
                ms_active = '{$ms_active}',
                ms_show_title = '{$ms_show_title}',
                ms_lang = '{$_POST['ms_lang']}',
                ms_theme = '{$_POST['ms_theme']}',
                ms_key = '{$_POST['ms_key']}',
                ms_accent_color = '{$ms_accent_color}',
                ms_font_mode = '{$ms_font_mode}' ";

if ($w == 'u') {
    $sql = " update g5_plugin_main_content_sections set {$sql_common} where ms_id = '{$ms_id}' ";
    sql_query($sql);
} else {
    $sql = " insert into g5_plugin_main_content_sections set {$sql_common} ";
    sql_query($sql);
    $ms_id = sql_insert_id();
}

// 4. 아이템 정보 저장
if (isset($_POST['mc_id']) && is_array($_POST['mc_id'])) {
    foreach ($_POST['mc_id'] as $i => $mi_id) {
        $mc_title = sql_real_escape_string($_POST['mc_title'][$mi_id]);
        $mc_desc = sql_real_escape_string($_POST['mc_desc'][$mi_id]);
        $mc_link = sql_real_escape_string($_POST['mc_link'][$mi_id]);
        $mc_target = sql_real_escape_string($_POST['mc_target'][$mi_id]);
        $mc_sort = $i + 1;

        $mc_common = " ms_id = '{$ms_id}',
                       mc_title = '{$mc_title}',
                       mc_desc = '{$mc_desc}',
                       mc_link = '{$mc_link}',
                       mc_target = '{$mc_target}',
                       mc_sort = '{$mc_sort}' ";

        // 이미지 처리
        $mc_image_url = isset($_POST['mc_image_url'][$mi_id]) ? trim($_POST['mc_image_url'][$mi_id]) : '';
        $mc_image_del = isset($_POST['mc_image_del'][$mi_id]) ? true : false;

        // 신규 아이디인 경우 임시 처리
        $is_new = strpos($mi_id, 'new_') !== false;

        if ($mc_image_del && !$is_new) {
            $row = sql_fetch(" select mc_image from g5_plugin_main_content where mc_id = '{$mi_id}' ");
            if ($row['mc_image'] && !preg_match("/^(http|https):/i", $row['mc_image'])) {
                @unlink($upload_dir . '/' . $row['mc_image']);
            }
            $mc_common .= " , mc_image = '' ";
        }

        if (isset($_FILES['mc_image']['name'][$mi_id]) && $_FILES['mc_image']['name'][$mi_id]) {
            $filename = $_FILES['mc_image']['name'][$mi_id];
            $filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);
            $new_name = time() . '_' . $filename;
            $dest_file = $upload_dir . '/' . $new_name;

            if (move_uploaded_file($_FILES['mc_image']['tmp_name'][$mi_id], $dest_file)) {
                chmod($dest_file, G5_FILE_PERMISSION);

                if (!$is_new) {
                    $row = sql_fetch(" select mc_image from g5_plugin_main_content where mc_id = '{$mi_id}' ");
                    if ($row['mc_image'] && !preg_match("/^(http|https):/i", $row['mc_image'])) {
                        @unlink($upload_dir . '/' . $row['mc_image']);
                    }
                }
                $mc_common .= " , mc_image = '{$new_name}' ";
            }
        } else if ($mc_image_url) {
            if (!$is_new) {
                $row = sql_fetch(" select mc_image from g5_plugin_main_content where mc_id = '{$mi_id}' ");
                if ($row['mc_image'] && !preg_match("/^(http|https):/i", $row['mc_image'])) {
                    @unlink($upload_dir . '/' . $row['mc_image']);
                }
            }
            $mc_common .= " , mc_image = '{$mc_image_url}' ";
        }

        // 아이템 저장 (신규면 Insert, 아니면 Update)
        // 단, 제목이나 설명이 있는 경우에만 저장 (빈 항목 제외)
        if ($mc_title || $mc_desc || $mc_image_url || (isset($_FILES['mc_image']['name'][$mi_id]) && $_FILES['mc_image']['name'][$mi_id])) {
            if ($is_new) {
                sql_query(" insert into g5_plugin_main_content set {$mc_common} ");
            } else {
                sql_query(" update g5_plugin_main_content set {$mc_common} where mc_id = '{$mi_id}' ");
            }
        }
    }
}

goto_url('./list.php');
?>