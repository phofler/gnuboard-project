<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Get Copyright Configuration
 */
function get_theme_default_bgcolor($theme_name)
{
    // [THEME SOVEREIGNTY] Use get_theme_css_value to dynamically fetch 
    // the primary background color of the selected theme.
    include_once(G5_PATH . '/lib/theme_css.lib.php');
    return get_theme_css_value($theme_name, array('--color-bg', '--color-bg-dark'), '#ffffff');
}

function get_copyright_config($cp_id = '')
{
    global $g5, $config;
    $table_name = G5_TABLE_PREFIX . 'plugin_copyright';

    // If no ID specified, try active theme first
    if (!$cp_id) {
        $theme_name = (isset($config['cf_theme']) && $config['cf_theme']) ? $config['cf_theme'] : 'default';
        $cp_id = $theme_name;
    }

    // Check if table exists
    $row = sql_fetch(" SHOW TABLES LIKE '{$table_name}' ");
    if (!$row)
        return array();

    $cp = sql_fetch(" select * from {$table_name} where cp_id = '{$cp_id}' ");

    // Fallback to default if theme specific not found
    if (!$cp && $cp_id != 'default') {
        $cp = sql_fetch(" select * from {$table_name} where cp_id = 'default' ");
    }

    if (!$cp) return array();

    return $cp;
}

/**
 * Display Footer Information
 * [Premium Standardization] Integrated with set_pro_skin_context
 */
function display_footer_info($cp_id = '')
{
    global $g5, $config;

    $plugin_path = G5_PLUGIN_PATH . '/copyright_manager';
    $cp = get_copyright_config($cp_id);
    if (!$cp) return;

    // [Premium] set_pro_skin_context 연동
    if (function_exists('set_pro_skin_context')) {
        set_pro_skin_context(array(
            'title' => $cp['cp_subject'],
            'txt_addr' => $cp['addr_val'],
            'txt_tel' => $cp['tel_val'],
            'txt_fax' => $cp['fax_val'],
            'txt_email' => $cp['email_val'],
            'txt_copyright' => $cp['copyright'],
            'txt_slogan' => $cp['slogan'],
            'img_logo' => $cp['logo_url'],
            'link1_name' => $cp['link1_name'],
            'link1_url' => $cp['link1_url'],
            'link2_name' => $cp['link2_name'],
            'link2_url' => $cp['link2_url']
        ));
    }

    $footer_skin = $cp['cp_skin'];
    $skin_path = $plugin_path . '/skins/' . $footer_skin;
    $skin_url = G5_PLUGIN_URL . '/copyright_manager/skins/' . $footer_skin;
    $skin_file = $skin_path . '/footer.skin.php';

    if (!file_exists($skin_file)) return;

    // Process Content Substitution
    $content = $cp['cp_content'];
    $replacements = array(
        '{addr}' => $cp['addr_val'],
        '{tel}' => $cp['tel_val'],
        '{fax}' => $cp['fax_val'],
        '{email}' => $cp['email_val'],
        '{addr_name}' => $cp['addr_label'],
        '{tel_name}' => $cp['tel_label'],
        '{fax_name}' => $cp['fax_label'],
        '{email_name}' => $cp['email_label'],
        '{copyright}' => $cp['copyright'],
        '{slogan}' => $cp['slogan'],
        '{logo}' => ($cp['logo_url'] ? '<img src="' . $cp['logo_url'] . '" class="footer-logo">' : ''),
        '{link1}' => ($cp['link1_url'] ? '<a href="' . $cp['link1_url'] . '">' . $cp['link1_name'] . '</a>' : ''),
        '{link2}' => ($cp['link2_url'] ? '<a href="' . $cp['link2_url'] . '">' . $cp['link2_name'] . '</a>' : '')
    );
    $processed_content = strtr($content, $replacements);
    $cp['processed_content'] = $processed_content;

    // Include Skin CSS
    if (file_exists($skin_path . '/style.css')) {
        echo '<link rel="stylesheet" href="' . $skin_url . '/style.css?ver=' . time() . '">' . PHP_EOL;
    }

    $bg_color = (isset($cp['cp_bgcolor']) && $cp['cp_bgcolor']) ? $cp['cp_bgcolor'] : '';
    $bg_style = $bg_color ? "background-color:{$bg_color}; --cp-bg:{$bg_color};" : "";

    echo '<div class="copyright-manager-wrapper" style="' . $bg_style . '">';
    include($skin_file);
    echo '</div>';
}

/**
 * [Premium] Copyright Widget Shortcut
 */
if (!function_exists('copyright_widget')) {
    function copyright_widget($cp_id = '') {
        display_footer_info($cp_id);
    }
}
?>