<?php
if (!defined('_GNUBOARD_'))
    exit;

$table_name = G5_TABLE_PREFIX . 'plugin_copyright';
$old_table = G5_TABLE_PREFIX . 'copyright_config';

// Create new table
$sql = " CREATE TABLE IF NOT EXISTS `{$table_name}` (
            `cp_id` varchar(20) NOT NULL DEFAULT '',
            `cp_subject` varchar(255) NOT NULL DEFAULT '',
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
            `cp_content` mediumtext NOT NULL,
            `cp_skin` varchar(50) NOT NULL DEFAULT 'style_a',
            `cp_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`cp_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";

sql_query($sql, true);

// Migration Logic: Check if old table exists and has data
$old_row = sql_fetch(" SHOW TABLES LIKE '{$old_table}' ");
if ($old_row) {
    $cp = sql_fetch(" select * from {$old_table} where id = 1 ");
    if ($cp) {
        // Check if default already exists in new table
        $check = sql_fetch(" select count(*) as cnt from {$table_name} where cp_id = 'default' ");
        if ($check['cnt'] == 0) {
            $sql = " insert into {$table_name}
                        set cp_id = 'default',
                            cp_subject = '기본 카피라이트',
                            logo_url = '{$cp['logo_url']}',
                            addr_label = '{$cp['addr_label']}',
                            addr_val = '{$cp['addr_val']}',
                            tel_label = '{$cp['tel_label']}',
                            tel_val = '{$cp['tel_val']}',
                            fax_label = '{$cp['fax_label']}',
                            fax_val = '{$cp['fax_val']}',
                            email_label = '{$cp['email_label']}',
                            email_val = '{$cp['email_val']}',
                            slogan = '{$cp['slogan']}',
                            copyright = '{$cp['copyright']}',
                            link1_name = '{$cp['link1_name']}',
                            link1_url = '{$cp['link1_url']}',
                            link2_name = '{$cp['link2_name']}',
                            link2_url = '{$cp['link2_url']}',
                            cp_skin = 'style_a',
                            cp_datetime = '" . G5_TIME_YMDHIS . "' ";
            sql_query($sql);
        }
    }
} else {
    // Initialize if brand new
    $row = sql_fetch(" select count(*) as cnt from `{$table_name}` ");
    if ($row['cnt'] == 0) {
        sql_query(" insert into `{$table_name}` (cp_id, cp_subject, addr_label, tel_label, fax_label, email_label, copyright, cp_datetime) values ('default', '기본 카피라이트', '주소', '연락처', '팩스', '이메일', 'Copyright &copy; All rights reserved.', '" . G5_TIME_YMDHIS . "') ");
    }
}
?>