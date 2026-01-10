<?php
$sub_menu = "950180";
include_once('./_common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

check_demo();
auth_check_menu($auth, $sub_menu, 'w');

$active_style = isset($_POST['active_style']) ? $_POST['active_style'] : 'A';
$section_title = isset($_POST['section_title']) ? $_POST['section_title'] : 'PRODUCT COLLECTION';

$config_file = G5_PLUGIN_PATH . '/main_content_manager/active_style.php';

$content = "<?php\n";
$content .= "\$active_style = '" . sql_real_escape_string($active_style) . "';\n";
$content .= "\$section_title = '" . sql_real_escape_string($section_title) . "';\n";
$content .= "?>";

file_put_contents($config_file, $content);

goto_url('./list.php?style=' . $active_style);
?>