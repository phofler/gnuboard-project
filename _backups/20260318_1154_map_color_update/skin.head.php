<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Shared Header for Map API Skin/Display
 * Handles theme-aware styling variables and standardizations.
 */

// 1. Path & URL Setup
$map_api_path = G5_PLUGIN_PATH . '/map_api';
$map_api_url = G5_PLUGIN_URL . '/map_api';

// 2. Theme Sync - Extract basic colors
// Use current theme from $config or fallback
$current_theme = isset($config['cf_theme']) ? $config['cf_theme'] : 'corporate';

// Default Fallbacks (Standardized per Section 26-E)
$map_bg = '#f5f5f5';
$map_text = '#333333';
$map_accent = '#d4af37';

if (function_exists('get_theme_css_value')) {
    // Background: Priority to --color-bg then --color-bg-dark
    $map_bg = get_theme_css_value($current_theme, array('--color-bg', '--color-bg-dark'), '#f5f5f5');
    // Text: Priority to --color-text-primary
    $map_text = get_theme_css_value($current_theme, array('--color-text-primary'), '#333333');
    // Accent: Priority to --color-accent-gold
    $map_accent = get_theme_css_value($current_theme, array('--color-accent-gold'), '#d4af37');
}

// 3. InfoWindow Styles (Namespaced Classes)
// Injecting standard CSS for the map container and info windows
add_stylesheet('<style>
    .map-api-wrapper { background-color: ' . $map_bg . '; position: relative; overflow: hidden; }
    .map-api-container { width: 100%; height: 100%; }
    .map-api-info-window { 
        padding: 10px 15px; 
        min-width: 150px; 
        text-align: center; 
        background: ' . $map_bg . '; 
        color: ' . $map_text . ';
        font-family: var(--font-body, "sans-serif");
    }
    .map-api-info-window strong { 
        display: block;
        font-size: 15px; 
        font-weight: 700; 
        margin-bottom: 2px;
        color: var(--color-accent-gold, ' . $map_accent . ');
    }
</style>', 0);
?>