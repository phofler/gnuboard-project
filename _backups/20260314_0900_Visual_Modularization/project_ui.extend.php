<?php
if (!defined("_GNUBOARD_")) exit;

/**
 * 설정 대상 (Theme & Lang) 관리 UI 생성 공통 함수
 */
function get_theme_lang_select_ui($params = array()) {
    $prefix = isset($params["prefix"]) ? $params["prefix"] : "tm_";
    $tm_theme = isset($params["theme"]) ? $params["theme"] : "";
    $tm_lang = isset($params["lang"]) ? $params["lang"] : "kr";
    $tm_custom = isset($params["custom"]) ? $params["custom"] : "";
    $tm_id = isset($params["id"]) ? $params["id"] : "";
    
    $id_display_id = isset($params["id_display_id"]) ? $params["id_display_id"] : "display_".$prefix."id";
    $id_input_id = isset($params["id_input_id"]) ? $params["id_input_id"] : $prefix."id";

    $themes = array();
    $theme_dir = G5_PATH . "/theme";
    if (is_dir($theme_dir)) {
        $dirs = dir($theme_dir);
        while (false !== ($entry = $dirs->read())) {
            if ($entry == "." || $entry == "..") continue;
            if (is_dir($theme_dir . "/" . $entry)) { $themes[] = $entry; }
        }
        $dirs->close();
    }
    sort($themes);

    ob_start();
    ?>
    <div style="display:flex; gap:10px; align-items:center;">
        <select name="<?php echo $prefix; ?>theme" id="<?php echo $prefix; ?>theme" class="frm_input" onchange="generate_<?php echo $prefix; ?>id()" required>
            <option value="">테마 선택</option>
            <?php foreach ($themes as $theme) {
                $selected = ($theme == $tm_theme) ? "selected" : "";
                echo "<option value=\"" . $theme . "\" " . $selected . ">" . $theme . "</option>";
            } ?>
        </select>

        <select name="<?php echo $prefix; ?>lang" id="<?php echo $prefix; ?>lang" class="frm_input" onchange="generate_<?php echo $prefix; ?>id()" required>
            <option value="">언어 선택</option>
            <option value="kr" <?php echo ($tm_lang == "kr") ? "selected" : ""; ?>>한국어 (KR)</option>
            <option value="en" <?php echo ($tm_lang == "en") ? "selected" : ""; ?>>English (EN)</option>
            <option value="jp" <?php echo ($tm_lang == "jp") ? "selected" : ""; ?>>Japanese (JP)</option>
            <option value="cn" <?php echo ($tm_lang == "cn") ? "selected" : ""; ?>>Chinese (CN)</option>
        </select>

        <input type="text" name="<?php echo $prefix; ?>id_custom" id="<?php echo $prefix; ?>id_custom" value="<?php echo $tm_custom; ?>"
            class="frm_input" style="width:150px;" placeholder="커스텀 이름 (선택)"
            onkeyup="generate_<?php echo $prefix; ?>id()">
    </div>

    <div style="margin-top:5px; padding:10px; background:#f9fafb; border:1px solid #d1d5db; border-radius:4px;">
        최종 식별코드(ID): <strong id="<?php echo $id_display_id; ?>" style="color:#2563eb; font-size:1.1em;"><?php echo $tm_id; ?></strong>
        <input type="hidden" name="<?php echo $id_input_id; ?>" id="<?php echo $id_input_id; ?>" value="<?php echo $tm_id; ?>">
        <p style="margin-top:5px; color:#6b7280; font-size:11px;">* 주의: 식별코드(ID) 변경 시 테마와의 연동 설정도 함께 확인해야 합니다.</p>
    </div>

    <script>
    if (typeof generate_<?php echo $prefix; ?>id !== "function") {
        window.generate_<?php echo $prefix; ?>id = function() {
            var theme = document.getElementById("<?php echo $prefix; ?>theme").value;
            var lang = document.getElementById("<?php echo $prefix; ?>lang").value;
            var custom = document.getElementById("<?php echo $prefix; ?>id_custom").value.trim().toLowerCase().replace(/[^a-z0-9_]/g, "");
            var id_field = document.getElementById("<?php echo $id_input_id; ?>");
            var display_field = document.getElementById("<?php echo $id_display_id; ?>");
            if (theme) {
                var new_id = theme;
                if (lang && lang !== "kr") { new_id += "_" + lang; }
                if (custom) { new_id += "_" + custom; }
                id_field.value = new_id;
                display_field.innerText = new_id;
            } else {
                id_field.value = "";
                display_field.innerText = "(테마를 선택하세요)";
            }
            if (typeof sync_menu_table_info === "function") sync_menu_table_info();
        };
    }
    </script>
    <?php
    return ob_get_clean();
}

/**
 * 프리미엄 메인 비주얼 출력 함수 (효과 및 오버레이 자동 연동)
 */
function display_hero_visual($mi_id, $options = array()) {
    global $g5, $hero_config;
    
    // DB에서 관리자가 설정한 프리미엄 옵션 가져오기
    $config_table = G5_TABLE_PREFIX . "plugin_main_image_config";
    $mi = sql_fetch("select mi_effect, mi_overlay from {$config_table} where mi_id = '{$mi_id}'");
    
    // 기본 옵션 (DB 설정 우선, 없을 경우 기본값)
    $db_effect = (isset($mi['mi_effect']) && $mi['mi_effect']) ? $mi['mi_effect'] : 'zoom';
    $db_overlay = (isset($mi['mi_overlay'])) ? (float)$mi['mi_overlay'] : 0.4;

    $default_options = array(
        'effect' => $db_effect,
        'overlay' => $db_overlay,
        'height' => '100vh',
        'full_width' => true
    );
    
    // 함수 호출 시 전달된 옵션이 있으면 덮어씌움
    $hero_config = array_merge($default_options, $options);
    
    // Wrapper provides root height to ensure layout consistency
    echo '<div class="hero-section-wrapper" style="height: '.$hero_config['height'].';">';
    if (function_exists('display_main_visual')) {
        display_main_visual($mi_id);
    } else {
        echo "<!-- display_main_visual function not found. -->";
    }
    echo '</div>';
}
