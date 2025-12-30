<?php
include_once('./common.php');
if (!$is_admin)
    die('admin only');

echo "<h2>g5_write_menu_pdc (Pro Menu)</h2>";
$res = sql_query(" SELECT * FROM g5_write_menu_pdc ORDER BY ma_code ASC ");
while ($row = sql_fetch_array($res)) {
    echo "ID: {$row['ma_id']} | Code: {$row['ma_code']} | Name: {$row['ma_name']} | Use: {$row['ma_use']} | MenuUse: {$row['ma_menu_use']} | Link: {$row['ma_link']}<br>";
}

echo "<h2>g5_tree_category_add (Tree Category)</h2>";
$res = sql_query(" SELECT * FROM g5_tree_category_add ORDER BY tc_code ASC ");
while ($row = sql_fetch_array($res)) {
    echo "ID: {$row['tc_id']} | Code: {$row['tc_code']} | Name: {$row['tc_name']} | Use: {$row['tc_use']} | MenuUse: {$row['tc_menu_use']}<br>";
}
?>