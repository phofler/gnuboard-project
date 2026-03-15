<?php
include_once('./common.php');
// if(!$is_admin) die('No access'); // Temporary bypass for CLI

$sql = " DESCRIBE g5_plugin_main_image_add ";
$res = sql_query($sql);
echo "SCHEMA_START\n";
while ($row = sql_fetch_array($res)) {
    echo "{$row['Field']} | {$row['Type']} | {$row['Null']} | {$row['Key']} | {$row['Default']} | {$row['Extra']}\n";
}
echo "SCHEMA_END\n";
?>