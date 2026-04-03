<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * 특정 섹션의 아이템 리스트 가져오기
 */
function get_main_content_list($ms_id)
{
    global $config;
    $list = array();
    $sql = " select * from g5_plugin_main_content where ms_id = '{$ms_id}' order by mc_sort asc ";
    $result = sql_query($sql);
    
    $theme_name = isset($config['cf_theme']) ? $config['cf_theme'] : 'default';

    while ($row = sql_fetch_array($result)) {
        if ($row['mc_image']) {
            // [ENVIRONMENT AGNOSTIC] Normalize localhost URLs or relative paths
            $raw_img = $row['mc_image'];

            // 1. If it's a localhost URL, strip it to make it relative
            if (preg_match("/^https?:\/\/localhost/i", $raw_img)) {
                $parts = explode('/common_assets/', $raw_img);
                if (count($parts) > 1) {
                    $raw_img = $parts[1]; // Result: "theme_name/filename.jpg"
                }
            }

            // 2. Final URL generation
            if (preg_match("/^(http|https):/i", $raw_img)) {
                $row['img_url'] = $raw_img;
            } else {
                // Ensure theme_name is included in the path
                if (strpos($raw_img, '/') === false) {
                    // Just a filename, prepend theme
                    $row['img_url'] = G5_DATA_URL . '/common_assets/' . $theme_name . '/' . $raw_img;
                } else {
                    // Already contains theme/filename or subfolder
                    $row['img_url'] = G5_DATA_URL . '/common_assets/' . $raw_img;
                }
            }
        } else {
            $row['img_url'] = '';
        }
        $list[] = $row;
    }
    return $list;
}

/**
 * 스킨별 권장 이미지 사이즈 및 정보 반환
 */
function get_mc_skin_info($skin) {
    $info = array(
        'A' => array('width' => 800, 'height' => 600, 'label' => 'Style A (Default)'),
        'B' => array('width' => 1200, 'height' => 600, 'label' => 'Style B (Wide)'),
        'C' => array('width' => 800, 'height' => 600, 'label' => 'Style C (Simple)'),
        'D' => array('width' => 800, 'height' => 1000, 'label' => 'Style D (Modern List)'),
        'philosophy_light' => array('width' => 1000, 'height' => 600, 'label' => 'Philosophy Light'),
        'works_dark' => array('width' => 1200, 'height' => 800, 'label' => 'Works Dark Style'),
    );

    return isset($info[$skin]) ? $info[$skin] : array('width' => 800, 'height' => 600, 'label' => $skin);
}

/**
 * 메인 페이지에 활성화된 모든 섹션 출력
 * @param string $lang 언어 코드 (kr, en, jp, cn)
 */
function display_main_content($lang = 'kr')
{
    global $g5;

    if (!$lang)
        $lang = 'kr';

    // [Standardization Fallback] Handle kr/ko/empty as equivalent for Korean default
    $lang_condition = ($lang == 'kr') ? " (ms_lang = 'kr' or ms_lang = 'ko' or ms_lang = '') " : " ms_lang = '{$lang}' ";

    $sql = " select * from g5_plugin_main_content_sections where ms_active = '1' and {$lang_condition} order by ms_sort asc, ms_id asc ";
    $result = sql_query($sql);

    while ($ms = sql_fetch_array($result)) {
        render_main_section($ms);
    }
}

/**
 * 개별 섹션 렌더링 함수
 */
function render_main_section($ms)
{
    global $g5, $config;

    $ms_id = $ms['ms_id'];
    $style = $ms['ms_skin'];
    $items = get_main_content_list($ms_id);
    $section_title = $ms['ms_title'];
    $section_subtitle = isset($ms['ms_subtitle']) ? $ms['ms_subtitle'] : '';
    $show_title = $ms['ms_show_title'];

    // [THEME SOVEREIGNTY] Use CSS variables from the theme
    $accent_color = (isset($ms['ms_accent_color']) && $ms['ms_accent_color']) ? $ms['ms_accent_color'] : 'var(--color-accent-gold)';
    $font_family = "var(--font-heading)";

    // Skin Path
    $skin_path = G5_PLUGIN_PATH . '/main_content_manager/skins/' . $style;
    $skin_url = G5_PLUGIN_URL . '/main_content_manager/skins/' . $style;
    $skin_file = $skin_path . '/main.skin.php';
    $css_file = $skin_path . '/style.css';

    // Inject unique CSS variables for this section
    echo '<style>
        #main_section_' . $ms_id . ' {
            --mc-accent: ' . $accent_color . ';
            --mc-font-heading: ' . $font_family . ';
        }
    </style>';

    // [Background Color]
    $bg_style = '';
    if (isset($ms['ms_bg_color']) && $ms['ms_bg_color']) {
        $bg_style = 'style="background-color: ' . $ms['ms_bg_color'] . ';"';
    }

    echo '<div id="main_section_' . $ms_id . '" class="main-content-section-wrapper ' . str_replace('_', '-', $style) . '" ' . $bg_style . '>';

    if (file_exists($skin_file)) {
        if (file_exists($css_file)) {
            echo '<link rel="stylesheet" href="' . $skin_url . '/style.css?v=' . time() . '">';
        }
        include($skin_file);
    } else {
        echo "<!-- Main Content Skin not found: {$style} -->";
    }

    echo '</div>';
}