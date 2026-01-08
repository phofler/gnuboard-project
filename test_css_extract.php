<?php
function get_theme_bg_color($theme_id)
{
    if (!$theme_id)
        return '#121212'; // Global Fallback

    $css_file = "f:/그누보드/theme/{$theme_id}/css/default.css";
    if (!file_exists($css_file))
        return '#121212';

    $css_content = file_get_contents($css_file);

    // 1. Try --color-bg (Usually for light themes)
    if (preg_match('/--color-bg\s*:\s*(#[a-fA-F0-9]{3,6}|[a-z]+)/i', $css_content, $m)) {
        return $m[1];
    }

    // 2. Try --color-bg-dark (Usually for dark themes)
    if (preg_match('/--color-bg-dark\s*:\s*(#[a-fA-F0-9]{3,6}|[a-z]+)/i', $css_content, $m)) {
        return $m[1];
    }

    return '#121212';
}

echo "Corporate: " . get_theme_bg_color('corporate') . "\n";
echo "Corporate Light: " . get_theme_bg_color('corporate_light') . "\n";
?>