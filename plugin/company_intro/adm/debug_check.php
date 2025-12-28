<?php
// Bypass admin check by including root common.php directly
include_once('../../../common.php');

$co_id = 'ceo';

// Check Plugin Table
$sql1 = " select count(*) as cnt from " . G5_TABLE_PREFIX . "plugin_company_add where co_id = '{$co_id}' ";
$row1 = sql_fetch($sql1);

// Check Standard Content Table
// Usually G5_TABLE_PREFIX . 'content'
$sql2 = " select count(*) as cnt from " . G5_TABLE_PREFIX . "content where co_id = '{$co_id}' ";
$row2 = sql_fetch($sql2);

echo "Plugin Table (plugin_company_add) count for '{$co_id}': " . $row1['cnt'] . "<br>";
echo "Standard Content Table (content) count for '{$co_id}': " . $row2['cnt'] . "<br>";
?>