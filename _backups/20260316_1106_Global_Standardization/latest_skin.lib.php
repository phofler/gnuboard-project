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
if (!function_exists('get_latest_skin_config')) {
    function get_latest_skin_config(string $ls_id)
    {
        global $g5, $config;

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

        // 명시적인 테마명으로 재시도 (fallback)
        if (!$ls && isset($config["cf_theme"])) {
            $fallback_id = trim($config["cf_theme"]);
            $ls = sql_fetch(" SELECT * FROM " . G5_PLUGIN_LATEST_SKIN_TABLE . " WHERE ls_id = '{$fallback_id}' and ls_active = 1 ");
        }

        if (!$ls)
            return "";

        $html = "";
        $skin_dir = $ls['ls_skin'];
        
        $is_plugin_skin = (strpos($skin_dir, 'plugin/') === 0);
        if (!$is_plugin_skin && is_dir(G5_PLUGIN_PATH . '/latest_skin_manager/skins/' . $skin_dir)) {
            $is_plugin_skin = true;
        }

        if ($is_plugin_skin) {
            $html = latest_plugin_skin($skin_dir, $ls['ls_bo_table'], $ls['ls_count'], $ls['ls_subject_len'], 1, $ls);
        } else {
            $html = latest($skin_dir, $ls['ls_bo_table'], $ls['ls_count'], $ls['ls_subject_len'], 1, $ls);
        }

        return array(
            'html' => $html,
            'title' => $ls['ls_title'],
            'description' => $ls['ls_description'],
            'more_link' => $ls['ls_more_link'],
            'id' => $ls['ls_id']
        );
    }
}

/**
 * Plugin 전용 최신글 추출 함수
 */
if (!function_exists('latest_plugin_skin')) {
    function latest_plugin_skin($skin_dir, $bo_table, $rows=10, $subject_len=40, $cache_time=1, $options='')
    {
        global $g5, $config;

        // 변수 초기화 및 추출
        $more_link = "";
        $ls_title = "";
        if (is_array($options)) {
            extract($options);
            // ls_ 접두어가 붙은 변수들을 일반 변수로 매핑
            if (isset($ls_more_link)) $more_link = $ls_more_link;
        }

        $skin_dir = str_replace('plugin/', '', $skin_dir);
        $latest_skin_path = G5_PLUGIN_PATH . '/latest_skin_manager/skins/' . $skin_dir;
        $latest_skin_url = G5_PLUGIN_URL . '/latest_skin_manager/skins/' . $skin_dir;

        if (!is_dir($latest_skin_path)) {
            return "<!-- Latest Skin not found: {$latest_skin_path} -->";
        }

        if (file_exists(G5_LIB_PATH.'/latest.lib.php')) {
            include_once(G5_LIB_PATH.'/latest.lib.php');
        }

        $list = array();
        $board = get_board_db($bo_table, true);
        if (!$board) return '';

        // 타이틀 결정 (커스텀 타이틀 우선)
        $bo_subject = ($ls_title) ? $ls_title : get_text($board['bo_subject']);
        
        $tmp_write_table = $g5['write_prefix'] . $bo_table;
        $sql = " select * from {$tmp_write_table} where wr_is_comment = 0 order by wr_num limit 0, {$rows} ";
        $result = sql_query($sql);
        
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
            $list[$i]['bo_table'] = $bo_table;
            
            // 썸네일 처리 (문자열 옵션인 경우: "400,300")
            if ($options && is_string($options) && strpos($options, ',') !== false) {
                $opt = explode(',', $options);
                $thumb = get_list_thumbnail($bo_table, $row['wr_id'], $opt[0], $opt[1], false, true);
                if ($thumb['src']) {
                    $list[$i]['img_thumbnail'] = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'">';
                }
            }
        }

        ob_start();
        include $latest_skin_path.'/latest.skin.php';
        $content = ob_get_clean();

        return $content;
    }
}

/**
 * Display a Latest Skin Widget by ID (Returns HTML String)
 */
if (!function_exists('display_latest_skin_by_id')) {
    function display_latest_skin_by_id(string $ls_id)
    {
        $data = get_latest_skin_config($ls_id);
        return is_array($data) ? $data['html'] : $data;
    }
}

/**
 * Public Widget Function (Admin UI Compatible)
 */
if (!function_exists('latest_widget')) {
    function latest_widget($ls_id)
    {
        echo display_latest_skin_by_id($ls_id);
    }
}
?>