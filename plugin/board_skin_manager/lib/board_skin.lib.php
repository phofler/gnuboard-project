<?php
if (!defined('_GNUBOARD_'))
    exit;

// Plugin Common loaded? If not, load it.
if (!defined('G5_PLUGIN_BOARD_SKIN_TABLE')) {
    define('G5_PLUGIN_BOARD_SKIN_TABLE', G5_TABLE_PREFIX . 'plugin_board_skin_config');
}

/**
 * Display a Board Skin Widget by ID
 * @param int $bs_id
 */
function display_board_skin_by_id($bs_id)
{
    global $g5;

    $bs = sql_fetch(" select * from " . G5_PLUGIN_BOARD_SKIN_TABLE . " where bs_id = '{$bs_id}' and bs_active = 1 ");

    if (!$bs)
        return; // Not found or inactive

    // Call Gnuboard latest() function
    // latest(skin_dir, bo_table, rows, subject_len, options)

    // Check if skin is theme-based
    $skin_path = $bs['bs_skin'];
    // Note: Gnuboard 'latest' function handles 'theme/' prefix automatically

    // Check for new plugin-based skins (defined in extend/board_skin.lib.php)
    if (function_exists('latest_plugin_skin')) {
        echo latest_plugin_skin($bs['bs_skin'], $bs['bs_bo_table'], $bs['bs_count'], $bs['bs_subject_len'], $bs['bs_options']);
    } else {
        echo latest($bs['bs_skin'], $bs['bs_bo_table'], $bs['bs_count'], $bs['bs_subject_len'], $bs['bs_options']);
    }
}
?>