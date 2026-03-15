<?php
include_once('./_common.php');
echo "Starting Database Fix...<br>";

// 1. Fix Database Data (Revert 'basic' -> 'A', etc.)
sql_query("UPDATE g5_plugin_main_image_add SET mi_style = 'A' WHERE mi_style = 'basic'");
sql_query("UPDATE g5_plugin_main_image_add SET mi_style = 'B' WHERE mi_style = 'full'");
sql_query("UPDATE g5_plugin_main_image_add SET mi_style = 'C' WHERE mi_style = 'fade'");
echo "Database Updated.<br>";

// 2. Fix Active Style File
$active_file = G5_PLUGIN_PATH . '/main_image_manager/active_style.php';
file_put_contents($active_file, 'A');
echo "Active Style File Reset to A.<br>";

echo "Fix Complete.";
?>