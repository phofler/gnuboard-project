<?php
$sub_menu = "100900";
define('G5_IS_ADMIN', true);
include_once(dirname(__FILE__) . '/../../../common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');
include_once(dirname(__FILE__) . '/../hook.php');

if (!defined('G5_ADMIN_PATH')) {
    define('G5_ADMIN_PATH', G5_PATH . '/adm');
    include_once(G5_ADMIN_PATH . '/admin.lib.php');
}

auth_check_menu($auth, $sub_menu, 'w');
check_token(); // CSRF Check

$config_file = G5_DATA_PATH . '/map_api_config.php';

// Prepare Array
$map_config = array(
    'provider' => (isset($_POST['provider']) && in_array($_POST['provider'], array('naver', 'google', 'kakao'))) ? $_POST['provider'] : 'naver',
    'client_id' => isset($_POST['client_id']) ? trim($_POST['client_id']) : '',
    'api_key' => isset($_POST['api_key']) ? trim($_POST['api_key']) : '',
    'lat' => isset($_POST['lat']) ? trim($_POST['lat']) : '37.5665',
    'lng' => isset($_POST['lng']) ? trim($_POST['lng']) : '126.9780'
);

// Save to file
$content = "<?php\nreturn " . var_export($map_config, true) . ";\n?>";
file_put_contents($config_file, $content);

// Redirect
goto_url('./config_form.php');
?>
