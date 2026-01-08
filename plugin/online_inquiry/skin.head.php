<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Online Inquiry Skin Shared Header
 * - Handles Background Color Logic
 * - Handles Dark Mode Text Adjustments
 * - Outputs Page Content (Editor Content)
 */

// 1. Background Color Logic
// Use $oi_bgcolor set in form.php (Dynamic Theme Aware)
$bg_color = (isset($oi_bgcolor) && $oi_bgcolor) ? $oi_bgcolor : '#121212';
?>

<!-- Dynamic Background & Text Styles -->
<style type="text/css">
    <?php if ($bg_color) { ?>
        body,
        #wrapper {
            background-color:
                <?php echo $bg_color; ?>
                !important;
        }

    <?php } ?>

    /* Dark Mode Text Adjustment */
    <?php
    $is_dark = (stripos($bg_color, '#f') === false && stripos($bg_color, '#e') === false && stripos($bg_color, '#d') === false);
    if ($is_dark) {
        ?>
        body,
        #wrapper {
            color: #f2f2f2;
        }

    <?php } ?>
</style>

<!-- Page Content / Editor Output -->
<?php if (isset($row['content']) && $row['content']) { ?>
    <div class="inquiry-content-top" style="margin-bottom: 40px; text-align:center;">
        <?php echo $row['content']; // Output raw content from DB directly ?>
    </div>
<?php } ?>