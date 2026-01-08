<?php
if (!defined('_GNUBOARD_'))
    exit;

$table_name = G5_TABLE_PREFIX . 'plugin_map_api';

if (!sql_query(" DESC {$table_name} ", false)) {
    $sql = " CREATE TABLE IF NOT EXISTS `{$table_name}` (
                `ma_id` varchar(255) NOT NULL DEFAULT '',
                `ma_provider` varchar(20) NOT NULL DEFAULT 'naver',
                `ma_lat` varchar(50) NOT NULL DEFAULT '',
                `ma_lng` varchar(50) NOT NULL DEFAULT '',
                `ma_api_key` varchar(255) NOT NULL DEFAULT '',
                `ma_client_id` varchar(255) NOT NULL DEFAULT '',
                `ma_regdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`ma_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8; ";
    sql_query($sql, true);
}
?>