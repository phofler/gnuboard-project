<?php
if (!defined('_GNUBOARD_'))
    exit;

$table_name = "g5_plugin_top_menu_config";

// Check if table exists
if (!sql_query(" DESCRIBE {$table_name} ", false)) {
    $sql = " CREATE TABLE IF NOT EXISTS `{$table_name}` (
        `tm_id` varchar(255) NOT NULL DEFAULT '',
        `tm_skin` varchar(255) NOT NULL DEFAULT '',
        `tm_logo_pc` varchar(255) NOT NULL DEFAULT '',
        `tm_logo_mo` varchar(255) NOT NULL DEFAULT '',
        `tm_menu_table` varchar(255) NOT NULL DEFAULT '',
        `tm_reg_dt` datetime DEFAULT NULL,
        PRIMARY KEY (`tm_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";

    sql_query($sql);
}
?>