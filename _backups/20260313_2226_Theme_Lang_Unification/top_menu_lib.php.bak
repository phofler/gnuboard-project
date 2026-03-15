<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * 상단 메뉴 매니저 공통 라이브러리
 */

/**
 * 설정 대상 (Theme & Lang) 관리 UI 생성 함수
 * - 관리자 작성/수정 페이지에서 공통으로 사용
 */
function get_top_menu_setting_ui($tm = array()) {
    global $g5;
    
    // 테마 목록 가져오기
    $themes = array();
    $theme_dir = G5_PATH . '/theme';
    if (is_dir($theme_dir)) {
        $dirs = dir($theme_dir);
        while (false !== ($entry = $dirs->read())) {
            if ($entry == '.' || $entry == '..') continue;
            if (is_dir($theme_dir . '/' . $entry)) {
                $themes[] = $entry;
            }
        }
        $dirs->close();
    }
    sort($themes);

    $tm_theme = isset($tm['tm_theme']) ? $tm['tm_theme'] : '';
    $tm_lang = isset($tm['tm_lang']) ? $tm['tm_lang'] : 'kr';
    $tm_custom = isset($tm['tm_custom']) ? $tm['tm_custom'] : '';
    $tm_id = isset($tm['tm_id']) ? $tm['tm_id'] : '';

    ob_start();
    ?>
    <div style="display:flex; gap:10px; align-items:center;">
        <!-- 테마 선택 -->
        <select name="tm_theme" id="tm_theme" class="frm_input" onchange="generate_tm_id()" required>
            <option value="">테마 선택</option>
            <?php foreach ($themes as $theme) {
                $selected = ($theme == $tm_theme) ? 'selected' : '';
                echo '<option value="' . $theme . '" ' . $selected . '>' . $theme . '</option>';
            } ?>
        </select>

        <!-- 언어 선택 -->
        <select name="tm_lang" id="tm_lang" class="frm_input" onchange="generate_tm_id()" required>
            <option value="">언어 선택</option>
            <option value="kr" <?php echo ($tm_lang == 'kr') ? 'selected' : ''; ?>>한국어 (KR)</option>
            <option value="en" <?php echo ($tm_lang == 'en') ? 'selected' : ''; ?>>English (EN)</option>
            <option value="jp" <?php echo ($tm_lang == 'jp') ? 'selected' : ''; ?>>Japanese (JP)</option>
            <option value="cn" <?php echo ($tm_lang == 'cn') ? 'selected' : ''; ?>>Chinese (CN)</option>
        </select>

        <!-- 커스텀 접미사 -->
        <input type="text" name="tm_id_custom" id="tm_id_custom" value="<?php echo $tm_custom; ?>"
            class="frm_input" style="width:150px;" placeholder="커스텀 이름 (선택)"
            onkeyup="generate_tm_id()">
    </div>

    <div style="margin-top:5px; padding:10px; background:#f9fafb; border:1px solid #d1d5db; border-radius:4px;">
        최종 식별코드(ID): <strong id="display_tm_id" style="color:#2563eb; font-size:1.1em;"><?php echo $tm_id; ?></strong>
        <input type="hidden" name="tm_id" id="tm_id" value="<?php echo $tm_id; ?>">
        <p style="margin-top:5px; color:#6b7280; font-size:11px;">* 주의: 식별코드(ID) 변경 시 테마와의 연동 설정도 함께 확인해야 합니다.</p>
    </div>

    <script>
    function generate_tm_id() {
        var theme = document.getElementById('tm_theme').value;
        var lang = document.getElementById('tm_lang').value;
        var custom = document.getElementById('tm_id_custom').value.trim().toLowerCase().replace(/[^a-z0-9_]/g, '');
        
        var id_field = document.getElementById('tm_id');
        var display_field = document.getElementById('display_tm_id');

        if (theme) {
            var new_id = theme;
            if (lang && lang !== 'kr') {
                new_id += '_' + lang;
            }
            if (custom) {
                new_id += '_' + custom;
            }
            id_field.value = new_id;
            display_field.innerText = new_id;
        } else {
            id_field.value = '';
            display_field.innerText = '(테마를 선택하세요)';
        }
    }
    </script>
    <?php
    $html = ob_get_clean();
    return $html;
}

/**
 * 상단 메뉴 출력 함수 (테마에서 호출)
 */
function display_top_menu()
{
    global $g5, $is_member, $is_admin, $config;

    $plugin_path = G5_PLUGIN_PATH . '/top_menu_manager';
    $skins_path = $plugin_path . '/skins';

    // 1. 설정 식별코드(ID) 결정
    // G5_TOP_MENU_ID 상수가 정의되어 있으면 우선 사용, 없으면 현재 테마명 사용
    $tm_id = defined('G5_TOP_MENU_ID') ? G5_TOP_MENU_ID : (isset($config['cf_theme']) ? trim($config['cf_theme']) : 'kukdong_panel');

    // 다국어 처리 (익스텐션 라이브러리 설정을 따름)
    if (defined('G5_LANG') && G5_LANG != 'kr' && !defined('G5_TOP_MENU_ID')) {
        $tm_id .= '_' . G5_LANG;
    }

    // 2. DB에서 설정 로드
    $tm = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");

    // 명시적인 테마명으로 재시도 (fallback)
    if (!$tm && isset($config['cf_theme'])) {
        $fallback_id = trim($config['cf_theme']);
        $tm = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$fallback_id}' ");
    }

    if ($tm) {
        $top_menu_skin = $tm['tm_skin'] ? $tm['tm_skin'] : 'basic';

        // Pro Menu Manager 테이블 정의
        if ($tm['tm_menu_table'] && !defined('G5_PRO_MENU_TABLE')) {
            define('G5_PRO_MENU_TABLE', 'g5_write_menu_pdc_' . $tm['tm_menu_table']);
        }

        // 로고 전역 변수 설정 (스킨에서 사용)
        $top_logo_pc = $tm['tm_logo_pc'] ? G5_DATA_URL . '/common/' . $tm['tm_logo_pc'] : '';
        $top_logo_mo = $tm['tm_logo_mo'] ? G5_DATA_URL . '/common/' . $tm['tm_logo_mo'] : '';

    } else {
        $top_menu_skin = 'basic';
    }

    $skin_path = $skins_path . '/' . $top_menu_skin;
    $skin_url = G5_PLUGIN_URL . '/top_menu_manager/skins/' . $top_menu_skin;

    if (!file_exists($skin_path . '/menu.skin.php')) {
        return;
    }

    // 메뉴 데이터 추출 (Pro Menu Manager 연동)
    $menu_datas = array();
    $pro_menu_lib = G5_PLUGIN_PATH . '/pro_menu_manager/lib.php';
    if (file_exists($pro_menu_lib)) {
        include_once($pro_menu_lib);

        if (function_exists('get_pro_menu_list') && function_exists('build_pro_menu_tree')) {
            $raw_menus = get_pro_menu_list();
            $menu_tree = build_pro_menu_tree($raw_menus);

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

    // 스킨 스타일 로드
    if (file_exists($skin_path . '/style.css')) {
        echo '<link rel="stylesheet" href="' . $skin_url . '/style.css?ver=' . G5_TIME_YMDHIS . '">' . PHP_EOL;
    }

    include($skin_path . '/menu.skin.php');
}
?>