<?php
include_once('./_common.php');
echo "G5_PLUGIN_PATH: " . G5_PLUGIN_PATH . "\n";
$file = G5_PLUGIN_PATH . '/main_content_manager/lib/main_content.lib.php';
echo "File Exists: " . (file_exists($file) ? 'YES' : 'NO') . "\n";
include_once($file);
echo "Function Exists: " . (function_exists('display_main_content') ? 'YES' : 'NO') . "\n";
?>
