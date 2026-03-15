<?php
if (!defined('_GNUBOARD_'))
    exit;

// Table Definition
if (!defined('G5_PLUGIN_SUB_DESIGN_GROUP_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_GROUP_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_groups');
}
if (!defined('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_items');
}

/**
 * Get Sub Design Item Data (Hierarchical Fallback)
 * @param string $sd_id Group ID (Optional, defaults to current theme_lang)
 * @param string $me_code Menu Code
 */
function get_sub_design($sd_id = null, $me_code = null)
{
    global $g5, $config;

    // Backward Compatibility: If only 1 argument passed, it's the me_code
    if ($me_code === null && $sd_id !== null) {
        $me_code = $sd_id;
        $sd_id = null;
    }

    // Default SD_ID Calculation (Theme + Lang)
    if ($sd_id === null) {
        $sd_id = $config['cf_theme'];
        $sd_lang = (defined('G5_LANG')) ? G5_LANG : 'kr';
        if ($sd_lang != 'kr') {
            $sd_id .= '_' . $sd_lang;
        }
    }
    $group = sql_fetch(" SELECT * FROM " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " WHERE sd_id = '{$sd_id}' ");
    $skin = isset($group['sd_skin']) ? $group['sd_skin'] : 'standard';
    $layout = isset($group['sd_layout']) ? $group['sd_layout'] : 'full';

    $item = _get_recursive_design($sd_id, $me_code);

    if ($item) {
        $item['sd_skin'] = $skin;
        $item['sd_layout'] = $layout;
        $item['sd_id'] = $sd_id;
    }

    return $item;
}

/**
 * Display Sub Design Skin
 */
function display_sub_design($me_code = null)
{
    global $g5, $config, $sub_design;

    $item = get_sub_design($me_code);
    if (!$item)
        return;

    $skin = $item['sd_skin'];
    $skin_path = G5_PLUGIN_PATH . '/sub_design/skins/' . $skin;
    $skin_url = G5_PLUGIN_URL . '/sub_design/skins/' . $skin;

    echo '<div class="sub-design-isolation-wrap">' . PHP_EOL;
    if (file_exists($skin_path . '/main.skin.php')) {
        include($skin_path . '/main.skin.php');
    } else {
        // Fallback to standard
        include(G5_PLUGIN_PATH . '/sub_design/skins/standard/main.skin.php');
    }
    echo '</div>' . PHP_EOL;
}

/**
 * Recursive Helper for Data Fallback
 */
function _get_recursive_design($sd_id, $me_code)
{
    $item = sql_fetch(" SELECT * FROM " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " WHERE sd_id = '{$sd_id}' AND me_code = '{$me_code}' ");

    // [Logic] Consider item "missing" if BOTH image and text are empty
    $is_empty = (!$item || (empty($item['sd_main_text']) && empty($item['sd_visual_img']) && empty($item['sd_visual_url'])));

    if ($is_empty && strlen($me_code) > 2) {
        // Find Parent Code
        if (strpos($me_code, 'TC') === 0 && strlen($me_code) == 4) {
            // Root Category (TCxx) -> Find matching Pro Menu by name
            $tc_code = substr($me_code, 2);
            $tc = sql_fetch(" SELECT tc_name FROM g5_tree_category_add WHERE tc_code = '$tc_code' ");
            if ($tc) {
                // Determine Menu Table (Same logic as head.php)
                $sd_lang = (defined('G5_LANG')) ? G5_LANG : 'kr';
                $menu_table = ($sd_lang == 'kr') ? "g5_write_menu_pdc" : "g5_write_menu_pdc_" . $sd_lang;
                $col_prefix = sql_fetch(" SHOW TABLES LIKE '$menu_table' ") ? 'ma' : 'me';
                $name_col = $col_prefix . '_name';
                $code_col = $col_prefix . '_code';

                $pm = sql_fetch(" SELECT $code_col as me_code FROM $menu_table WHERE $name_col = '{$tc['tc_name']}' LIMIT 1 ");
                if ($pm) {
                    $parent_item = _get_recursive_design($sd_id, $pm['me_code']);
                    if ($parent_item)
                        return $parent_item;
                }
            }
        } else {
            // Standard Hierarchy (4->2, 6->4, etc.)
            $parent_code = substr($me_code, 0, strlen($me_code) - 2);
            if ($parent_code && $parent_code !== 'TC') {
                $parent_item = _get_recursive_design($sd_id, $parent_code);
                if ($parent_item)
                    return $parent_item;
            }
        }
    }

    return $item;
}

/**
 * [NEW] Normalize Sub Design Image URL
 */
function get_sub_design_image_url($item)
{
    if (!$item)
        return '';

    $url = isset($item['sd_visual_url']) ? $item['sd_visual_url'] : '';
    if ($url) {
        if (preg_match("/^(http|https):/i", $url))
            return $url;
        return G5_DATA_URL . '/sub_visual/' . $url;
    }

    $img = isset($item['sd_visual_img']) ? $item['sd_visual_img'] : '';
    if ($img)
        return G5_DATA_URL . '/sub_visual/' . $img;

    return '';
}
?>