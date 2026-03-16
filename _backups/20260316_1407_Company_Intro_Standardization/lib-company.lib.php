<?php
if (!defined('_GNUBOARD_'))
    exit;

function get_plugin_company_content($co_id)
{
    global $g5;

    // SQL Injection 방지
    $co_id = preg_replace('/[^a-z0-9_]/i', '', $co_id);

    if (!$co_id)
        return false;

    $sql = " select * from " . G5_TABLE_PREFIX . "plugin_company_add where co_id = '{$co_id}' ";
    $row = sql_fetch($sql);

    return $row;
}
?>