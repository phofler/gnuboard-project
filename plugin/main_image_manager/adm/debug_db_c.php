<?php
include_once('./_common.php');

$style = 'C';
$sql = " SELECT * FROM g5_plugin_main_image_add WHERE mi_style = '{$style}' ORDER BY mi_sort ASC ";
$result = sql_query($sql);

echo "<pre>";
echo "Style C Data Debug:\n";
while ($row = sql_fetch_array($result)) {
    echo "ID: " . $row['mi_id'] . "\n";
    echo "Title: [" . $row['mi_title'] . "]\n";
    echo "Desc: [" . $row['mi_desc'] . "]\n";
    echo "Link: [" . $row['mi_link'] . "]\n";
    echo "Image: [" . $row['mi_image'] . "]\n";
    echo "--------------------------\n";
}
echo "</pre>";
?>