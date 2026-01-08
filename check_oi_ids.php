<?php
include_once('./common.php');
$config_table = G5_TABLE_PREFIX . 'plugin_online_inquiry_config';
$res = sql_query("select oi_id from $config_table");
while ($row = sql_fetch_array($res)) {
    echo $row['oi_id'] . "\n";
}
?>