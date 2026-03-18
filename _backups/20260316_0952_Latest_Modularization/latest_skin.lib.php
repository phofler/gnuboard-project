<?php
if (!defined('_GNUBOARD_'))
    exit;

// Plugin Common loaded? If not, load it.
if (!defined('G5_PLUGIN_LATEST_SKIN_TABLE')) {
    define('G5_PLUGIN_LATEST_SKIN_TABLE', G5_TABLE_PREFIX . 'plugin_latest_skin_config');
}

/**
 * Get Latest Skin Configuration Data
 * @param string $ls_id
 * @return array|string Returns config array or empty string if not found
 */
function get_latest_skin_config(string $ls_id)
{
    global $g5;

    $ls = sql_fetch(" select * from " . G5_PLUGIN_LATEST_SKIN_TABLE . " where ls_id = '{$ls_id}' and ls_active = 1 ");

    // [Standardization Fallback]
    if (!$ls) {
        if (strpos($ls_id, '_') === false) {
            $ls = sql_fetch(" select * from " . G5_PLUGIN_LATEST_SKIN_TABLE . " where ls_id = '{$ls_id}_ko' and ls_active = 1 ");
            if (!$ls) {
                $ls = sql_fetch(" select * from " . G5_PLUGIN_LATEST_SKIN_TABLE . " where ls_id = '{$ls_id}_kr' and ls_active = 1 ");
            }
        }
    }

    if (!$ls)
        return "";

    $html = "";
    if (strpos($ls['ls_skin'], 'plugin/') === 0) {
        if (function_exists('latest_plugin_skin')) {
            // Assuming latest_plugin_skin mimics latest() signature: skin, bo_table, rows, subject_len, cache_time, options
            $html = latest_plugin_skin($ls['ls_skin'], $ls['ls_bo_table'], $ls['ls_count'], $ls['ls_subject_len'], 1, $ls);
        } else {
            $html = "<!-- Plugin function latest_plugin_skin not found -->";
        }
    } else {
        // Correct signature: latest($skin, $bo_table, $rows, $subject_len, $cache_time, $options)
        $html = latest($ls['ls_skin'], $ls['ls_bo_table'], $ls['ls_count'], $ls['ls_subject_len'], 1, $ls);
    }

    return array(
        'html' => $html,
        'title' => $ls['ls_title'],
        'description' => $ls['ls_description'],
        'more_link' => $ls['ls_more_link'],
        'id' => $ls['ls_id']
    );
}

/**
 * Display a Latest Skin Widget by ID (Returns HTML String)
 * @param string $ls_id
 * @return string
 */
function display_latest_skin_by_id(string $ls_id)
{
    $data = get_latest_skin_config($ls_id);
    return is_array($data) ? $data['html'] : $data;
}

/**
 * Backward Compatibility Wrapper
 * @deprecated Use display_latest_skin_by_id
 */
function display_board_skin_by_id($ls_id)
{
    return display_latest_skin_by_id($ls_id);
}

/**
 * Public Widget Function (Admin UI Compatible)
 * @param string $ls_id
 */
function latest_widget($ls_id)
{
    echo display_latest_skin_by_id($ls_id);
}
?>