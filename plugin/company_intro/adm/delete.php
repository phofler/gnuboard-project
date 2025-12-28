<?php
include_once('./_common.php');

if ($co_id) {
    $co_id = preg_replace('/[^a-z0-9_]/i', '', $co_id);
    $sql = " delete from " . G5_TABLE_PREFIX . "plugin_company_add where co_id = '{$co_id}' ";
    sql_query($sql);
}

goto_url('./list.php');
?>