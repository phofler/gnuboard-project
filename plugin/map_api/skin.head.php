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
$map_bg = '#508f86';
$map_text = '#fbfbfb';
$map_accent = '#d4af37';

if (function_exists('get_theme_css_value')) {
    // Background: Priority to --color-bg then --color-bg-dark
    $map_bg = get_theme_css_value($current_theme, array('--color-bg', '--color-bg-dark'), '#508f86');
    // Text: Priority to --color-text-primary
    $map_text = get_theme_css_value($current_theme, array('--color-text-primary'), '#fbfbfb');
    // Accent: Priority to --color-accent-gold
    $map_accent = get_theme_css_value($current_theme, array('--color-accent-gold'), '#d4af37');
}

// 3. InfoWindow Styles (Namespaced Classes)
// Injecting standard CSS for the map container and info windows
add_stylesheet('<style>
    .map-api-wrapper { background-color: ' . $map_bg . '; position: relative; overflow: hidden; }
    .map-api-container { width: 100%; height: 100%; }
    .map-api-info-window { 
        padding: 12px 20px; 
        min-width: 150px; 
        text-align: center; 
        background: ' . $map_bg . ' !important; 
        color: ' . $map_text . ' !important;
        font-family: var(--font-body, "sans-serif");
        border-radius: 6px !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
        border: none !important;
        position: relative;
    }
    /* InfoWindow Arrow Sync with Background */
    .map-api-info-window::after {
        content: "";
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        border-width: 8px 8px 0;
        border-style: solid;
        border-color: ' . $map_bg . ' transparent transparent;
    }
    .map-api-info-window strong { 
        display: block;
        font-size: 15px; 
        font-weight: 800; 
        color: #fff !important;
        letter-spacing: -0.5px;
        margin-bottom: 0;
    }
</style>', 0);
?>