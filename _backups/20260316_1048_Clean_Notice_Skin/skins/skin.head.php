<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Board Skin Manager - Shared Skin Header
 * Handles theme-aware styling and Section 14 Typography Protocol.
 */

// Define standardized variables (similar to Main Content Manager)
$mc_accent = 'var(--color-brand, var(--color-accent-gold, #d4af37))';
$mc_font_heading = 'var(--font-heading)';
$mc_text_primary = 'var(--color-text-primary, inherit)';
$mc_text_secondary = 'var(--color-text-secondary, inherit)';
$mc_bg_dark = 'var(--color-bg-dark, transparent)';

?>
<style>
    /* [SECTION 14] Typography Standardization */
    .section-title {
        color:
            <?php echo $mc_text_primary; ?>
            !important;
        font-family:
            <?php echo $mc_font_heading; ?>
            !important;
        font-size: var(--mc-title-size, 3rem) !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: 2px !important;
        text-align: center;
        margin-bottom: 20px;
    }

    .section-subtitle {
        color:
            <?php echo $mc_text_secondary; ?>
            !important;
        font-size: 1.1rem !important;
        max-width: 800px;
        margin: 0 auto 60px;
        line-height: 1.6;
        text-align: center;
        opacity: 0.8;
    }
</style>