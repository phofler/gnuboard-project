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

    // If no ID specified, try active theme first, then 'default'
    if (!$cp_id) {
        $theme_name = (isset($config['cf_theme']) && $config['cf_theme']) ? $config['cf_theme'] : 'default';
        $lang = (defined('G5_LANG') ? G5_LANG : 'kr');
        $is_korean = ($lang == 'kr' || $lang == 'ko');

        $cp_id = $theme_name; // Default ID is now just the theme name (No suffix for KR)

        // [Standardization Fallback] Check Current Theme ID first
        $row_check = sql_fetch(" select count(*) as cnt from {$table_name} where cp_id = '{$cp_id}' ");

        // If not found and it's Korean, try searching with _ko or _kr suffix (Old Style)
        if (!$row_check['cnt'] && $is_korean) {
            $chk_id_ko = $theme_name . '_ko';
            $chk_id_kr = $theme_name . '_kr';
            $row_ko = sql_fetch(" select count(*) as cnt from {$table_name} where cp_id = '{$chk_id_ko}' ");
            if ($row_ko['cnt']) {
                $cp_id = $chk_id_ko;
            } else {
                $row_kr = sql_fetch(" select count(*) as cnt from {$table_name} where cp_id = '{$chk_id_kr}' ");
                if ($row_kr['cnt']) {
                    $cp_id = $chk_id_kr;
                }
            }
        }
    }

    // Check if table exists
    $row = sql_fetch(" SHOW TABLES LIKE '{$table_name}' ");
    if (!$row)
        return array();

    $cp = sql_fetch(" select * from {$table_name} where cp_id = '{$cp_id}' ");

    // Fallback logic (Row level)
    $default_cp = array();
    if ($cp_id != 'default') {
        $default_cp = sql_fetch(" select * from {$table_name} where cp_id = 'default' ");
        if (!$cp) {
            $cp = $default_cp;
        }
    }

    // Field-level Fallback (if specific value is empty, use default)
    if ($cp && $default_cp) {
        $fields = array('addr_val', 'tel_val', 'fax_val', 'email_val', 'link1_name', 'link1_url', 'link2_name', 'link2_url', 'slogan', 'copyright', 'addr_label', 'tel_label', 'fax_label', 'email_label');
        foreach ($fields as $field) {
            if (!isset($cp[$field]) || trim($cp[$field]) === '') {
                if (isset($default_cp[$field])) {
                    $cp[$field] = $default_cp[$field];
                }
            }
        }
    }

    /* Smart Background Default - REMOVED to follow "No Hardcoding" rule. 
       Let CSS variables in default.css handle the fallback. */

    return $cp;
}

/**
 * Display Footer Information
 * This function handles CSS inclusion and returns skin path
 */
function display_footer_info($cp_id = '')
{
    global $g5, $config;

    $plugin_path = G5_PLUGIN_PATH . '/copyright_manager';

    $cp = get_copyright_config($cp_id);
    if (!$cp)
        return;

    $footer_skin = $cp['cp_skin'];
    $skin_path = $plugin_path . '/skins/' . $footer_skin;
    $skin_url = G5_PLUGIN_URL . '/copyright_manager/skins/' . $footer_skin;

    $skin_file = $skin_path . '/footer.skin.php';

    if (!file_exists($skin_file)) {
        return;
    }

    // Process Shortcodes in Content
    $content = $cp['cp_content'];

    // [Fix] Auto-recover polluted DB status (Auto-Decode)
    if (preg_match('/^\s*&lt;[a-z]+/', $content) || preg_match('/^\s*&amp;lt;/', $content)) {
        $content = html_entity_decode($content);
        if (preg_match('/^\s*&lt;[a-z]+/', $content)) {
            $content = html_entity_decode($content);
        }
    }

    // Values
    $content = str_replace('{addr}', $cp['addr_val'], $content);
    $content = str_replace('{tel}', $cp['tel_val'], $content);
    $content = str_replace('{fax}', $cp['fax_val'], $content);
    $content = str_replace('{email}', $cp['email_val'], $content);

    // Labels (Names) - Mapped to *_name for consistency
    $content = str_replace('{addr_name}', $cp['addr_label'], $content);
    $content = str_replace('{tel_name}', $cp['tel_label'], $content);
    $content = str_replace('{fax_name}', $cp['fax_label'], $content);
    $content = str_replace('{email_name}', $cp['email_label'], $content);

    // Legacy support (optional, if user mixes usage)
    $content = str_replace('{addr_label}', $cp['addr_label'], $content);
    $content = str_replace('{tel_label}', $cp['tel_label'], $content);
    $content = str_replace('{fax_label}', $cp['fax_label'], $content);
    $content = str_replace('{email_label}', $cp['email_label'], $content);

    // Misc
    $content = str_replace('{logo}', ($cp['logo_url'] ? '<img src="' . $cp['logo_url'] . '" class="footer-logo">' : ''), $content);
    $content = str_replace('{copyright}', $cp['copyright'], $content);
    $content = str_replace('{slogan}', $cp['slogan'], $content);

    // Links (Full HTML and Individual parts)
    $content = str_replace('{link1}', ($cp['link1_url'] ? '<a href="' . $cp['link1_url'] . '">' . $cp['link1_name'] . '</a>' : ''), $content);
    $content = str_replace('{link2}', ($cp['link2_url'] ? '<a href="' . $cp['link2_url'] . '">' . $cp['link2_name'] . '</a>' : ''), $content);
    $content = str_replace('{link1_name}', $cp['link1_name'], $content); // Raw Name
    $content = str_replace('{link1_url}', $cp['link1_url'], $content);   // Raw URL
    $content = str_replace('{link2_name}', $cp['link2_name'], $content); // Raw Name
    $content = str_replace('{link2_url}', $cp['link2_url'], $content);   // Raw URL

    // Store in global so skin can use it
    $cp['processed_content'] = $content;

    // Include Skin CSS
    if (file_exists($skin_path . '/style.css')) {
        echo '<link rel="stylesheet" href="' . $skin_url . '/style.css?ver=' . time() . '">' . PHP_EOL;
    }

    $bg_color = (isset($cp['cp_bgcolor']) && $cp['cp_bgcolor'] && $cp['cp_bgcolor'] != '#000000') ? $cp['cp_bgcolor'] : '';
    $bg_style = $bg_color ? "background-color:{$bg_color}; --cp-bg:{$bg_color};" : "";

    echo '<div class="copyright-manager-wrapper" style="' . $bg_style . '">';
    include($skin_path . '/footer.skin.php');
    echo '</div>';
}
?>