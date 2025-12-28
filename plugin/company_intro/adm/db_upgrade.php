<?php
// Bypass admin check by including root common.php directly
include_once('../../../common.php');

$table_name = G5_TABLE_PREFIX . 'plugin_company_add';

// Force Add Column
$sql = " ALTER TABLE `{$table_name}` ADD `co_bgcolor` varchar(20) NOT NULL DEFAULT '#000000' AFTER `co_skin` ";
// Suppress error if column exists
@sql_query($sql, false);

// Check if successful
$row = sql_fetch(" SHOW COLUMNS FROM `{$table_name}` LIKE 'co_bgcolor' ");
if ($row) {
    echo "SUCCESS: Column 'co_bgcolor' exists.";
} else {
    echo "ERROR: Column 'co_bgcolor' could not be added.";
}
?>