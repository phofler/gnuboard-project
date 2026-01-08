<?php
include_once('./_common.php');
include_once(G5_PATH . '/lib/theme_css.lib.php');

$theme = isset($_GET['theme']) ? preg_replace('/[^a-z0-9_]/i', '', $_GET['theme']) : '';

if (!$theme) {
    echo json_encode(array('success' => false, 'message' => 'No theme specified'));
    exit;
}

$bg = get_theme_css_value($theme, array('--color-bg', '--color-bg-dark'), '#121212');
$text = get_theme_css_value($theme, array('--color-text-primary'), '#e0e0e0');

echo json_encode(array(
    'success' => true,
    'theme' => $theme,
    'bg' => $bg,
    'text' => $text
));
?>