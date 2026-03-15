<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Extracts a specific CSS variable value from a theme's default.css
 * @param string $theme_id The theme directory name
 * @param array $variables Priority list of CSS variables to look for (e.g. ['--color-bg', '--color-bg-dark'])
 * @param string $default Fallback color if not found
 * @return string Extracted color or fallback
 */
function get_theme_css_value($theme_id, $variables = array('--color-bg', '--color-bg-dark'), $default = '#121212')
{
    if (!$theme_id)
        return $default;

    $css_file = G5_PATH . "/theme/{$theme_id}/css/default.css";
    if (!file_exists($css_file))
        return $default;

    // Use a small buffer if file is large? Most default.css are OK to read fully.
    $css_content = file_get_contents($css_file);

    foreach ($variables as $var) {
        $var_pattern = preg_quote($var, '/');
        // Match hex colors or basic color names
        if (preg_match('/' . $var_pattern . '\s*:\s*(#[a-fA-F0-9]{3,6}|[a-z]+)/i', $css_content, $m)) {
            $val = trim($m[1]);
            // If it's a hex color, return it. If it's another variable reference, we might need more logic, 
            // but for now base values are what we expect.
            if (strpos($val, '#') === 0 || in_array(strtolower($val), array('white', 'black', 'transparent'))) {
                return $val;
            }
        }
    }

    return $default;
}
?>