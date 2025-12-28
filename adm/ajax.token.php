<?php
require_once './_common.php';

set_session('ss_admin_token', '');

$admin_csrf_token_key = isset($_POST['admin_csrf_token_key']) ? $_POST['admin_csrf_token_key'] : '';

if (function_exists('admin_csrf_token_key') && $admin_csrf_token_key !== admin_csrf_token_key(1)) {
    $debug_msg = 'KeyMismatch: Post[' . $admin_csrf_token_key . '] vs Server[' . admin_csrf_token_key(1) . ']';
    die(json_encode(array('error' => $debug_msg, 'url' => G5_URL)));
}

$error = admin_referer_check(true);
if ($error) {
    die(json_encode(array('error' => $error, 'url' => G5_URL)));
}

$token = get_admin_token();

die(json_encode(array('error' => '', 'token' => $token, 'url' => '')));
