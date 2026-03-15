<?php
include_once('./_common.php');
if (!defined('G5_IS_ADMIN'))
    exit;

$sql = " SHOW COLUMNS FROM g5_plugin_main_content_sections LIKE 'ms_bg_mode' ";
$row = sql_fetch($sql);

if (!$row) {
    sql_query(" ALTER TABLE g5_plugin_main_content_sections ADD ms_bg_mode varchar(20) DEFAULT 'default' AFTER ms_skin ");
    echo "Column ms_bg_mode added successfully.";
} else {
    echo "Column ms_bg_mode already exists.";
}
?>