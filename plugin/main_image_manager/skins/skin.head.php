<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Main Image Manager - Shared Skin Header
 * This file standardizes the $slides data across all skins.
 */

foreach ($slides as &$slide) {
    // 1. Link & Target Cleaning
    $slide['mi_link'] = isset($slide['mi_link']) ? trim($slide['mi_link']) : '';
    $slide['mi_target'] = (isset($slide['mi_target']) && $slide['mi_target']) ? $slide['mi_target'] : '_self';

    // 2. Standardized Button Text
    // Priority: mi_id_custom (if used as label) or default based on language
    // Since we don't have a dedicated button field yet, we use a standard one.
    // Example: $is_en = (strpos($actual_id, '_en') !== false);
    if (!isset($slide['btn_text']) || !$slide['btn_text']) {
        $slide['btn_text'] = 'Discover More';
    }

    // 3. Title & Description Decoding
    $slide['title'] = isset($slide['mi_title']) ? nl2br(stripslashes($slide['mi_title'])) : '';
    $slide['desc'] = isset($slide['mi_desc']) ? nl2br(stripslashes($slide['mi_desc'])) : '';
}
unset($slide);
?>