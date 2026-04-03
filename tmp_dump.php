<?php
define('_GNUBOARD_', true);
include 'common.php';

echo "SECTIONS:\n";
$sql = "select * from g5_plugin_main_content_sections order by ms_sort asc, ms_id asc";
$result = sql_query($sql);
while($row = sql_fetch_array($result)) {
    echo "ID: {$row['ms_id']}, Title: {$row['ms_title']}, Skin: {$row['ms_skin']}, ShowTitle: {$row['ms_show_title']}, Active: {$row['ms_active']}\n";
}

echo "\nITEMS:\n";
$sql = "select mc_id, ms_id, mc_title, mc_image from g5_plugin_main_content order by ms_id asc, mc_sort asc";
$result = sql_query($sql);
while($row = sql_fetch_array($result)) {
    echo "ID: {$row['mc_id']}, Section: {$row['ms_id']}, Title: {$row['mc_title']}, Image: {$row['mc_image']}\n";
}
?>
