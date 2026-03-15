<?php
// Remove exit check to allow direct access if needed, but safe guard include
// if (!defined('_GNUBOARD_')) exit;

if (!defined('_GNUBOARD_')) {
    include_once(dirname(__FILE__) . '/../../common.php');
}

if (!defined('G5_PLUGIN_LATEST_SKIN_URL')) {
    define('G5_PLUGIN_LATEST_SKIN_URL', G5_PLUGIN_URL . '/latest_skin_manager');
    define('G5_PLUGIN_LATEST_SKIN_PATH', G5_PLUGIN_PATH . '/latest_skin_manager');
}

if (!defined('G5_PLUGIN_LATEST_SKIN_TABLE')) {
    define('G5_PLUGIN_LATEST_SKIN_TABLE', G5_TABLE_PREFIX . 'plugin_latest_skin_config');
}
?>