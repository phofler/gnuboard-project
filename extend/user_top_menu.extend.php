<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * 상단 메뉴 매니저 전역 연동 라이브러리
 */

$logo_url = G5_THEME_URL . '/m_logo.png';
$tm_skin = "basic";

if (defined('G5_PLUGIN_PATH')) {
    $top_menu_lib = G5_PLUGIN_PATH . '/top_menu_manager/lib.php';
    if (file_exists($top_menu_lib)) {
        include_once($top_menu_lib);
        
        // 테마 이름을 기반으로 설정 로드 (기본값: kukdong_panel)
        global $config;
        $tm_id = isset($config['cf_theme']) ? trim($config['cf_theme']) : 'kukdong_panel';
        
        $tm = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '$tm_id' ");
        
        if ($tm) {
            if ($tm['tm_logo_pc']) $logo_url = G5_DATA_URL . '/common/' . $tm['tm_logo_pc'];
            $tm_skin = $tm['tm_skin'] ? $tm['tm_skin'] : 'basic';

            if ($tm['tm_menu_table'] && !defined('G5_PRO_MENU_TABLE')) {
                define('G5_PRO_MENU_TABLE', 'g5_write_menu_pdc_' . $tm['tm_menu_table']);
            }
        }
    }
    
    $pro_menu_lib = G5_PLUGIN_PATH . '/pro_menu_manager/lib.php';
    if (file_exists($pro_menu_lib)) {
        include_once($pro_menu_lib);
    }
}

// 전역 변수 등록
$GLOBALS['tm_skin'] = $tm_skin;
$GLOBALS['logo_url'] = $logo_url;
?>