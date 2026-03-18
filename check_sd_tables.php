<?php
include_once("./common.php");
$tables = array("g5_plugin_sub_design_groups", "g5_plugin_sub_design_items");
foreach($tables as $t) {
    $res = sql_query("SHOW TABLES LIKE '$t'");
    if(sql_num_rows($res) > 0) echo "$t: EXISTS\n"; else echo "$t: NOT_EXISTS\n";
}
?>