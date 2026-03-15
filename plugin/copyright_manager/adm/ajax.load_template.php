<?php
include_once('./_common.php');

$skin = isset($_REQUEST['skin']) ? clean_xss_tags($_REQUEST['skin']) : 'style_a';
$template_file = G5_PLUGIN_PATH . '/copyright_manager/skins/' . $skin . '/template.html';

if (file_exists($template_file)) {
    $template = file_get_contents($template_file);
    echo json_encode(array('template' => $template));
} else {
    echo json_encode(array('error' => 'Template not found: ' . $skin));
}
?>