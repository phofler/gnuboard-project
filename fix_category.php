<?php
include_once('./common.php');
$bo_table = 'chamcode_gallery';

// 1. Check current state
$row = sql_fetch(" select bo_category_list from {$g5['board_table']} where bo_table = '{$bo_table}' ");
echo "BEFORE: " . $row['bo_category_list'] . "\n";

// 2. Define Clean List (Based on existing posts and standard hierarchy)
// The corrupted one was: RESIDENCE11111|RESIDENCE11111  서울|...
// We will restore it to: RESIDENCE|RESIDENCE > 서울|...
// Note: Gnuboard implementation plan mentioned "RESIDENCE > 서울" format.
// Let's use the standard format.
$clean_list = "RESIDENCE|RESIDENCE > 서울|RESIDENCE > 서울 > 은평구|RESIDENCE > 인천|RESIDENCE > 청주|COMMERCIAL";

// 3. Update
sql_query(" update {$g5['board_table']} set bo_category_list = '{$clean_list}' where bo_table = '{$bo_table}' ");

// 4. Verify
$row = sql_fetch(" select bo_category_list from {$g5['board_table']} where bo_table = '{$bo_table}' ");
echo "AFTER : " . $row['bo_category_list'] . "\n";
?>