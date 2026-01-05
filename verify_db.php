<?php
include_once('./common.php');
$table_name = "g5_plugin_main_image_add";
$sql = " select * from {$table_name} where mi_style = 'ultimate_hero' ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    print_r($row);
}
?>