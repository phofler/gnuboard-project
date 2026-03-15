<?php
include_once('./_common.php');
if (!defined('G5_IS_ADMIN'))
    die('No access');
$sql = " alter table g5_plugin_sub_design_groups add sd_layout varchar(20) not null default 'full' after sd_skin ";
sql_query($sql, false); // false to ignore if exists
echo "Column added or already exists";
?>