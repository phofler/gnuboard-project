<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Company Intro Shared Header
 * - Sub Design Data Loading
 * - Copyright Manager Integration
 * - Map API Integration
 * - Background Color Setup
 */

include_once(G5_PATH . '/lib/theme_css.lib.php');

// 1. Sub Design Integration
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

// 2. Skin Name Validation
$skin_name = isset($co_row['co_skin']) ? $co_row['co_skin'] : 'type_a';
if (!$skin_name)
    $skin_name = 'type_a';
$skin_file = G5_PLUGIN_PATH . '/company_intro/skin/' . $skin_name . '.html';

// 3. Content Processing (If skin exists)
$view_content = '';
if (file_exists($skin_file)) {
    $view_content = $co_row['co_content'];

    // [COPYRIGHT MANAGER]
    if (strpos($view_content, '{CP_') !== false) {
        if (!function_exists('get_copyright_config')) {
            $cp_lib = G5_PLUGIN_PATH . '/copyright_manager/lib.php';
            if (file_exists($cp_lib))
                include_once($cp_lib);
        }

        if (function_exists('get_copyright_config')) {
            $cp_config = get_copyright_config();
            $replacements = array(
                '{CP_ADDRESS}' => $cp_config['addr_val'],
                '{CP_TEL}' => $cp_config['tel_val'],
                '{CP_FAX}' => $cp_config['fax_val'],
                '{CP_EMAIL}' => $cp_config['email_val']
            );
            $view_content = strtr($view_content, $replacements);
        }
    }

    // [MAP API]
    if (strpos($view_content, '{MAP_API_DISPLAY}') !== false) {
        $map_lib = G5_PLUGIN_PATH . '/map_api/lib/map.lib.php';
        if (file_exists($map_lib)) {
            include_once($map_lib);
            if (function_exists('display_map_api')) {
                $map_html = display_map_api('100%', '100%');
                $view_content = str_replace('{MAP_API_DISPLAY}', $map_html, $view_content);
            }
        }
    }
} else {
    $view_content = '스킨 파일이 존재하지 않습니다.';
}

// 4. Background Color Helper
$bg_color = (isset($co_row['co_bgcolor']) && $co_row['co_bgcolor']) ? $co_row['co_bgcolor'] : get_theme_css_value($config['cf_theme'], array('--color-bg', '--color-bg-dark'), '#121212');
?>