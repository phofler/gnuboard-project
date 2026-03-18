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

    $parts = explode('_', $id);
    if (in_array($parts[0], $themes)) {
        $res['theme'] = $parts[0];
        if (isset($parts[1]) && in_array($parts[1], array('kr', 'en', 'jp', 'cn'))) {
            $res['lang'] = $parts[1];
            if (isset($parts[2])) {
                array_shift($parts);
                array_shift($parts);
                $res['custom'] = implode('_', $parts);
            }
        } else {
            if (isset($parts[1])) {
                array_shift($parts);
                $res['custom'] = implode('_', $parts);
            }
        }
    } else {
        $res['custom'] = $id;
    }
    return $res;
}

/**
 * Smart Fallback: Find best matching record for current theme/lang
 */
function get_premium_config($table, $id_column, $requested_id = '', $theme = '', $lang = '') {
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
 */
function render_premium_id_ui($id_field, $current_id, $readonly = false) {
    $themes = get_premium_themes();
    $parts = parse_premium_id($current_id, $themes);
    
    $html = '<div class="premium-id-ui" style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">';
    
    // Theme Select
    $html .= '<select id="'.$id_field.'_theme" class="frm_input" onchange="PremiumModule.generateId(\''.$id_field.'\')" '.($readonly ? 'disabled' : '').'>';
    $html .= '<option value="">테마 선택</option>';
    foreach ($themes as $theme) {
        $selected = ($theme == $parts['theme']) ? 'selected' : '';
        $html .= '<option value="'.$theme.'" '.$selected.'>'.$theme.'</option>';
    }
    $html .= '</select>';
    
    // Lang Select
    $html .= '<select id="'.$id_field.'_lang" class="frm_input" onchange="PremiumModule.generateId(\''.$id_field.'\')" '.($readonly ? 'disabled' : '').'>';
    $html .= '<option value="">언어 선택</option>';
    foreach (array('kr'=>'한국어', 'en'=>'English', 'jp'=>'Japanese', 'cn'=>'Chinese') as $k=>$v) {
        $selected = ($k == $parts['lang']) ? 'selected' : '';
        $html .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
    }
    $html .= '</select>';
    
    // Custom Input
    $html .= '<input type="text" id="'.$id_field.'_custom" value="'.htmlspecialchars($parts['custom']).'" class="frm_input" placeholder="커스텀 이름 (영문/숫자)" onkeyup="PremiumModule.generateId(\''.$id_field.'\')" '.($readonly ? 'readonly' : '').'>';
    
    $html .= '</div>';
    
    // Display Area
    $html .= '<div style="margin-top:8px; font-size:12px; color:#666; padding:10px; background:#f9f9f9; border:1px solid #eee; display:inline-block;">';
    $html .= '식별코드(ID): <strong id="'.$id_field.'_display" style="color:#d4af37; font-size:1.1em;">'.($current_id ?: '-').'</strong>';
    $html .= '</div>';
    $html .= '<input type="hidden" name="'.$id_field.'" id="'.$id_field.'" value="'.$current_id.'">';
    
    // JS Logic (Self-contained)
    $html .= '<script>
    var PremiumModule = PremiumModule || {
        generateId: function(prefix) {
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
        }
    };
    jQuery(function() { PremiumModule.generateId("'.$id_field.'"); });
    </script>';
    
    return $html;
}