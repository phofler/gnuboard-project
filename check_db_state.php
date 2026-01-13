<?php
include_once('./common.php');
$bo_table = 'chamcode_gallery';
$bo = sql_fetch("select bo_category_list from {$g5['board_table']} where bo_table = '$bo_table' ");
echo "BO_CATEGORY_LIST: " . $bo['bo_category_list'] . "\n";

$res = sql_query("select wr_id, ca_name from {$g5['write_prefix']}$bo_table order by wr_id desc limit 10");
while ($row = sql_fetch_array($res)) {
    echo $row['wr_id'] . " : " . $row['ca_name'] . "\n";
}
?>