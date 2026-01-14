<?php
include_once('./_common.php');
$table = G5_TABLE_PREFIX . 'plugin_board_skin_config';

echo "<h2>Fixing Schema for $table</h2>";

// 1. Remove Auto Increment (by modifying to INT first without AI)
// We also drop primary key if we want to re-define it, but usually just modifying the column works.
// However, if it's AI, we must redefine it.
$sql1 = " ALTER TABLE {$table} MODIFY bs_id VARCHAR(100) NOT NULL DEFAULT '' ";
$result1 = sql_query($sql1, false);

if ($result1) {
    echo "<p>Successfully changed bs_id to VARCHAR(100).</p>";
} else {
    echo "<p>Failed to change bs_id: " . sql_error_info() . "</p>";
    // Try explicit drop of AI if the above failed (though modify usually handles it)
}

// Check Result
$row = sql_fetch(" SHOW CREATE TABLE {$table} ");
echo "<pre>" . htmlspecialchars($row['Create Table']) . "</pre>";
?>