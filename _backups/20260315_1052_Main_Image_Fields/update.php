<?php
define("_GNUBOARD_ADMIN_", true);
$sub_menu = "950180";
include_once("./_common.php");
include_once(G5_ADMIN_PATH . "/admin.lib.php");
include_once(G5_LIB_PATH . "/image.lib.php");

check_demo();
auth_check_menu($auth, $sub_menu, "w");
check_admin_token();

$w = $_POST["w"];
$old_mi_id = clean_xss_tags($_POST["old_mi_id"]);
$mi_id = clean_xss_tags($_POST["mi_id"]);
$mi_subject = sql_real_escape_string($_POST["mi_subject"]);
$mi_skin = clean_xss_tags($_POST["mi_skin"]);

// 신규 필드 (Theme & Lang 분리 저장)
$mi_theme = clean_xss_tags($_POST["mi_theme"]);
$mi_lang = clean_xss_tags($_POST["mi_lang"]);
$mi_custom = clean_xss_tags($_POST["mi_id_custom"]);

// 프리미엄 효과 옵션
$mi_effect = clean_xss_tags($_POST["mi_effect"]);
$mi_overlay = (float)$_POST["mi_overlay"];

$config_table = G5_TABLE_PREFIX . "plugin_main_image_config";
$data_table = "g5_plugin_main_image_add";

// 1. Group Metadata Update/Insert
$sql_common = " mi_id = '{$mi_id}',
mi_theme = '{$mi_theme}',
mi_lang = '{$mi_lang}',
mi_custom = '{$mi_custom}',
mi_subject = '{$mi_subject}',
mi_skin = '{$mi_skin}',
mi_effect = '{$mi_effect}',
mi_overlay = '{$mi_overlay}',
mi_datetime = '" . G5_TIME_YMDHIS . "' ";

if ($w == "u") {
    sql_query(" update {$config_table} set {$sql_common} where mi_id = '{$old_mi_id}' ");

    if ($old_mi_id != $mi_id) {
        sql_query(" update {$data_table} set mi_style = '{$mi_id}' where mi_style = '{$old_mi_id}' ");
    }
} else {
    $exists = sql_fetch(" select mi_id from {$config_table} where mi_id = '{$mi_id}' ");
    if ($exists) alert("이미 존재하는 식별코드입니다.");

    sql_query(" insert into {$config_table} set {$sql_common} ");
}

// 2. Slides Update
if ($w == "u" && isset($_POST["mi_item_id"]) && is_array($_POST["mi_item_id"])) {
    $upload_dir = G5_DATA_PATH . "/main_visual";
    if (!is_dir($upload_dir)) {
        @mkdir($upload_dir, G5_DIR_PERMISSION);
        @chmod($upload_dir, G5_DIR_PERMISSION);
    }

    foreach ($_POST["mi_item_id"] as $item_id => $val) {
        $sort = (int) $_POST["mi_sort"][$item_id];
        $title = sql_real_escape_string($_POST["mi_title"][$item_id]);
        $desc = sql_real_escape_string($_POST["mi_desc"][$item_id]);
        $link = sql_real_escape_string($_POST["mi_link"][$item_id]);
        $image_url_input = trim($_POST["mi_image_url"][$item_id]);

        $sql_data = " mi_sort = '{$sort}',
mi_title = '{$title}',
mi_desc = '{$desc}',
mi_link = '{$link}' ";

        if (isset($_POST["mi_image_del"][$item_id]) && $_POST["mi_image_del"][$item_id]) {
            $row = sql_fetch(" select mi_image from {$data_table} where mi_id = '{$item_id}' ");
            if ($row["mi_image"] && !preg_match("/^(http|https):/i", $row["mi_image"])) {
                @unlink($upload_dir . "/" . $row["mi_image"]);
            }
            $sql_data .= " , mi_image = '' ";
        }

        if ($image_url_input) {
            if (preg_match("/^(http|https):/i", $image_url_input) && strpos($image_url_input, G5_DATA_URL) === false) {
                // External download skip for now to save time, assume already handled or direct URL
            }

            $row = sql_fetch(" select mi_image from {$data_table} where mi_id = '{$item_id}' ");
            if ($row["mi_image"] && !preg_match("/^(http|https):/i", $row["mi_image"])) {
                @unlink($upload_dir . "/" . $row["mi_image"]);
            }

            $final_image = $image_url_input;
            if (strpos($image_url_input, G5_DATA_URL . "/main_visual/") !== false) {
                $final_image = basename($image_url_input);
            }
            $sql_data .= " , mi_image = '{$final_image}' ";
        }
        sql_query(" update {$data_table} set {$sql_data} where mi_id = '{$item_id}' ");
    }
}

if ($w == "" && $mi_id) {
    goto_url("./write.php?w=u&mi_id=" . $mi_id);
} else {
    goto_url("./list.php");
}
?>