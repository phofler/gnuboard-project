<?php
include_once('./common.php');

$bo_table = 'online';
$bo_subject = '온라인문의';

// 1. Check & Insert into g5_board
$exists = sql_fetch(" select count(*) as cnt from {$g5['board_table']} where bo_table = '{$bo_table}' ");
if (!$exists['cnt']) {
    // Get Group ID
    $grp = sql_fetch(" select gr_id from {$g5['group_table']} limit 1 ");
    $gr_id = $grp['gr_id'] ? $grp['gr_id'] : 'default';
    if ($gr_id == 'default') {
        sql_query(" insert into {$g5['group_table']} set gr_id = 'default', gr_subject = 'Default Group' ", false);
    }

    // Insert Board
    $sql = " insert into {$g5['board_table']}
                set bo_table = '{$bo_table}',
                    gr_id = '{$gr_id}',
                    bo_subject = '{$bo_subject}',
                    bo_device = 'both',
                    bo_admin = '',
                    bo_list_level = 1,
                    bo_read_level = 1,
                    bo_write_level = 1,
                    bo_reply_level = 1,
                    bo_comment_level = 1,
                    bo_upload_level = 1,
                    bo_download_level = 1,
                    bo_html_level = 1,
                    bo_link_level = 1,
                    bo_skin = 'theme/basic',
                    bo_mobile_skin = 'theme/basic',
                    bo_upload_count = 2,
                    bo_upload_size = 1048576,
                    bo_use_search = 1,
                    bo_order = 0
            ";
    sql_query($sql);
    echo "Inserted into g5_board.<br>";
} else {
    echo "Board row already exists.<br>";
}

// 2. Create Write Table
$write_table = $g5['write_prefix'] . $bo_table;
$table_exists = sql_fetch(" SHOW TABLES LIKE '{$write_table}' ");
if (!$table_exists) {
    // Modified to use valid default for datetime
    $sql = "
    CREATE TABLE IF NOT EXISTS `{$write_table}` (
      `wr_id` int(11) NOT NULL AUTO_INCREMENT,
      `wr_num` int(11) NOT NULL DEFAULT '0',
      `wr_reply` varchar(10) NOT NULL,
      `wr_parent` int(11) NOT NULL DEFAULT '0',
      `wr_is_comment` tinyint(4) NOT NULL DEFAULT '0',
      `wr_comment` int(11) NOT NULL DEFAULT '0',
      `wr_comment_reply` varchar(5) NOT NULL,
      `ca_name` varchar(255) NOT NULL,
      `wr_option` set('html1','html2','secret','mail') NOT NULL,
      `wr_subject` varchar(255) NOT NULL,
      `wr_content` text NOT NULL,
      `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
      `wr_link1` text NOT NULL,
      `wr_link2` text NOT NULL,
      `wr_link1_hit` int(11) NOT NULL DEFAULT '0',
      `wr_link2_hit` int(11) NOT NULL DEFAULT '0',
      `wr_hit` int(11) NOT NULL DEFAULT '0',
      `wr_good` int(11) NOT NULL DEFAULT '0',
      `wr_nogood` int(11) NOT NULL DEFAULT '0',
      `mb_id` varchar(20) NOT NULL,
      `wr_password` varchar(255) NOT NULL,
      `wr_name` varchar(255) NOT NULL,
      `wr_email` varchar(255) NOT NULL,
      `wr_homepage` varchar(255) NOT NULL,
      `wr_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `wr_file` tinyint(4) NOT NULL DEFAULT '0',
      `wr_last` varchar(19) NOT NULL,
      `wr_ip` varchar(255) NOT NULL,
      `wr_facebook_user` varchar(255) NOT NULL,
      `wr_twitter_user` varchar(255) NOT NULL,
      `wr_1` varchar(255) NOT NULL,
      `wr_2` varchar(255) NOT NULL,
      `wr_3` varchar(255) NOT NULL,
      `wr_4` varchar(255) NOT NULL,
      `wr_5` varchar(255) NOT NULL,
      `wr_6` varchar(255) NOT NULL,
      `wr_7` varchar(255) NOT NULL,
      `wr_8` varchar(255) NOT NULL,
      `wr_9` varchar(255) NOT NULL,
      `wr_10` varchar(255) NOT NULL,
      PRIMARY KEY (`wr_id`),
      KEY `wr_seo_title` (`wr_seo_title`),
      KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
      KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    ";
    sql_query($sql);
    echo "Created table {$write_table}.<br>";
} else {
    echo "Table {$write_table} already exists.<br>";
}

// 3. Create Directory
$board_path = G5_DATA_PATH . '/file/' . $bo_table;
@mkdir($board_path, G5_DIR_PERMISSION);
@chmod($board_path, G5_DIR_PERMISSION);

// Create index.php in directory
$file = $board_path . '/index.php';
if ($f = @fopen($file, 'w')) {
    @fwrite($f, '');
    @fclose($f);
    @chmod($file, G5_FILE_PERMISSION);
}
echo "Checked directory {$board_path}.<br>";

echo "Done.";
?>