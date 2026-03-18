<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * Premium Module Framework Core Library
 * Standardization for Theme-aware ID Generation and Data Fallback
 */

/**
 * Discovery: Get all themes in theme directory
 */
function get_premium_themes() {
    $themes = array();
    $theme_dir = G5_PATH . '/theme';
    if (is_dir($theme_dir)) {
        $tdir = dir($theme_dir);
        while ($entry = $tdir->read()) {
            if ($entry == '.' || $entry == '..') continue;
            if (is_dir($theme_dir . '/' . $entry)) $themes[] = $entry;
        }
        $tdir->close();
    }
    sort($themes);
    return $themes;
}

/**
 * ID Parsing: Split composite ID into components
 */
function parse_premium_id($id, $themes) {
    $res = array('theme' => '', 'lang' => '', 'custom' => '');
    if (!$id) return $res;

    if ($id == 'default') {
        $res['custom'] = 'default';
        return $res;
    }

    // Try to find the longest matching theme from the beginning of the ID
    $parts = explode('_', $id);
    for ($i = count($parts); $i > 0; $i--) {
        $candidate = implode('_', array_slice($parts, 0, $i));
        if (in_array($candidate, $themes)) {
            $res['theme'] = $candidate;
            $remaining = array_slice($parts, $i);
            
            // Check if next part is a language code
            if (isset($remaining[0]) && in_array($remaining[0], array('kr', 'en', 'jp', 'cn'))) {
                $res['lang'] = $remaining[0];
                array_shift($remaining);
            }
            
            $res['custom'] = implode('_', $remaining);
            return $res;
        }
    }

    // Fallback: entire ID is custom
    $res['custom'] = $id;
    return $res;
}

/**
 * Smart Fallback: Find best matching record for current theme/lang
 */
function get_premium_config($table, $requested_id = '', $id_column = 'co_id', $theme = '', $lang = '') {
    global $config;
    
    // 1. Check Requested ID first
    if ($requested_id) {
        $row = sql_fetch(" SELECT * FROM {$table} WHERE {$id_column} = '{$requested_id}' ");
        if ($row) return $row;
    }

    // 2. Auto-Detect context
    $theme = $theme ?: (isset($config['cf_theme']) ? $config['cf_theme'] : 'default');
    $lang = $lang ?: (isset($_GET['lang']) ? $_GET['lang'] : (defined('G5_LANG') ? G5_LANG : 'kr'));
    
    $is_korean = ($lang == 'kr' || $lang == 'ko');
    $target_id = $theme . ($is_korean ? '' : '_' . $lang);

    // Try target ID
    $row = sql_fetch(" SELECT * FROM {$table} WHERE {$id_column} = '{$target_id}' ");
    if ($row) return $row;

    // Retry suffixes for Korean if not found
    if ($is_korean) {
        foreach(array('_ko', '_kr') as $suffix) {
            $row = sql_fetch(" SELECT * FROM {$table} WHERE {$id_column} = '{$theme}{$suffix}' ");
            if ($row) return $row;
        }
    }

    // Try Theme only
    $row = sql_fetch(" SELECT * FROM {$table} WHERE {$id_column} = '{$theme}' ");
    if ($row) return $row;

    // Last Fallback: default
    return sql_fetch(" SELECT * FROM {$table} WHERE {$id_column} = 'default' ");
}

/**
 * Admin UI: Render ID generation fields
 * Supports both array options and positional arguments for compatibility
 */
function render_premium_id_ui($options, $legacy_id = '', $legacy_readonly = false) {
    if (is_array($options)) {
        $id_field = isset($options['id_name']) ? $options['id_name'] : 'id';
        $current_id = isset($options['id']) ? $options['id'] : $legacy_id;
        $readonly = isset($options['readonly']) ? $options['readonly'] : $legacy_readonly;
        $label = isset($options['label']) ? $options['label'] : '설정 대상 (Theme & Lang)';
        $onchange = isset($options['onchange']) ? $options['onchange'] : '';
    } else {
        $id_field = $options;
        $current_id = $legacy_id;
        $readonly = $legacy_readonly;
        $label = '설정 대상 (Theme & Lang)';
        $onchange = '';
    }

    $themes = get_premium_themes();
    $parts = parse_premium_id($current_id, $themes);
    
    $html = "<tr>\n";
    $html .= '<th scope="row">'.$label.'</th>';
    $html .= "<td>\n";
    $html .= '<div class="premium-id-ui" style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">';
    
    // Theme Select
    $theme_name = isset($options['theme_name']) ? $options['theme_name'] : str_replace('_id', '_theme', $id_field);
    $html .= '<select id="'.$id_field.'_theme" name="'.$theme_name.'" class="frm_input" onchange="PremiumModule.generateId(\''.$id_field.'\', \''.$onchange.'\')" '.($readonly ? 'disabled' : '').'>';
    $html .= '<option value="">테마 선택</option>';
    foreach ($themes as $theme) {
        $selected = ($theme == $parts['theme']) ? 'selected' : '';
        $html .= '<option value="'.$theme.'" '.$selected.'>'.$theme.'</option>';
    }
    $html .= '</select>';
    
    // Lang Select
    $lang_name = isset($options['lang_name']) ? $options['lang_name'] : str_replace('_id', '_lang', $id_field);
    $html .= '<select id="'.$id_field.'_lang" name="'.$lang_name.'" class="frm_input" onchange="PremiumModule.generateId(\''.$id_field.'\', \''.$onchange.'\')" '.($readonly ? 'disabled' : '').'>';
    foreach (array('kr'=>'한국어', 'en'=>'English', 'jp'=>'Japanese', 'cn'=>'Chinese') as $k=>$v) {
        $selected = ($k == $parts['lang']) ? 'selected' : '';
        $html .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
    }
    $html .= '</select>';
    
    // Custom Input
    $custom_name = isset($options['custom_name']) ? $options['custom_name'] : str_replace('_id', '_id_custom', $id_field);
    $html .= '<input type="text" id="'.$id_field.'_custom" name="'.$custom_name.'" value="'.htmlspecialchars($parts['custom']).'" class="frm_input" placeholder="커스텀 이름" onkeyup="PremiumModule.generateId(\''.$id_field.'\', \''.$onchange.'\')" '.($readonly ? 'readonly' : '').'>';
    
    $html .= '</div>';
    
    // Display Area
    $html .= '<div style="margin-top:8px; font-size:12px; color:#666; padding:10px; background:#f9f9f9; border:1px solid #eee; display:inline-block;">';
    $html .= '생성된 식별코드(ID): <strong id="'.$id_field.'_display" style="color:#d4af37; font-size:1.1em;">'.($current_id ?: '-').'</strong>';
    $html .= '</div>';
    $html .= '<input type="hidden" name="'.$id_field.'" id="'.$id_field.'" value="'.$current_id.'">';
    
    // JS Logic
    $html .= '<script>
    var PremiumModule = PremiumModule || {
        generateId: function(prefix, callback) {
            var theme = jQuery("#" + prefix + "_theme").val();
            var lang = jQuery("#" + prefix + "_lang").val();
            var custom = jQuery("#" + prefix + "_custom").val().trim().replace(/[^a-z0-9_]/gi, "");
            jQuery("#" + prefix + "_custom").val(custom);

            if (custom === "default") {
                jQuery("#" + prefix + "_display").text("default");
                jQuery("#" + prefix + "").val("default");
                return;
            }

            if (!theme) {
                if (custom) {
                    jQuery("#" + prefix + "_display").text(custom);
                    jQuery("#" + prefix + "").val(custom);
                } else {
                    jQuery("#" + prefix + "_display").text("-");
                    jQuery("#" + prefix + "").val("");
                }
                return;
            }

            var new_id = theme;
            if (lang && lang !== "kr") new_id += "_" + lang;
            if (custom) new_id += "_" + custom;

            jQuery("#" + prefix + "_display").text(new_id);
            jQuery("#" + prefix + "").val(new_id);
            
            if (callback && typeof window[callback] === "function") {
                window[callback]();
            }
        }
    };
    </script>';
    $html .= "</td>\n";
    $html .= "</tr>\n";
    
    return $html;
}
/**
 * Placeholder Expansion: Replace standardized tokens with live data
 */
function expand_premium_placeholder($content, $bridge_id = '') {
    global $g5, $config;

    // 1. Map API Integration
    if (strpos($content, '{MAP_API_DISPLAY}') !== false) {
        $map_html = '';
        if (file_exists(G5_PLUGIN_PATH . '/map_api/lib/map.lib.php')) {
            include_once(G5_PLUGIN_PATH . '/map_api/lib/map.lib.php');
            if (function_exists('display_map_api')) {
                // Capturing both echo and return just in case, though standard is return
                ob_start();
                $returned_html = display_map_api('100%', '600px', $bridge_id);
                $echoed_html = ob_get_clean();
                $map_html = $returned_html . $echoed_html;
            }
        }
        $content = str_replace('{MAP_API_DISPLAY}', $map_html, $content);
    }

    // 2. Copyright / Company Info Integration (Global Context)
    $company_data = array();
    if (file_exists(G5_PLUGIN_PATH . '/copyright_manager/lib.php')) {
        include_once(G5_PLUGIN_PATH . '/copyright_manager/lib.php');
        if (function_exists('get_copyright_config')) {
            $company_data = get_copyright_config();
        }
    }

    $replacements = array(
        '{CP_COMPANY}' => isset($company_data['company_val']) ? $company_data['company_val'] : $config['cf_title'],
        '{CP_CEO}'     => isset($company_data['ceo_val']) ? $company_data['ceo_val'] : '',
        '{CP_BIZNO}'   => isset($company_data['bizno_val']) ? $company_data['bizno_val'] : '',
        '{CP_TEL}'     => isset($company_data['tel_val']) ? $company_data['tel_val'] : '',
        '{CP_FAX}'     => isset($company_data['fax_val']) ? $company_data['fax_val'] : '',
        '{CP_ADDRESS}' => isset($company_data['addr_val']) ? $company_data['addr_val'] : '',
        '{CP_EMAIL}'   => isset($company_data['email_val']) ? $company_data['email_val'] : $config['cf_admin_email'],
        '{COMPANY}'    => isset($company_data['company_val']) ? $company_data['company_val'] : $config['cf_title'],
        '{ADDR}'       => isset($company_data['addr_val']) ? $company_data['addr_val'] : '',
    );

    foreach ($replacements as $key => $val) {
        $content = str_replace($key, $val, $content);
    }

    return $content;
}