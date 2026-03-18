<?php
include_once("./common.php");
echo "Current Theme: " . $config['cf_theme'] . "\n";
echo "G5_THEME_PATH: " . G5_THEME_PATH . "\n";
echo "G5_THEME_URL: " . G5_THEME_URL . "\n";

$bo_table = "news";
$board = sql_fetch(" SELECT * FROM {$g5['board_table']} WHERE bo_table = '$bo_table' ");
echo "Board Skin: " . $board['bo_skin'] . "\n";
echo "Board Mobile Skin: " . $board['bo_mobile_skin'] . "\n";
?>