<?php
if (!defined('_GNUBOARD_'))
    exit;

function display_top_menu()
{
    global $g5, $is_member, $is_admin, $config;

    $plugin_path = G5_PLUGIN_PATH . '/top_menu_manager';
    $skins_path = $plugin_path . '/skins';

    // 1. Identify Config ID
    // Default to Theme Name (e.g. 'corporate', 'corporate_light')
    $tm_id = isset($config['cf_theme']) ? trim($config['cf_theme']) : '';

    // [Multi-Language Support]
    if (defined('G5_LANG') && G5_LANG != 'kr' && $tm_id) {
        $tm_id .= '_' . G5_LANG;
    }

    // [Manual Override possible here via global if needed]
    // if (defined('G5_TOP_MENU_ID')) $tm_id = G5_TOP_MENU_ID;

    // 2. Load Config from DB
    // [Standardization] Fallback Logic: Specific Lang -> Base Theme -> Default
    $tm = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");

    // [Standardization Fallback] If not found, try common suffixes for default language
    if (!$tm && strpos($tm_id, '_') === false) {
        $tm = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}_ko' ");
        if (!$tm) {
            $tm = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}_kr' ");
        }
    }

    echo '<!-- DEBUG: Looking for Config ID: [' . $tm_id . '] -->';

    // Fallback: If Specific Language Config (e.g. corporate_en) not found, try Base ID (e.g. corporate)
    if (!$tm && defined('G5_LANG') && G5_LANG != 'kr') {
        $base_id = isset($config['cf_theme']) ? trim($config['cf_theme']) : '';
        if ($base_id && $base_id != $tm_id) {
            echo '<!-- DEBUG: Config not found. Fallback to Base ID: [' . $base_id . '] -->';
            $tm = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$base_id}' ");
        }
    }

    echo '<!-- DEBUG: Found Config: ' . ($tm ? 'YES' : 'NO') . ' -->';

    if ($tm) {
        $top_menu_skin = $tm['tm_skin'];

        // Define Menu Source for Pro Menu Manager
        if ($tm['tm_menu_table'] && !defined('G5_PRO_MENU_TABLE')) {
            define('G5_PRO_MENU_TABLE', 'g5_write_menu_pdc_' . $tm['tm_menu_table']);
        }

        // Logo Variables for Skin (Skins need to use these)
        $top_logo_pc = $tm['tm_logo_pc'] ? G5_DATA_URL . '/common/' . $tm['tm_logo_pc'] : '';
        $top_logo_mo = $tm['tm_logo_mo'] ? G5_DATA_URL . '/common/' . $tm['tm_logo_mo'] : '';

    } else {
        // Fallback to File settings or default
        $top_menu_skin = 'basic';
        $setting_file = $plugin_path . '/setting.php';
        if (file_exists($setting_file)) {
            include($setting_file);
        }
    }

    $skin_path = $skins_path . '/' . $top_menu_skin;
    $skin_url = G5_PLUGIN_URL . '/top_menu_manager/skins/' . $top_menu_skin;

    if (!file_exists($skin_path . '/menu.skin.php')) {
        echo '<!-- Selected Top Menu Skin (' . $top_menu_skin . ') not found. -->';
        return;
    }

    // [FIX] Data Integration: Fetch Menu Data from Pro Menu Manager
    $menu_datas = array();
    $pro_menu_lib = G5_PLUGIN_PATH . '/pro_menu_manager/lib.php';
    if (file_exists($pro_menu_lib)) {
        include_once($pro_menu_lib);

        if (function_exists('get_pro_menu_list') && function_exists('build_pro_menu_tree')) {
            // 1. Get raw list (automatically uses G5_PRO_MENU_TABLE if defined)
            $raw_menus = get_pro_menu_list();
            echo '<!-- DEBUG: Table used: ' . (defined('G5_PRO_MENU_TABLE') ? G5_PRO_MENU_TABLE : 'default') . ' -->';
            echo '<!-- DEBUG: Raw menu count: ' . count($raw_menus) . ' -->';

            // 2. Build Tree
            $menu_tree = build_pro_menu_tree($raw_menus);
            echo '<!-- DEBUG: Tree count: ' . count($menu_tree) . ' -->';

            // 3. Map to Skin Format (ma_* -> me_*)
            foreach ($menu_tree as $root) {
                $root_mapped = array(
                    'me_name' => $root['ma_name'],
                    'me_link' => $root['ma_link'],
                    'me_target' => $root['ma_target'],
                    'me_code' => $root['ma_code'],
                    'sub' => array()
                );

                if (!empty($root['sub'])) {
                    foreach ($root['sub'] as $child) {
                        $child_mapped = array(
                            'me_name' => $child['ma_name'],
                            'me_link' => $child['ma_link'],
                            'me_target' => $child['ma_target'],
                            'me_code' => $child['ma_code'],
                            'sub' => array()
                        );

                        if (!empty($child['sub'])) {
                            foreach ($child['sub'] as $grand) {
                                $child_mapped['sub'][] = array(
                                    'me_name' => $grand['ma_name'],
                                    'me_link' => $grand['ma_link'],
                                    'me_target' => $grand['ma_target'],
                                    'me_code' => $grand['ma_code']
                                );
                            }
                        }
                        $root_mapped['sub'][] = $child_mapped;
                    }
                }
                $menu_datas[] = $root_mapped;
            }
        }
    }

    if (file_exists($skin_path . '/style.css')) {
        echo '<link rel="stylesheet" href="' . $skin_url . '/style.css?ver=' . time() . '">' . PHP_EOL;
    }

    include($skin_path . '/menu.skin.php');
}
?>