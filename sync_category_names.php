<?php
include_once('./_common.php');

$bo_table = isset($_GET['bo_table']) ? $_GET['bo_table'] : 'chamcode_gallery';

echo "<h1>Syncing Categories for Board: {$bo_table}</h1>";

// 1. Get Root Code for this board
$row = sql_fetch(" select * from {$g5['board_table']} where bo_table = '{$bo_table}' ");
if (!$row['bo_table']) {
    die("Board '{$bo_table}' not found.");
}

// 2. Fetch Board List
$list = $row['bo_category_list'];
echo "<h3>Original Board Config (bo_category_list):</h3><pre>{$list}</pre>";

// 3. Simple Fix: Replace mismatch
// Current state: "RESIDENCE1"
// Target state: "RESIDENCE"

$new_list = str_replace("RESIDENCE1", "RESIDENCE", $list);

// Safety check: Don't replace if it becomes empty or weird?
// No, "RESIDENCE" is valid.

echo "<h3>New Board Config:</h3><pre>{$new_list}</pre>";

if ($list !== $new_list) {
    sql_query(" update {$g5['board_table']} set bo_category_list = '" . sql_real_escape_string($new_list) . "' where bo_table = '{$bo_table}' ");
    echo "<h2>Updated Successfully! (RESIDENCE1 -> RESIDENCE)</h2>";
} else {
    echo "<h2>No changes needed (Strings match).</h2>";
}
?>