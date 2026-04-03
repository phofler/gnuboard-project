<?php
include_once('./_common.php');
$sql = "select mc_image, mc_title from g5_plugin_main_content";
$res = sql_query($sql);
while($row = sql_fetch_array($res)) {
    echo $row['mc_image'] . " | " . $row['mc_title'] . "\n";
}
?>
