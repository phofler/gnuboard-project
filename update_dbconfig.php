<?php
$content = "<?php
if (!defined('_GNUBOARD_')) exit;
define('G5_MYSQL_HOST', 'localhost');
define('G5_MYSQL_USER', 'root');
define('G5_MYSQL_PASSWORD', '');
define('G5_MYSQL_DB', 'gnuboard5');
define('G5_MYSQL_SET_MODE', false);

define('G5_DOMAIN', '');
define('G5_HTTPS_DOMAIN', '');
define('G5_URL', 'http://localhost');

define('G5_TABLE_PREFIX', 'g5_');

\$g5['write_prefix'] = G5_TABLE_PREFIX.'write_';

\$g5['auth_table'] = G5_TABLE_PREFIX.'auth';
\$g5['config_table'] = G5_TABLE_PREFIX.'config';
\$g5['group_table'] = G5_TABLE_PREFIX.'group';
\$g5['group_member_table'] = G5_TABLE_PREFIX.'group_member';
\$g5['board_table'] = G5_TABLE_PREFIX.'board';
\$g5['board_file_table'] = G5_TABLE_PREFIX.'board_file';
\$g5['board_good_table'] = G5_TABLE_PREFIX.'board_good';
\$g5['board_new_table'] = G5_TABLE_PREFIX.'board_new';
\$g5['login_table'] = G5_TABLE_PREFIX.'login';
\$g5['mail_table'] = G5_TABLE_PREFIX.'mail';
\$g5['member_table'] = G5_TABLE_PREFIX.'member';
\$g5['memo_table'] = G5_TABLE_PREFIX.'memo';
\$g5['poll_table'] = G5_TABLE_PREFIX.'poll';
\$g5['poll_etc_table'] = G5_TABLE_PREFIX.'poll_etc';
\$g5['point_table'] = G5_TABLE_PREFIX.'point';
\$g5['popular_table'] = G5_TABLE_PREFIX.'popular';
\$g5['scrap_table'] = G5_TABLE_PREFIX.'scrap';
\$g5['visit_table'] = G5_TABLE_PREFIX.'visit';
\$g5['visit_sum_table'] = G5_TABLE_PREFIX.'visit_sum';
\$g5['uniqid_table'] = G5_TABLE_PREFIX.'uniqid';
\$g5['autosave_table'] = G5_TABLE_PREFIX.'autosave';
\$g5['cert_history_table'] = G5_TABLE_PREFIX.'cert_history';
\$g5['qa_config_table'] = G5_TABLE_PREFIX.'qa_config';
\$g5['qa_content_table'] = G5_TABLE_PREFIX.'qa_content';
\$g5['content_table'] = G5_TABLE_PREFIX.'content';
\$g5['faq_table'] = G5_TABLE_PREFIX.'faq';
\$g5['faq_master_table'] = G5_TABLE_PREFIX.'faq_master';
\$g5['new_win_table'] = G5_TABLE_PREFIX.'new_win';
\$g5['menu_table'] = G5_TABLE_PREFIX.'menu';
\$g5['social_profile_table'] = G5_TABLE_PREFIX.'social_profile';
?>";

file_put_contents('data/dbconfig.php', $content);
echo "dbconfig.php updated with G5_URL.";
?>