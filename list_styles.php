<?php
include_once('./common.php');
$table_name = "g5_plugin_main_image_add";

echo "--- Distinct mi_style values ---\n";
$sql = " select distinctly mi_style from {$table_name} "; // Wait, sql syntax error: 'distinct'
$sql = " select distinct(mi_style) as st from {$table_name} ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    echo $row['st'] . "\n";
}
?>