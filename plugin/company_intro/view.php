<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Company Intro View File
 * 
 * $co_row 변수에 이미 데이터가 담겨져 있다고 가정 (route.php에서 조회함)
 * 만약 직접 접근했다면 다시 조회해야 함.
 */

if (!isset($co_row) || empty($co_row)) {
    alert('잘못된 접근입니다.');
}

// 테마에서 사용하는 상수 정의 확인
if (!defined('G5_JS_VER')) {
    define('G5_JS_VER', G5_VERSION);
}
if (!defined('G5_CSS_VER')) {
    define('G5_CSS_VER', G5_JS_VER);
}

// -----------------------------------------------------
// [NEW] Sub Design Data Integration
// -----------------------------------------------------
$sd_row = array();
$design_lib_path = G5_PLUGIN_PATH . '/sub_design/lib/design.lib.php';

// Ensure me_code is set
if (!isset($g5['me_code']) && isset($_GET['me_code'])) {
    $g5['me_code'] = $_GET['me_code'];
}

if (file_exists($design_lib_path)) {
    include_once($design_lib_path);
    if (function_exists('get_sub_design') && isset($g5['me_code'])) {
        $sd_row = get_sub_design($g5['me_code']);
    }
}

$g5['title'] = $co_row['co_subject'];

// 헤더 포함
include_once(G5_PATH . '/_head.php');





// 스킨 경로 설정
// 스킨 파일: type_a.html, type_b.html ...
// html 파일이므로 내용을 읽어서 변수 치환 후 출력

$skin_name = $co_row['co_skin'];
if (!$skin_name)
    $skin_name = 'type_a';

$skin_file = G5_PLUGIN_PATH . '/company_intro/skin/' . $skin_name . '.html';

if (file_exists($skin_file)) {
    // $view_content 처리
    // 여기서는 단순 치환보다는, 스킨 구조에 맞춰 데이터를 넣습니다.
    // 기존 스킨 html은 정적인 텍스트가 박혀있었습니다.
    // 이를 사용자가 입력한 내용($co_row['co_content'])으로 통째로 교체합니다.

    $view_content = $co_row['co_content'];

} else {
    $view_content = '스킨 파일이 존재하지 않습니다.';
}

// [FIX] Cleaned up view logic to support premium skins
// -----------------------------------------------------

// [COPYRIGHT MANAGER INTEGRATION]
// Replace placeholders with actual data from Copyright Manager
if (strpos($co_row['co_content'], '{CP_') !== false) {
    // Load Config
    if (!function_exists('get_copyright_config')) {
        $cp_lib = G5_PLUGIN_PATH . '/copyright_manager/lib.php';
        if (file_exists($cp_lib)) {
            include_once($cp_lib);
        }
    }

    if (function_exists('get_copyright_config')) {
        $cp_config = get_copyright_config();

        // Define replacements
        $replacements = array(
            '{CP_ADDRESS}' => $cp_config['addr_val'],
            '{CP_TEL}' => $cp_config['tel_val'],
            '{CP_FAX}' => $cp_config['fax_val'],
            '{CP_EMAIL}' => $cp_config['email_val']
        );

        $co_row['co_content'] = strtr($co_row['co_content'], $replacements);
    }
}

// [MAP API INTEGRATION]
// If the content contains the map placeholder, load the Map API library and inject the map.
if (strpos($co_row['co_content'], '{MAP_API_DISPLAY}') !== false) {
    if (!defined('G5_PLUGIN_MAP_LIB')) {
        // Prevent double inclusion logic if configured elsewhere, though here we check file existence
        // Use theme-aware path if needed, but plugin path is safe
    }
    $map_lib = G5_PLUGIN_PATH . '/map_api/lib/map.lib.php';
    if (file_exists($map_lib)) {
        include_once($map_lib);
        if (function_exists('display_map_api')) {
            // Map container has height (e.g., 500px), so map itself should fill it (100%)
            $map_html = display_map_api('100%', '100%');
            $co_row['co_content'] = str_replace('{MAP_API_DISPLAY}', $map_html, $co_row['co_content']);
        }
    }
}

if (file_exists($skin_file)) {
    // $view_content is needed for the skin
    // The content in DB ($co_row['co_content']) already includes the skin structure (HTML + CSS)
    // because the editor initializes with the skin template.
    // So we just output the content directly.
    // [FIX] Apply Background Color from Admin Setting -> Standardized to Theme Variable
    // $bg_color = isset($co_row['co_bgcolor']) && $co_row['co_bgcolor'] ? $co_row['co_bgcolor'] : 'transparent';
    $bg_color = 'var(--color-bg-dark, #000)'; // Force Theme Color

    echo '<div style="background-color:' . $bg_color . ';">';
    echo '<div class="sub-layout-width-height">';
    // echo get_view_thumbnail($co_row['co_content']); 
    // [FIX] Output modified content (with Map injected)
    echo get_view_thumbnail($co_row['co_content']);
    echo '</div>';
    echo '</div>';
} else {
    echo '<div id="sub_container" class="sub-wrapper">';
    echo '스킨 파일이 존재하지 않습니다.';
    echo '</div>';
}
?>


<?php
// 테일 포함
include_once(G5_PATH . '/_tail.php');
?>