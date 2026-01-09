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
global $config; // [Fix] Ensure global config is available in function scope

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
            // [Fix] Explicitly construct ID from Company Intro settings for accurate matching
            // Normalize Korean code: Company Intro(kr) -> Copyright Manager(ko)
            $target_cp_id = '';
            if (isset($co_row['co_theme']) && isset($co_row['co_lang'])) {
                $target_lang = ($co_row['co_lang'] == 'kr') ? 'ko' : $co_row['co_lang'];
                $target_cp_id = $co_row['co_theme'] . '_' . $target_lang;
            }

            $cp_config = get_copyright_config($target_cp_id);

            $replacements = array(
                '{CP_ADDRESS}' => $cp_config['addr_val'],
                '{CP_TEL}' => $cp_config['tel_val'],
                '{CP_FAX}' => $cp_config['fax_val'],
                '{CP_EMAIL}' => $cp_config['email_val'],
                '{CO_THEME}' => $co_row['co_theme'],
                '{CO_LANG}' => $co_row['co_lang'],
                '{ACTION_URL}' => G5_PLUGIN_URL . '/online_inquiry/action/write_update.php'
            );
            $view_content = strtr($view_content, $replacements);
        }
    }

    // [MAP API]
    // 1. Specific ID Shortcode: {MAP_API:corporate_en}
    if (preg_match_all('/\{MAP_API:([a-zA-Z0-9_]+)\}/', $view_content, $matches)) {
        $map_lib = G5_PLUGIN_PATH . '/map_api/lib/map.lib.php';
        if (file_exists($map_lib)) {
            include_once($map_lib);
            if (function_exists('display_map_api')) {
                foreach ($matches[1] as $idx => $map_id) {
                    $map_html = display_map_api('100%', '100%', $map_id);
                    $view_content = str_replace($matches[0][$idx], $map_html, $view_content);
                }
            }
        }
    }

    // 2. Context-Aware Shortcode: {MAP_API_DISPLAY}
    if (strpos($view_content, '{MAP_API_DISPLAY}') !== false) {
        $map_lib = G5_PLUGIN_PATH . '/map_api/lib/map.lib.php';
        if (file_exists($map_lib)) {
            include_once($map_lib);
            if (function_exists('display_map_api')) {
                // [Fix] Explicitly construct ID for accurate matching
                if (isset($co_row['co_theme']) && isset($co_row['co_lang'])) {
                    $target_lang = ($co_row['co_lang'] == 'kr') ? 'ko' : $co_row['co_lang'];
                    $target_map_id = $co_row['co_theme'] . '_' . $target_lang;
                }

                $map_html = display_map_api('100%', '100%', $target_map_id);
                $view_content = str_replace('{MAP_API_DISPLAY}', $map_html, $view_content);
            }
        }
    }

    // [LATEST SKIN MANAGER]
    // 1. Specific ID: {LATEST_SKIN:corporate_main_works}
    if (preg_match_all('/\{LATEST_SKIN:([a-zA-Z0-9_]+)\}/', $view_content, $matches)) {
        $latest_lib = G5_PLUGIN_PATH . '/latest_skin_manager/lib/latest_skin.lib.php';
        if (file_exists($latest_lib)) {
            include_once($latest_lib);
            if (function_exists('display_latest_skin_by_id')) {
                foreach ($matches[1] as $idx => $ls_id) {
                    $ls_data = get_latest_skin_config($ls_id);
                    $ls_html = is_array($ls_data) ? $ls_data['html'] : $ls_data;
                    $view_content = str_replace($matches[0][$idx], $ls_html, $view_content);
                }
            }
        }
    }

    // 2. Context-Aware: {LATEST_SKIN_DISPLAY}
    if (strpos($view_content, '{LATEST_SKIN_DISPLAY}') !== false) {
        $latest_lib = G5_PLUGIN_PATH . '/latest_skin_manager/lib/latest_skin.lib.php';
        if (file_exists($latest_lib)) {
            include_once($latest_lib);
            if (function_exists('get_latest_skin_config')) {
                // Determine ID (Clean ID Standard)
                $target_ls_id = $co_row['co_theme'] . '_main_works';
                // Fallback for Korean/English based on co_lang if needed, but Pattern B+ prefers no _kr
                if (isset($co_row['co_lang']) && $co_row['co_lang'] != 'kr') {
                    $target_ls_id .= '_' . $co_row['co_lang'];
                }

                $ls_data = get_latest_skin_config($target_ls_id);
                if (is_array($ls_data)) {
                    $replacements = array(
                        '{LATEST_SKIN_DISPLAY}' => $ls_data['html'],
                        '{LS_TITLE}' => $ls_data['title'],
                        '{LS_DESCRIPTION}' => $ls_data['description'],
                        '{LS_MORE_LINK}' => $ls_data['more_link'],
                        '{LS_MORE_TEXT}' => ($co_row['co_lang'] == 'kr' ? '더보기 +' : 'MORE +')
                    );
                    $view_content = strtr($view_content, $replacements);
                } else {
                    $view_content = str_replace('{LATEST_SKIN_DISPLAY}', $ls_data, $view_content);
                }
            }
        }
    }
} else {
    $view_content = '스킨 파일이 존재하지 않습니다.';
}

// 4. Background Color Helper
$bg_color = (isset($co_row['co_bgcolor']) && $co_row['co_bgcolor']) ? $co_row['co_bgcolor'] : get_theme_css_value($config['cf_theme'], array('--color-bg', '--color-bg-dark'), '#121212');
?>