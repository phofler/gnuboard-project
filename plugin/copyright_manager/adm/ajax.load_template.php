<?php
include_once('./_common.php');

$skin = isset($_GET['skin']) ? clean_xss_tags($_GET['skin']) : 'style_a';
$template_file = G5_PLUGIN_PATH . '/copyright_manager/skins/' . $skin . '/template.html';

if (file_exists($template_file)) {
    echo file_get_contents($template_file);
} else {
    echo "Template not found: " . $skin;
}
?>