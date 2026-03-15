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

// 紐⑸줉 ?섏씠吏濡??뚯븘媛?? 諛⑷툑 ?쒖꽦?뷀븳 ?ㅽ??쇱쓣 ?몄쭛 紐⑤뱶濡?蹂댁뿬以?
goto_url('./list.php?style=' . $active_style);
?>
