<?php
include_once('../../../common.php');

$plugin_name = "latest_skin_manager";
if (!defined('G5_PLUGIN_LATEST_SKIN_TABLE')) {
    define('G5_PLUGIN_LATEST_SKIN_TABLE', G5_TABLE_PREFIX . 'plugin_latest_skin_config');
}
?>