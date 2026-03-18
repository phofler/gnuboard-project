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

/**
 * 스킨 선택 UI 생성 공통 함수 (카드형 지원)
 */
function get_skin_select_ui($params = array()) {
    $name = isset($params['name']) ? $params['name'] : 'skin';
    $selected = isset($params['selected']) ? $params['selected'] : '';
    $skins_dir = isset($params['skins_dir']) ? $params['skins_dir'] : '';
    $onclick = isset($params['onclick']) ? $params['onclick'] : '';
    $mapping = isset($params['mapping']) ? $params['mapping'] : array();
    $priority = isset($params['priority']) ? $params['priority'] : array();

    if (!$skins_dir || !is_dir($skins_dir)) return "<!-- Skins directory not found: {$skins_dir} -->";

    $skins = array();
    $dirs = dir($skins_dir);
    while (false !== ($entry = $dirs->read())) {
        if ($entry == "." || $entry == "..") continue;
        if (is_dir($skins_dir . "/" . $entry)) {
            $skin_info_file = $skins_dir . "/" . $entry . "/skin_info.php";
            $disp_name = isset($mapping[$entry]) ? $mapping[$entry] : $entry;
            $disp_desc = "";
            $rec_size = "";

            if (file_exists($skin_info_file)) {
                include($skin_info_file);
                if (isset($skin_info['name'])) $disp_name = $skin_info['name'];
                if (isset($skin_info['desc'])) $disp_desc = $skin_info['desc'];
                if (isset($skin_info['rec_size'])) $rec_size = $skin_info['rec_size'];
            }

            $skins[$entry] = array(
                'id' => $entry,
                'name' => $disp_name,
                'desc' => $disp_desc,
                'rec_size' => $rec_size
            );
        }
    }
    $dirs->close();

    // Sort by priority
    if (!empty($priority)) {
        $sorted = array();
        foreach ($priority as $p_id) {
            if (isset($skins[$p_id])) {
                $sorted[$p_id] = $skins[$p_id];
                unset($skins[$p_id]);
            }
        }
        $skins = array_merge($sorted, $skins);
    } else {
        ksort($skins);
    }

    ob_start();
    ?>
    <style>
        .skin-selection-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 15px; margin-top: 10px; }
        .skin-card { position: relative; border: 2px solid #e5e7eb; border-radius: 10px; padding: 15px; cursor: pointer; transition: all 0.2s; background: #fff; }
        .skin-card:hover { border-color: #3b82f6; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .skin-card.active { border-color: #2563eb; background: #eff6ff; }
        .skin-card input[type="radio"] { position: absolute; opacity: 0; }
        .skin-name { font-weight: 700; color: #111827; display: block; margin-bottom: 4px; font-size: 14px; }
        .skin-desc { font-size: 12px; color: #6b7280; line-height: 1.4; display: block; }
        .skin-rec-size { margin-top: 8px; font-size: 11px; font-weight: 600; color: #ef4444; }
        .skin-badge { position: absolute; top: 10px; right: 10px; width: 20px; height: 20px; border-radius: 50%; border: 2px solid #d1d5db; display: flex; align-items: center; justify-content: center; }
        .skin-card.active .skin-badge { border-color: #2563eb; background: #2563eb; }
        .skin-card.active .skin-badge::after { content: ""; width: 8px; height: 8px; background: #fff; border-radius: 50%; }
    </style>

    <div class="skin-selection-grid">
        <?php foreach ($skins as $skin_id => $skin) { 
            $is_active = ($skin_id === $selected);
            ?>
            <label class="skin-card <?php echo $is_active ? 'active' : ''; ?>" onclick="select_skin_card('<?php echo $skin_id; ?>', '<?php echo $name; ?>', '<?php echo $onclick; ?>')">
                <input type="radio" name="<?php echo $name; ?>" value="<?php echo $skin_id; ?>" <?php echo $is_active ? 'checked' : ''; ?>>
                <span class="skin-badge"></span>
                <span class="skin-name"><?php echo $skin['name']; ?></span>
                <span class="skin-desc"><?php echo $skin['desc']; ?></span>
                <?php if ($skin['rec_size']) { ?>
                    <span class="skin-rec-size">권장: <?php echo $skin['rec_size']; ?></span>
                <?php } ?>
            </label>
        <?php } ?>
    </div>

    <script>
        function select_skin_card(skin_id, input_name, callback) {
            var grid = document.querySelector('.skin-selection-grid');
            var cards = grid.querySelectorAll('.skin-card');
            cards.forEach(function(c) { c.classList.remove('active'); });
            
            var selectedCard = event.currentTarget;
            selectedCard.classList.add('active');
            selectedCard.querySelector('input').checked = true;

            if (callback && typeof window[callback] === 'function') {
                window[callback](skin_id);
            }
        }
    </script>
    <?php
    return ob_get_clean();
}

/**
 * 프리미엄 미니 웹 에디터 UI 생성 공통 함수
 */
function get_premium_editor_ui($params = array()) {
    $id = isset($params['id']) ? $params['id'] : 'editor_' . uniqid();
    $name = isset($params['name']) ? $params['name'] : 'desc';
    $value = isset($params['value']) ? $params['value'] : '';
    $class = isset($params['class']) ? $params['class'] : 'frm_input';
    $height = isset($params['height']) ? $params['height'] : '100px';
    $placeholder = isset($params['placeholder']) ? $params['placeholder'] : '내용을 입력하세요...';

    ob_start();
    ?>
    <div class="premium-editor-container" id="container_<?php echo $id; ?>">
        <div class="premium-editor-toolbar">
            <button type="button" class="pe-btn" onclick="apply_pe_style('<?php echo $id; ?>', 'bold')" title="두껍게"><strong>B</strong></button>
            <div class="pe-divider"></div>
            <button type="button" class="pe-btn pe-size" onclick="apply_pe_style('<?php echo $id; ?>', 'size', '1.25em')" title="글자 크게" style="font-size:13px; font-weight:bold;">T+</button>
            <button type="button" class="pe-btn pe-size" onclick="apply_pe_style('<?php echo $id; ?>', 'size', '0.85em')" title="글자 작게" style="font-size:10px;">T-</button>
            <div class="pe-divider"></div>
            <button type="button" class="pe-btn pe-color" style="color:#d4af37;" onclick="apply_pe_style('<?php echo $id; ?>', 'color', 'var(--color-accent-gold, #d4af37)')" title="골드">●</button>
            <button type="button" class="pe-btn pe-color" style="color:#ff3b30;" onclick="apply_pe_style('<?php echo $id; ?>', 'color', '#ff3b30')" title="레드">●</button>
            <div class="pe-divider"></div>
            <button type="button" class="pe-btn pe-reset" onclick="apply_pe_style('<?php echo $id; ?>', 'reset')" title="스타일 초기화" style="font-size:14px;">↺</button>
        </div>
        <textarea name="<?php echo $name; ?>" id="<?php echo $id; ?>" class="<?php echo $class; ?> premium-editor-textarea" style="height:<?php echo $height; ?>;" placeholder="<?php echo $placeholder; ?>"><?php echo $value; ?></textarea>
    </div>

    <?php if (!defined('PREMIUM_EDITOR_STYLING_DONE')) { define('PREMIUM_EDITOR_STYLING_DONE', true); ?>
    <style>
        .premium-editor-container { border: 1px solid #ddd; border-radius: 4px; overflow: hidden; background: #fff; margin-bottom: 5px; transition: border-color 0.2s; }
        .premium-editor-container:focus-within { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
        .premium-editor-toolbar { background: #f8f9fa; padding: 6px 10px; border-bottom: 1px solid #eee; display: flex; gap: 5px; align-items: center; }
        .pe-btn { background: #fff; border: 1px solid #ddd; padding: 0 8px; border-radius: 3px; font-size: 11px; cursor: pointer; color: #555; display: flex; align-items: center; justify-content: center; min-width: 30px; height: 26px; transition: all 0.2s; line-height: 1; }
        .pe-btn:hover { background: #f0f0f0; border-color: #bbb; color: #000; }
        .pe-divider { width: 1px; height: 16px; background: #ddd; margin: 0 5px; }
        .premium-editor-textarea { width: 100%; border: none !important; padding: 12px; font-size: 14px; line-height: 1.6; resize: vertical; box-sizing: border-box; }
        .premium-editor-textarea:focus { outline: none; background: #fafafa; }
    </style>
    <script>
        function apply_pe_style(id, type, val) {
            var el = document.getElementById(id);
            if (!el) return;
            var start = el.selectionStart;
            var end = el.selectionEnd;
            var txt = el.value;
            var sel = txt.substring(start, end);
            
            if (!sel && type !== 'reset') {
                alert('스타일을 적용할 텍스트를 드래그하여 선택해주세요.');
                return;
            }

            var rep = '';
            if (type === 'bold') rep = '<strong>' + sel + '</strong>';
            else if (type === 'size') rep = '<span style="font-size:' + val + ';">' + sel + '</span>';
            else if (type === 'color') rep = '<span style="color:' + val + ';">' + sel + '</span>';
            else if (type === 'reset') {
                if(confirm('모든 스타일(HTML 태그)을 제거하고 일반 텍스트로 초기화하시겠습니까?')) {
                    el.value = txt.replace(/<[^>]*>/g, '');
                    return;
                }
                return;
            }

            el.value = txt.substring(0, start) + rep + txt.substring(end);
            el.focus();
            setTimeout(function() {
                el.setSelectionRange(start, start + rep.length);
            }, 10);
        }
    </script>
    <?php } ?>
    <?php
    return ob_get_clean();
}

/**
 * 레이아웃 선택 UI 생성 공통 함수 (Full Width / Sidebar 선택형)
 */
function get_layout_select_ui($params = array()) {
    $name = isset($params['name']) ? $params['name'] : 'sd_layout';
    $selected = isset($params['selected']) ? $params['selected'] : 'full';
    $onchange = isset($params['onchange']) ? $params['onchange'] : '';
    
    $options = isset($params['options']) ? $params['options'] : array(
        'full' => array(
            'title' => 'Full Width',
            'desc' => '와이드 레이아웃 (갤러리, 제품 리스트 등)',
            'info' => ''
        ),
        'sidebar' => array(
            'title' => 'Sidebar (LNB)',
            'desc' => '좌측 사이드바 + 에지 바 적용',
            'info' => '서브페이지 좌측에 메뉴가 생성되며, 헤더에 에지 바(수직선)가 강제 적용됩니다.'
        )
    );

    ob_start();
    ?>
    <div class="layout-selection-container" style="display:flex; gap:20px;">
        <?php foreach ($options as $val => $opt) { 
            $is_active = ($val === $selected || (!$selected && $val === 'full'));
            ?>
            <label style="cursor:pointer; display:flex; align-items:center; gap:8px;">
                <input type="radio" name="<?php echo $name; ?>" value="<?php echo $val; ?>" <?php echo $is_active ? "checked" : ""; ?> onchange="<?php echo $onchange; ?>">
                <div style="padding:10px 20px; border:1px solid <?php echo $is_active ? '#3498db' : '#ddd'; ?>; border-radius:4px; background:<?php echo $is_active ? '#f0f7ff' : '#fff'; ?>; transition: all 0.2s;">
                    <strong style="display:block; color:<?php echo $is_active ? '#2980b9' : '#333'; ?>;"><?php echo $opt['title']; ?></strong>
                    <span style="display:block; font-size:11px; color:<?php echo $val === 'sidebar' ? '#c0392b' : '#777'; ?>; font-weight:<?php echo $val === 'sidebar' ? 'bold' : 'normal'; ?>;"><?php echo $opt['desc']; ?></span>
                </div>
            </label>
        <?php } ?>
    </div>
    <?php if ($selected === 'sidebar' && isset($options['sidebar']['info'])) { ?>
        <p class="frm_info" style="margin-top:10px;"><?php echo $options['sidebar']['info']; ?></p>
    <?php } else if (isset($options['full']['info']) && $options['full']['info']) { ?>
        <p class="frm_info" style="margin-top:10px;"><?php echo $options['full']['info']; ?></p>
    <?php } ?>
    <?php
    return ob_get_clean();
}