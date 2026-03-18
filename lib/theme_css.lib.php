<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Extracts a specific CSS variable value from a theme's style.css or default.css
 * @param string $theme_id The theme directory name
 * @param array $variables Priority list of CSS variables to look for (e.g. ['--color-bg', '--color-bg-dark'])
 * @param string $default Fallback color if not found
 * @return string Extracted color or fallback
 */
function get_theme_css_value($theme_id, $variables = array('--color-bg', '--color-bg-dark'), $default = '#ffffff')
{
    if (!$theme_id)
        return $default;

    $search_paths = array(
        G5_PATH . "/theme/{$theme_id}/css/default.css",
        G5_PATH . "/theme/{$theme_id}/style.css"
    );

    $css_content = "";
    foreach ($search_paths as $path) {
        if (file_exists($path)) {
            $css_content .= file_get_contents($path);
        }
    }

    if (!$css_content)
        return $default;

    foreach ($variables as $var) {
        $var_pattern = preg_quote($var, '/');
        // Match hex colors: #fff, #ffffff, #FFFFFF
        if (preg_match('/' . $var_pattern . '\s*:\s*(#[a-fA-F0-9]{3,6})/i', $css_content, $m)) {
            return trim($m[1]);
        }
        // Match basic color names: white, black, transparent
        if (preg_match('/' . $var_pattern . '\s*:\s*(white|black|transparent)/i', $css_content, $m)) {
            return trim($m[1]);
        }
    }

    return $default;
}
?>