<?php
if (!defined('_GNUBOARD_'))
    exit;

$table_name = G5_TABLE_PREFIX . 'copyright_config';

// Create table if not exists
$sql = " CREATE TABLE IF NOT EXISTS `{$table_name}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `logo_url` varchar(255) NOT NULL DEFAULT '',
            `addr_label` varchar(50) NOT NULL DEFAULT '주소',
            `addr_val` varchar(255) NOT NULL DEFAULT '',
            `tel_label` varchar(50) NOT NULL DEFAULT '연락처',
            `tel_val` varchar(255) NOT NULL DEFAULT '',
            `fax_label` varchar(50) NOT NULL DEFAULT '팩스',
            `fax_val` varchar(255) NOT NULL DEFAULT '',
            `email_label` varchar(50) NOT NULL DEFAULT '이메일',
            `email_val` varchar(255) NOT NULL DEFAULT '',
            `slogan` text NOT NULL,
            `copyright` text NOT NULL,
            `link1_name` varchar(100) NOT NULL DEFAULT '',
            `link1_url` varchar(255) NOT NULL DEFAULT '',
            `link2_name` varchar(100) NOT NULL DEFAULT '',
            `link2_url` varchar(255) NOT NULL DEFAULT '',
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";

sql_query($sql, true);

// Initialize with default row if empty
$row = sql_fetch(" select count(*) as cnt from `{$table_name}` ");
if ($row['cnt'] == 0) {
    sql_query(" insert into `{$table_name}` (id, addr_label, tel_label, fax_label, email_label, copyright) values (1, '주소', '연락처', '팩스', '이메일', 'Copyright &copy; All rights reserved.') ");
}

// Check for slogan column and add if missing
$row = sql_fetch(" SHOW COLUMNS FROM `{$table_name}` LIKE 'slogan' ");
if (!$row) {
    sql_query(" ALTER TABLE `{$table_name}` ADD `slogan` text NOT NULL AFTER `email_val` ");
}
?>