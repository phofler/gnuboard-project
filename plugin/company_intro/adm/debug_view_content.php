<?php
include_once('../../../common.php');
$co_id = 'company';
$sql = " select * from " . G5_TABLE_PREFIX . "plugin_company_add where co_id = '{$co_id}' ";
$row = sql_fetch($sql);
echo "<pre>";
print_r($row);
echo "</pre>";
?>