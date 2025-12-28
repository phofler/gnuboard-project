<?php
include_once('./_common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

check_demo();
auth_check_menu($auth, $sub_menu, 'w');

$active_style = $_POST['active_style'];

$config_file = G5_PLUGIN_PATH . '/main_image_manager/active_style.php';
$content = "<?php\n\$active_style = '{$active_style}';\n?>";

$fp = fopen($config_file, 'w');
fwrite($fp, $content);
fclose($fp);

// 목록 페이지로 돌아가되, 방금 활성화한 스타일을 편집 모드로 보여줌
goto_url('./list.php?style=' . $active_style);
?>