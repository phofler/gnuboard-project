<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Main Content Manager - Shared Skin Header
 * This file standardizes the $items data across all skins.
 */

// Section level variables
$section_title = isset($ms['ms_title']) ? $ms['ms_title'] : '';
$section_desc = isset($ms['ms_desc']) ? $ms['ms_desc'] : '';
$show_title = isset($ms['ms_show_title']) ? $ms['ms_show_title'] : '0';

// [THEME SOVEREIGNTY] Fallback logic for background
// If the theme defines --color-bg, use it; otherwise use --color-bg-dark to inherit the dark aesthetic.
$ms_bg_mode = isset($ms['ms_bg_mode']) ? $ms['ms_bg_mode'] : 'default';
switch ($ms_bg_mode) {
    case 'white':
        $mc_bg_var = 'var(--color-bg-invert, #ffffff)';
        $mc_text_primary = 'var(--color-text-invert, #121212)';
        $mc_text_secondary = 'var(--color-text-secondary-invert, #666666)';
        break;
    case 'accent':
        $mc_bg_var = 'var(--color-brand, var(--color-accent-gold, #d4af37))';
        $mc_text_primary = 'var(--color-text-on-accent, #000000)';
        $mc_text_secondary = 'var(--color-text-on-accent-sub, #333333)';
        break;
    case 'deep':
        $mc_bg_var = 'var(--color-bg-dark, #121212)';
        $mc_text_primary = 'var(--color-text-primary, #e0e0e0)';
        $mc_text_secondary = 'var(--color-text-secondary, #a0a0a0)';
        break;
    case 'default':
    default:
        $mc_bg_var = 'var(--color-bg, #ffffff)';
        $mc_text_primary = 'var(--color-text-primary, #121212)';
        $mc_text_secondary = 'var(--color-text-secondary, #666666)';
        break;
}

if (isset($items) && is_array($items)) {
    foreach ($items as $key => $item) {
        // 1. Link & Target Cleaning
        $items[$key]['mc_link'] = isset($item['mc_link']) ? trim($item['mc_link']) : '';
        $items[$key]['mc_target'] = (isset($item['mc_target']) && $item['mc_target']) ? $item['mc_target'] : '_self';

        // 2. Standardized Button Text
        if (!isset($item['btn_text']) || !$item['btn_text']) {
            $items[$key]['btn_text'] = 'Read More';
        }

        // 3. Title & Description Decoding
        $items[$key]['title'] = isset($item['mc_title']) ? nl2br(stripslashes($item['mc_title'])) : '';
        $items[$key]['desc'] = isset($item['mc_desc']) ? nl2br(stripslashes($item['mc_desc'])) : '';
        $items[$key]['img_url'] = isset($item['img_url']) ? $item['img_url'] : '';
    }
}
?>