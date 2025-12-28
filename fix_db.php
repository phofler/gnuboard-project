<?php
include_once('./common.php');

$table_name = G5_TABLE_PREFIX . 'plugin_company_add';

echo "Table: " . $table_name . "<br>";

// 1. Check if table exists
$chk = sql_fetch(" SHOW TABLES LIKE '{$table_name}' ");
if (!$chk) {
    echo "Table does not exist. Creating...<br>";
    $sql = " CREATE TABLE IF NOT EXISTS `{$table_name}` (
                `co_id` varchar(20) NOT NULL DEFAULT '',
                `co_subject` varchar(255) NOT NULL DEFAULT '',
                `co_content` mediumtext NOT NULL,
                `co_skin` varchar(50) NOT NULL DEFAULT '',
                `co_bgcolor` varchar(20) NOT NULL DEFAULT '#000000',
                `co_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`co_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";
    sql_query($sql, true);
}

// 2. Check column
$row = sql_fetch(" SHOW COLUMNS FROM `{$table_name}` LIKE 'co_bgcolor' ");
if (!$row) {
    echo "Adding 'co_bgcolor' column...<br>";
    $sql = " ALTER TABLE `{$table_name}` ADD `co_bgcolor` varchar(20) NOT NULL DEFAULT '#000000' AFTER `co_skin` ";
    sql_query($sql, true);

    // Verify
    $row2 = sql_fetch(" SHOW COLUMNS FROM `{$table_name}` LIKE 'co_bgcolor' ");
    if ($row2)
        echo "SUCCESS: Column added.<br>";
    else
        echo "ERROR: Failed to add column.<br>";
} else {
    echo "Column 'co_bgcolor' already exists.<br>";
}

echo "Done.";
?>