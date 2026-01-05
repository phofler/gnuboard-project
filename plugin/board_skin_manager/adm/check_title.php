<?php
include_once('./_common.php');
echo "Table Constant: " . G5_PLUGIN_BOARD_SKIN_TABLE . "<br>";
$row = sql_fetch(" SELECT * FROM " . G5_PLUGIN_BOARD_SKIN_TABLE . " WHERE bs_id = 1 ");
echo "Current Title: [" . $row['bs_title'] . "]<br>";
?>