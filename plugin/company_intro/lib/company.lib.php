<?php
if (!defined('_GNUBOARD_'))
    exit;

include_once(G5_LIB_PATH.'/premium_module.lib.php');

function get_plugin_company_content($co_id)
{
    global $g5;
    $table_name = G5_TABLE_PREFIX . "plugin_company_add";
    
    // Use Premium Module Framework for smart loading with fallback
    return get_premium_config($table_name, $co_id, 'co_id');
}
?>