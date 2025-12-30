<?php
include_once('../../common.php');
define('G5_IS_ADMIN', true);

if (!defined('G5_ADMIN_PATH')) {
    define('G5_ADMIN_PATH', G5_PATH . '/adm');
}
if (!defined('G5_ADMIN_URL')) {
    define('G5_ADMIN_URL', G5_URL . '/adm');
}

include_once(G5_ADMIN_PATH . '/admin.lib.php');
?>