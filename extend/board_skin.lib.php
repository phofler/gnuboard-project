<?php
if (!defined('_GNUBOARD_'))
    exit;

// Constant for Plugin Skin Path
if (!defined('G5_PLUGIN_BOARD_SKIN_PATH')) {
    define('G5_PLUGIN_BOARD_SKIN_PATH', G5_PLUGIN_PATH . '/board_skin_manager/skins');
    define('G5_PLUGIN_BOARD_SKIN_URL', G5_PLUGIN_URL . '/board_skin_manager/skins');
}

/**
 * [Plugin] Board Skin Manager Latest Function
 * mimic latest() but for plugin-hosted skins
 */
function latest_plugin_skin($skin_dir, $bo_table, $rows = 10, $subject_len = 40, $options = '')
{
    global $g5;

    if (!$skin_dir)
        $skin_dir = 'basic';

    if (preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        // Fallback or explicit theme request (though intent is decoupling)
        return latest($skin_dir, $bo_table, $rows, $subject_len, $options);
    }

    // Strip 'plugin/' prefix if present
    if (strpos($skin_dir, 'plugin/') === 0) {
        $skin_dir = substr($skin_dir, 7);
    }

    $latest_skin_path = G5_PLUGIN_BOARD_SKIN_PATH . '/' . $skin_dir;
    $latest_skin_url = G5_PLUGIN_BOARD_SKIN_URL . '/' . $skin_dir;

    // Cache handling matches Gnuboard core pattern
    $cache_fwrite = false;
    if (G5_USE_CACHE) {
        $cache_file = G5_DATA_PATH . '/cache/latest-' . $bo_table . '-' . $skin_dir . '-' . $rows . '-' . $subject_len . '.php';
        $cache_time = 1; // 1 hour by default, simplify for now or use core config
        if (!file_exists($cache_file)) {
            $cache_fwrite = true;
        } else {
            if ($cache_time > 0) {
                $filetime = filemtime($cache_file);
                if ($filetime && $filetime < (G5_SERVER_TIME - 3600 * $cache_time)) {
                    $cache_fwrite = true;
                }
            }

            if (!$cache_fwrite)
                include($cache_file);
        }
    }

    if (!G5_USE_CACHE || $cache_fwrite) {
        $list = array();

        $sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
        $board = sql_fetch($sql);
        $bo_subject = get_text($board['bo_subject']);

        if (true) {
            // Basic list query
            $tmp_write_table = $g5['write_prefix'] . $bo_table;
            $sql = " select * from {$tmp_write_table} where wr_is_comment = 0 order by wr_num limit 0, {$rows} ";
            $result = sql_query($sql);
            while ($row = sql_fetch_array($result)) {
                $list[] = get_list($row, $board, $latest_skin_url, $subject_len);
            }
        }

        // Output Buffer to capture skin content
        ob_start();
        include $latest_skin_path . '/latest.skin.php';
        $content = ob_get_contents();
        ob_end_clean();

        if ($cache_fwrite) {
            $handle = fopen($cache_file, 'w');
            $cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject=\"" . addslashes($board['bo_subject']) . "\";\n\$list=" . var_export($list, true) . ";\n?>\n" . $content;
            fwrite($handle, $cache_content);
            fclose($handle);
        }

        return $content;
    }
}
?>