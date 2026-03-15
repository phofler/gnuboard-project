<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * 플러그인 자동 로더 (extend/load_plugins.php)
 * - plugin/ 폴더 내의 지정된 플러그인들을 자동으로 로드합니다.
 * - 각 플러그인 폴더의 hook.php를 include 합니다.
 */

// 활성화할 플러그인 목록 (추후 관리자 페이지에서 제어 가능하도록 확장 가능)
$active_plugins = array(
    'online_inquiry',
    'map_api',
    'company_intro',
    'latest_skin_manager',
    'board_skin_manager'
);

foreach ($active_plugins as $plugin_name) {
    $plugin_hook_file = G5_PLUGIN_PATH . '/' . $plugin_name . '/hook.php';
    $plugin_menu_file = G5_PLUGIN_PATH . '/' . $plugin_name . '/admin.menu.php';

    // 1. 훅 파일 로드 (설치 및 기능)
    if (file_exists($plugin_hook_file)) {
        include_once($plugin_hook_file);
    }

    // 2. 관리자 메뉴 파일 로드 (관리자 페이지일 때만)
    if (defined('G5_IS_ADMIN') && file_exists($plugin_menu_file)) {
        include_once($plugin_menu_file);
    }
}
?>