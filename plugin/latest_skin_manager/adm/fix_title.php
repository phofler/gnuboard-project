<?php
include_once('./_common.php');
// Update
$sql = " UPDATE " . G5_PLUGIN_BOARD_SKIN_TABLE . " SET bs_title = 'Selected Works' WHERE bs_id = 1 ";
$result = sql_query($sql);

if ($result) {
    echo "Update Query Executed.<br>";
} else {
    echo "Update Query Failed: " . sql_error_info() . "<br>";
}

// Verify
$row = sql_fetch(" SELECT * FROM " . G5_PLUGIN_BOARD_SKIN_TABLE . " WHERE bs_id = 1 ");
echo "New Title: [" . $row['bs_title'] . "]<br>";
?>