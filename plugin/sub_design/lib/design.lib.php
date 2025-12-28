<?php
if (!defined('_GNUBOARD_'))
    exit;

// Function to get sub design data
function get_sub_design($me_code)
{
    global $g5;

    if (!defined('G5_PLUGIN_SUB_DESIGN_TABLE')) {
        define('G5_PLUGIN_SUB_DESIGN_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design');
    }

    // Try to get exact match
    $row = sql_fetch(" SELECT * FROM " . G5_PLUGIN_SUB_DESIGN_TABLE . " WHERE me_code = '{$me_code}' ");

    // Fallback logic for Sub Menu (Length 4)
    if (strlen($me_code) == 4) {
        $parent_code = substr($me_code, 0, 2);

        // If image is missing, fetch from parent
        if (empty($row['sd_visual_img'])) {
            $parent_row = sql_fetch(" SELECT sd_visual_img FROM " . G5_PLUGIN_SUB_DESIGN_TABLE . " WHERE me_code = '{$parent_code}' ");
            if ($parent_row['sd_visual_img']) {
                $row['sd_visual_img'] = $parent_row['sd_visual_img'];
            }
        }

        // You can add fallback for text too if needed, but user only asked for image.
    }

    return $row;
}
?>