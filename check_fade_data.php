<?php
include_once('./common.php');
$table_name = "g5_plugin_main_image_add";
$style = 'fade';

echo "--- Checking records for style: {$style} ---\n";
$sql = " select * from {$table_name} where mi_style = '{$style}' order by mi_sort asc ";
$result = sql_query($sql);
$count = 0;
while ($row = sql_fetch_array($result)) {
    print_r($row);
    $count++;
}
echo "Total records found: {$count}\n";
?>