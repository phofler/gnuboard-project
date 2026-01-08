<?php
if (!defined('_GNUBOARD_'))
    exit;

// 특정 섹션의 아이템 리스트 가져오기
function get_main_content_list($ms_id)
{
    $list = array();
    $sql = " select * from g5_plugin_main_content where ms_id = '{$ms_id}' order by mc_sort asc ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result)) {
        if ($row['mc_image']) {
            if (preg_match("/^(http|https):/i", $row['mc_image'])) {
                $row['img_url'] = $row['mc_image'];
            } else {
                $row['img_url'] = G5_DATA_URL . '/common_assets/' . $row['mc_image'];
            }
        } else {
            $row['img_url'] = '';
        }
        $list[] = $row;
    }
    return $list;
}

// 메인 페이지에 활성화된 모든 섹션 출력
// 메인 페이지에 활성화된 모든 섹션 출력
function display_main_content($lang = 'kr')
{
    global $g5;

    // 언어 설정 기본값 (Fallback)
    if (!$lang)
        $lang = 'kr';

    $sql = " select * from g5_plugin_main_content_sections where ms_active = '1' and ms_lang = '{$lang}' order by ms_sort asc, ms_id asc ";
    $result = sql_query($sql);

    while ($ms = sql_fetch_array($result)) {
        render_main_section($ms);
    }
}

// 개별 섹션 렌더링 함수
function render_main_section($ms)
{
    global $g5;

    $ms_id = $ms['ms_id'];
    $style = $ms['ms_skin'];
    $items = get_main_content_list($ms_id);
    $section_title = $ms['ms_title'];
    $show_title = $ms['ms_show_title'];

    // [THEME SOVEREIGNTY] 테마 CSS 변수를 최우선으로 상속 (관리자 설정 불필요)
    $accent_color = 'var(--color-accent-gold)';
    $font_family = "var(--font-heading)";

    // Skin Path
    $skin_path = G5_PLUGIN_PATH . '/main_content_manager/skins/' . $style;
    $skin_url = G5_PLUGIN_URL . '/main_content_manager/skins/' . $style;
    $skin_file = $skin_path . '/main.skin.php';
    $css_file = $skin_path . '/style.css';

    // 섹션별 고유 CSS 변수 주입 (ID 기반)
    echo '<style>
        #main_section_' . $ms_id . ' {
            --mc-accent: ' . $accent_color . ';
            --mc-font-heading: ' . $font_family . ';
        }
        #main_section_' . $ms_id . ' .section-title {
            color: var(--mc-accent);
            font-family: var(--mc-font-heading);
            font-size: var(--mc-title-size, 2.5rem);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: center;
            margin-bottom: var(--mc-list-gap, 60px);
        }
        #main_section_' . $ms_id . ' .section-subtitle {
            color: var(--color-text-secondary, #666);
            font-size: 1.1rem;
            margin-top: 10px;
            font-weight: 400;
        }
    </style>';

    // [Background Color]
    $bg_style = '';
    if (isset($ms['ms_bg_color']) && $ms['ms_bg_color']) {
        $bg_style = 'style="background-color: ' . $ms['ms_bg_color'] . ';"';
    }

    echo '<div id="main_section_' . $ms_id . '" class="main-content-section-wrapper" ' . $bg_style . '>';

    // [New Standard] Load External Skin if it exists
    if (file_exists($skin_file)) {
        if (file_exists($css_file)) {
            add_stylesheet('<link rel="stylesheet" href="' . $skin_url . '/style.css?v=' . time() . '">', 0);
        }
        include($skin_file);
    } else {
        echo "<!-- Main Content Skin not found: {$style} -->";
    }

    echo '</div>';
}