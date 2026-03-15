<?php
if (!defined("_GNUBOARD_")) exit;

/**
 * 설정 대상 (Theme & Lang) 관리 UI 생성 공통 함수
 * - $params: prefix (tm_, mi_ 등), theme, lang, custom, id, id_display_id, id_input_id
 */
function get_theme_lang_select_ui($params = array()) {
    $prefix = isset($params["prefix"]) ? $params["prefix"] : "tm_";
    $tm_theme = isset($params["theme"]) ? $params["theme"] : "";
    $tm_lang = isset($params["lang"]) ? $params["lang"] : "kr";
    $tm_custom = isset($params["custom"]) ? $params["custom"] : "";
    $tm_id = isset($params["id"]) ? $params["id"] : "";
    
    // UI IDs
    $id_display_id = isset($params["id_display_id"]) ? $params["id_display_id"] : "display_".$prefix."id";
    $id_input_id = isset($params["id_input_id"]) ? $params["id_input_id"] : $prefix."id";

    // 테마 목록 가져오기
    $themes = array();
    $theme_dir = G5_PATH . "/theme";
    if (is_dir($theme_dir)) {
        $dirs = dir($theme_dir);
        while (false !== ($entry = $dirs->read())) {
            if ($entry == "." || $entry == "..") continue;
            if (is_dir($theme_dir . "/" . $entry)) {
                $themes[] = $entry;
            }
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
                if (lang && lang !== "kr") {
                    new_id += "_" + lang;
                }
                if (custom) {
                    new_id += "_" + custom;
                }
                id_field.value = new_id;
                display_field.innerText = new_id;
            } else {
                id_field.value = "";
                display_field.innerText = "(테마를 선택하세요)";
            }
            
            // Hook for external sync (e.g. Menu Table sync)
            if (typeof sync_menu_table_info === "function") sync_menu_table_info();
        };
    }
    </script>
    <?php
    return ob_get_clean();
}

/**
 * 프리미엄 메인 비주얼 출력 함수 (Full-width 및 효과 옵션 지원)
 * - $mi_id: 메인 비주얼 식별코드
 * - $options: array(
 *      'effect' => 'zoom|fade|none',
 *      'overlay' => 0.4,
 *      'height' => '100vh',
 *      'full_width' => true
 *   )
 */
function display_hero_visual($mi_id, $options = array()) {
    global $g5, $hero_config; // 스킨 파일에서 사용할 수 있도록 글로벌 변수로 전달
    
    // 기본 옵션 설정
    $default_options = array(
        'effect' => 'zoom',
        'overlay' => 0.4,
        'height' => '100vh',
        'full_width' => true
    );
    $hero_config = array_merge($default_options, $options);
    
    // [GnuBoard Structure Alignment]
    // 테마의 style.css 에서 .is-main #container 등의 너비를 100%로 리셋하므로 
    // 별도의 breakout wrapper 없이 바로 출력합니다.
    echo '<div class="hero-section-wrapper">';

    // 기존 플러그인 함수 호출
    if (function_exists('display_main_visual')) {
        display_main_visual($mi_id);
    } else {
        echo "<!-- display_main_visual function not found. Please check main_image_manager plugin. -->";
    }

    echo '</div>';
}