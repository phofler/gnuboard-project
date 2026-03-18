<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * 현재 환경에 맞는 서브 디자인 식별값(ID) 반환
 */
function get_current_sub_design_id() {
    global $config;
    
    $theme = '';
    
    // 1. 테마에서 명시적으로 정의한 고유 ID (최우선)
    if (defined('_THEME_PREMIUM_ID_')) {
        $theme = _THEME_PREMIUM_ID_;
    } 
    // 2. 관리자 설정의 현재 테마 이름 (GnuBoard 표준)
    else if (isset($config['cf_theme']) && $config['cf_theme'] && !is_array($config['cf_theme'])) {
        $theme = trim($config['cf_theme']);
    }
    // 3. (구 방식) G5_THEME_DEVICE가 'both', 'pc', 'mobile'이 아닌 경우에만 테마명으로 간주
    else if (defined('G5_THEME_DEVICE') && G5_THEME_DEVICE && !in_array(G5_THEME_DEVICE, array('both', 'pc', 'mobile'))) {
        $theme = G5_THEME_DEVICE;
    }
    
    // Fallback to kukdong_panel if still empty
    if (!$theme) $theme = 'kukdong_panel';

    $lang = (defined('_THEME_LANG_')) ? _THEME_LANG_ : 'kr';
    $sd_id = $theme;
    if ($lang != 'kr') $sd_id .= '_' . $lang;
    
    return $sd_id;
}

/**
 * 서브 디자인 정보 가져오기 (테마/언어 연동)
 */
function get_sub_design($sd_id = '', $me_code = '') {
    global $g5;

    if (!$sd_id) $sd_id = get_current_sub_design_id();

    // 1. 서브 디자인 그룹 찾기
    $sql = " SELECT * FROM " . G5_TABLE_PREFIX . "plugin_sub_design_groups WHERE sd_id = '{$sd_id}' ";
    $sd = sql_fetch($sql);

    if (!$sd) return array();

    // 2. 현재 메뉴 코드 찾기
    if (!$me_code) $me_code = get_active_menu_code();
    
    if (!$me_code) return $sd;

    // 3. 해당 메뉴의 세부 설정 가져오기
    $sql_item = " SELECT * FROM " . G5_TABLE_PREFIX . "plugin_sub_design_items 
                  WHERE sd_id = '{$sd['sd_id']}' AND me_code = '{$me_code}' ";
    $item = sql_fetch($sql_item);

    // 4. 상위 메뉴 상속 (Fallback)
    if (!$item && strlen($me_code) > 2) {
        $parent_code = substr($me_code, 0, 2);
        $sql_parent = " SELECT * FROM " . G5_TABLE_PREFIX . "plugin_sub_design_items 
                        WHERE sd_id = '{$sd['sd_id']}' AND me_code = '{$parent_code}' ";
        $item = sql_fetch($sql_parent);
    }

    $res = array_merge($sd, (array)$item);
    $res['active_me_code'] = $me_code;
    
    return $res;
}

/**
 * 현재 활성화된 메뉴 코드 반환 (커스텀 메뉴 테이블 대응)
 */
function get_active_menu_code() {
    global $g5, $bo_table, $co_id;
    
    if (isset($_GET['me_code']) && $_GET['me_code']) return clean_xss_tags($_GET['me_code']);

    $menu_table = $g5['menu_table'];
    $code_col = 'me_code';
    $link_col = 'me_link';
    
    if (defined('G5_PRO_MENU_TABLE')) {
        $menu_table = G5_PRO_MENU_TABLE;
        $code_col = 'ma_code';
        $link_col = 'ma_link';
    }

    if ($bo_table) {
        $row = sql_fetch(" SELECT $code_col as code FROM $menu_table WHERE $link_col LIKE '%bo_table={$bo_table}%' AND me_use = '1' ORDER BY LENGTH($code_col) DESC LIMIT 1 ");
        if ($row) return $row['code'];
    }
    
    if ($co_id) {
        $row = sql_fetch(" SELECT $code_col as code FROM $menu_table WHERE $link_col LIKE '%co_id={$co_id}%' AND me_use = '1' ORDER BY LENGTH($code_col) DESC LIMIT 1 ");
        if ($row) return $row['code'];
    }

    $cur_url = $_SERVER['PHP_SELF'];
    $qstr = $_SERVER['QUERY_STRING'];
    $search_url = basename($cur_url);
    if ($qstr) $search_url .= '?' . $qstr;
    
    $row = sql_fetch(" SELECT $code_col as code FROM $menu_table WHERE $link_col LIKE '%{$search_url}%' AND me_use = '1' ORDER BY LENGTH($code_col) DESC LIMIT 1 ");
    if ($row) return $row['code'];

    $row = sql_fetch(" SELECT $code_col as code FROM $menu_table WHERE $link_col LIKE '%".basename($cur_url)."%' AND me_use = '1' ORDER BY LENGTH($code_col) DESC LIMIT 1 ");
    if ($row) return $row['code'];

    return '';
}

/**
 * 브레드크럼(LNB) 출력
 */
function display_breadcrumb($sd = array()) {
    global $g5, $config;
    if (empty($sd)) $sd = get_sub_design();
    if (empty($sd) || !$sd['sd_breadcrumb']) return;

    $skin = $sd['sd_breadcrumb_skin'] ?: 'dropdown';
    $active_me_code = $sd['active_me_code'];
    $skin_path = dirname(__FILE__) . '/../breadcrumb_skins/' . $skin . '/main.skin.php';
    
    if (file_exists($skin_path)) include($skin_path);
}

/**
 * 서브 비주얼 (Hero) 출력
 */
function display_sub_visual($sd = array()) {
    global $g5, $config;
    if (empty($sd)) $sd = get_sub_design();
    if (empty($sd)) return;

    $sd_skin = isset($sd['sd_skin']) ? $sd['sd_skin'] : 'standard';
    $skin_path = dirname(__FILE__) . '/../skins/' . $sd_skin . '/main.skin.php';

    $item = $sd;
    if (empty($item['sd_main_text'])) $item['sd_main_text'] = $g5['title'];
    
    if (file_exists($skin_path)) {
        include($skin_path);
    } else {
        $sd_img_url = get_sub_design_image_url($sd);
        if (!$sd_img_url) $sd_img_url = G5_THEME_URL . '/img/sub_bg_default.jpg';
        ?>
        <section class="subTitleArea">
            <div class="subTitleBg" style="background-image: url('<?php echo $sd_img_url; ?>');">
                <div class="container" style="text-align:center;">
                    <div class="subTitleTxt">
                        <h2 class="title" style="font-size:3rem; font-weight:800; color:#fff; text-transform:uppercase;"><?php echo $item['sd_main_text']; ?></h2>
                        <?php if (isset($item['sd_sub_text']) && $item['sd_sub_text']) { ?>
                            <p class="subtitle" style="color:rgba(255,255,255,0.8); margin-top:10px;"><?php echo $item['sd_sub_text']; ?></p>
                        <?php } ?>
                        <div style="margin-top:20px;">
                            <?php display_breadcrumb($sd); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

/**
 * 서브 디자인 이미지 URL 반환
 */
function get_sub_design_image_url($item) {
    if (!$item) return '';
    $url = isset($item['sd_visual_url']) ? $item['sd_visual_url'] : '';
    if (!$url && isset($item['sd_visual_img']) && $item['sd_visual_img']) {
        $url = G5_DATA_URL . '/sub_visual/' . $item['sd_visual_img'];
    }
    if ($url && !preg_match("/^(http|https):/i", $url)) {
        $url = G5_DATA_URL . '/sub_visual/' . $url;
    }
    return $url;
}
?>