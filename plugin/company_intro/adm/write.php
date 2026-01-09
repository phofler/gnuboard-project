<?php
include_once('./_common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');
include_once(G5_EDITOR_LIB);
include_once(G5_PATH . '/lib/theme_css.lib.php');

$html_title = '회사소개';
$readonly = '';
if ($w == 'u') {
    $html_title .= ' 수정';
    $readonly = ' readonly';
    $co = sql_fetch(" select * from " . G5_TABLE_PREFIX . "plugin_company_add where co_id = '{$co_id}' ");
    if (!$co['co_id'])
        alert('등록된 자료가 없습니다.');
} else {
    $html_title .= ' 입력';
    // 기본 스킨(Type A) 내용 가져오기
    $default_skin_path = dirname(__FILE__) . '/../skin/type_a.html';
    $default_content = '';
    if (file_exists($default_skin_path)) {
        $default_content = file_get_contents($default_skin_path);
    }

    $co = array(
        'co_id' => '',
        'co_subject' => '',
        'co_content' => $default_content,
        'co_skin' => 'type_a',
        'co_bgcolor' => ''
    );
}

// [DYNAMIC THEME BG] Always prioritize ACTIVE SITE THEME for the "Absolute Default" reference
$theme_bg_default = get_theme_css_value($config['cf_theme'], array('--color-bg', '--color-bg-dark'), '#121212');
$theme_text_default = get_theme_css_value($config['cf_theme'], array('--color-text-primary'), '#e0e0e0');

$g5['title'] = $html_title;
include_once(G5_ADMIN_PATH . '/admin.head.php');
?>

<style>
    /* Unsplash Modal Styles */
    #unsplash_modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    #unsplash_modal_content {
        width: 98%;
        max-width: 1800px;
        height: 96%;
        max-height: 1200px;
        background: #fff;
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #unsplash_iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    /* [Editor Height Fix] 스마트에디터 초기 로딩 시 이 높이를 참조하도록 설정 */
    #co_content,
    #co_content_iframe {
        height: 1000px !important;
        min-height: 1000px !important;
    }

    .close-modal {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 24px;
        color: #333;
        cursor: pointer;
        z-index: 10000;
        width: 30px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
    }
</style>

<div id="unsplash_modal">
    <div id="unsplash_modal_content">
        <span class="close-modal" onclick="closeUnsplashModal()">&times;</span>
        <iframe id="unsplash_iframe" src=""></iframe>
    </div>
</div>

<!-- Image Picker Modal -->
<div id="img_picker_modal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:10000; justify-content:center; align-items:center;">
    <div
        style="background:#fff; width:600px; max-height:80%; padding:20px; border-radius:8px; display:flex; flex-direction:column;">
        <h3 style="margin:0 0 20px; font-size:18px; border-bottom:1px solid #eee; padding-bottom:10px;">교체할 이미지를 선택해주세요
        </h3>
        <div id="img_picker_list"
            style="flex:1; overflow-y:auto; display:grid; grid-template-columns:repeat(2, 1fr); gap:15px;">
            <!-- Thumbnails will go here -->
        </div>
        <div style="margin-top:20px; text-align:right;">
            <button type="button" class="btn btn_02" onclick="$('#img_picker_modal').hide();">취소</button>
        </div>
    </div>
</div>

<style>
    .img-picker-item {
        cursor: pointer;
        border: 2px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        position: relative;
        transition: all 0.2s;
    }

    .img-picker-item:hover {
        border-color: #d4af37;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .img-picker-item img {
        width: 100%;
        height: 150px;
        object-fit: contain;
        background: #f5f5f5;
        display: block;
    }

    .img-picker-info {
        padding: 8px;
        font-size: 12px;
        background: #fafafa;
        border-top: 1px solid #eee;
        color: #666;
        text-align: center;
    }
</style>

<form name="fcompanyform" id="fcompanyform" action="./write_update.php" onsubmit="return fcompanyform_submit(this);"
    method="post" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="old_co_id" value="<?php echo $co['co_id']; ?>">
    <input type="hidden" name="token" value="<?php echo get_admin_token(); ?>">

    <div class="tbl_frm01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?></caption>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <?php
                // Theme List
                $themes = array();
                $theme_dir = G5_PATH . '/theme';
                if (is_dir($theme_dir)) {
                    $handle = opendir($theme_dir);
                    while ($file = readdir($handle)) {
                        if ($file == "." || $file == ".." || !is_dir($theme_dir . "/" . $file))
                            continue;
                        $themes[] = $file;
                    }
                    closedir($handle);
                }

                // Standard Parsing Logic
                $sel_theme = isset($co['co_theme']) ? $co['co_theme'] : '';
                $sel_lang = isset($co['co_lang']) ? $co['co_lang'] : 'kr';
                $sel_custom = '';

                if ($w == 'u' && $co['co_id']) {
                    $parts = explode('_', $co['co_id']);
                    if (isset($parts[0]) && in_array($parts[0], $themes)) {
                        $sel_theme = $parts[0];
                        if (isset($parts[1]) && in_array($parts[1], array('kr', 'en', 'jp', 'cn'))) {
                            $sel_lang = $parts[1];
                            if (isset($parts[2])) {
                                array_shift($parts);
                                array_shift($parts);
                                $sel_custom = implode('_', $parts);
                            }
                        }
                    }
                }
                ?>
                <tr>
                    <th scope="row">설정 대상 (Theme & Lang)</th>
                    <td>
                        <div style="display:flex; gap:10px; align-items:center;">
                            <select name="co_theme" id="co_theme" class="frm_input" required
                                onchange="update_theme_defaults()">
                                <option value="">테마 선택</option>
                                <?php
                                $themes = array();
                                $theme_dir = G5_PATH . '/theme';
                                if (is_dir($theme_dir)) {
                                    $tdir = dir($theme_dir);
                                    while ($entry = $tdir->read()) {
                                        if ($entry == '.' || $entry == '..')
                                            continue;
                                        if (is_dir($theme_dir . '/' . $entry))
                                            $themes[] = $entry;
                                    }
                                    $tdir->close();
                                }
                                sort($themes);
                                foreach ($themes as $theme) {
                                    $selected = ($theme == $sel_theme) ? 'selected' : '';
                                    echo '<option value="' . $theme . '" ' . $selected . '>' . $theme . '</option>';
                                } ?>
                            </select>
                            <select name="co_lang" id="co_lang" class="frm_input" onchange="generate_co_id()">
                                <option value="kr" <?php echo ($sel_lang == 'kr' ? 'selected' : ''); ?>>한국어 (기본)</option>
                                <option value="en" <?php echo ($sel_lang == 'en' ? 'selected' : ''); ?>>English (EN)
                                </option>
                                <option value="jp" <?php echo ($sel_lang == 'jp' ? 'selected' : ''); ?>>Japanese (JP)
                                </option>
                                <option value="cn" <?php echo ($sel_lang == 'cn' ? 'selected' : ''); ?>>Chinese (CN)
                                </option>
                            </select>
                            <input type="text" name="co_custom" id="co_custom" value="<?php echo $sel_custom; ?>"
                                class="frm_input" placeholder="커스텀 이름 (선택)" onkeyup="generate_co_id()">
                        </div>
                        <div
                            style="margin-top:8px; font-size:12px; color:#666; padding:10px; background:#f9f9f9; border:1px solid #eee; display:inline-block;">
                            생성된 식별코드(ID): <strong id="generated_id_display"
                                style="color:#d4af37; font-size:1.1em;"><?php echo $co['co_id'] ? $co['co_id'] : '-'; ?></strong>
                        </div>
                        <p style="margin-top:5px; color:#888; font-size:12px;">테마와 언어를 선택하면 식별코드가 자동으로 생성됩니다. (예:
                            corporate_en_history)</p>
                        <input type="hidden" name="co_id" id="co_id" value="<?php echo $co['co_id']; ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="co_subject">제목</label></th>
                    <td>
                        <input type="text" name="co_subject" value="<?php echo $co['co_subject']; ?>" id="co_subject"
                            required class="frm_input" size="80">
                    </td>
                </tr>
                <tr>

                    <th scope="row">스킨 선택</th>
                    <td>
                        <?php if ($w == 'u') { ?>
                            <!-- 수정 모드: 현재 스킨 표시 (Premium Info Card) -->
                            <input type="hidden" name="co_skin" id="co_skin" value="<?php echo $co['co_skin']; ?>">
                            <div
                                style="padding:24px; background:linear-gradient(135deg, #f8f9fa 0%, #edf2f7 100%); border-radius:15px; border:2px solid #e2e8f0; display:flex; align-items:center; gap:25px; max-width:650px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                                <div
                                    style="width:70px; height:70px; background:linear-gradient(135deg, #3498db, #2980b9); border-radius:18px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:28px; box-shadow: 0 8px 15px rgba(52, 152, 219, 0.25);">
                                    <i class="fa fa-paint-brush"></i>
                                </div>
                                <div style="flex:1;">
                                    <div
                                        style="font-size:12px; color:#718096; margin-bottom:5px; font-weight:800; letter-spacing:1px; text-transform:uppercase;">
                                        Active Skin Configuration</div>
                                    <strong
                                        style="font-size:20px; color:#1a202c; display:block; margin-bottom:6px; letter-spacing:-0.5px;">
                                        <?php
                                        $skin_names = array(
                                            'type_a' => 'Type A (이미지 / 텍스트)',
                                            'type_a_1' => 'Type A-1 (CEO)',
                                            'type_a_2' => 'Type A-2 (비젼)',
                                            'type_b' => 'Type B (텍스트 / 이미지)',
                                            'type_b_1' => 'Type B-1 (CEO)',
                                            'type_b_2' => 'Type B-2 (비젼)',
                                            'type_c' => 'Type C (중앙정렬)',
                                            'type_c_1' => 'Type C-1 (CEO)',
                                            'type_c_2' => 'Type C-2 (비젼)',
                                            'history_photo' => '연혁 (포토)',
                                            'history_simple' => '연혁 (심플)',
                                            'history_timeline' => '연혁 (타임라인)',
                                            'performance_gallery' => '실적 (갤러리)',
                                            'performance_simple' => '실적 (심플)',
                                            'performance_timeline' => '실적 (타임라인)',
                                            'cert_a' => '인증서 (갤러리)',
                                            'cert_b' => '인증서 (심플)',
                                            'cert_c' => '인증서 (카드)',
                                            'org_a' => '조직도 A',
                                            'org_b' => '조직도 B',
                                            'biz_a' => '사업분야 A',
                                            'biz_b' => '사업분야 B',
                                            'biz_c' => '사업분야 C',
                                            'recruit_a' => '채용정보 A',
                                            'recruit_b' => '채용정보 B',
                                            'recruit_c' => '채용정보 C',
                                            'location' => '오시는 길 A',
                                            'location_c' => '오시는 길 C',
                                            'instinct' => 'Instinct (서브 히어로)',
                                            'overview' => 'Overview (회사 개요)',
                                            'team' => 'Team (임원진 소개)',
                                        );
                                        echo isset($skin_names[$co['co_skin']]) ? $skin_names[$co['co_skin']] : $co['co_skin'];
                                        ?>
                                    </strong>
                                    <p
                                        style="margin:0; font-size:12px; color:#a0aec0; display:flex; align-items:center; gap:5px;">
                                        <i class="fa fa-lock" style="font-size:10px;"></i> 컨텐츠 무결성을 위해 수정 모드에서는 스킨 변경이
                                        제한됩니다.
                                    </p>
                                </div>
                            </div>
                        <?php } else { ?>
                            <!-- 입력 모드: 카테고리별 프리미엄 카드 선택 -->
                            <style>
                                .skin-selector-container {
                                    display: grid;
                                    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                                    gap: 10px;
                                    margin-bottom: 25px;
                                }

                                .skin-card {
                                    border: 1px solid #e2e8f0;
                                    border-radius: 8px;
                                    padding: 6px 10px;
                                    cursor: pointer;
                                    transition: all 0.2s ease;
                                    background: #fff;
                                    display: flex;
                                    flex-direction: row;
                                    align-items: center;
                                    gap: 8px;
                                    min-height: 34px;
                                    position: relative;
                                }

                                .skin-card:hover {
                                    border-color: #3498db;
                                    background: #f8fafc;
                                }

                                .skin-card.active {
                                    border-color: #3498db;
                                    background: #f0f7ff;
                                }

                                .skin-card i {
                                    font-size: 18px;
                                    color: #cbd5e0;
                                    width: 24px;
                                    text-align: center;
                                    transition: color 0.3s;
                                }

                                .skin-card.active i {
                                    color: #3498db;
                                }

                                .skin-card .skin-name {
                                    font-size: 13px;
                                    font-weight: 600;
                                    color: #4a5568;
                                }

                                .skin-card.active .skin-name {
                                    color: #2b6cb0;
                                }

                                .skin-card .skin-badge {
                                    position: absolute;
                                    top: 50%;
                                    right: 12px;
                                    transform: translateY(-50%);
                                    width: 16px;
                                    height: 16px;
                                    border-radius: 50%;
                                    border: 1px solid #e2e8f0;
                                    background: #fff;
                                }

                                .skin-card.active .skin-badge {
                                    border-color: #3498db;
                                    background: #3498db;
                                }

                                .skin-card.active .skin-badge::after {
                                    content: '';
                                    position: absolute;
                                    top: 3px;
                                    left: 3px;
                                    width: 7px;
                                    height: 3px;
                                    border-left: 2px solid #fff;
                                    border-bottom: 2px solid #fff;
                                    transform: rotate(-45deg);
                                }

                                .skin-category-title {
                                    font-size: 14px;
                                    font-weight: 700;
                                    color: #1a202c;
                                    margin: 25px 0 10px;
                                    padding-left: 10px;
                                    border-left: 4px solid #3498db;
                                    display: flex;
                                    align-items: center;
                                    gap: 8px;
                                }
                            </style>
                            <input type="hidden" name="co_skin" id="co_skin" value="<?php echo $co['co_skin']; ?>">

                            <div class="skin-category-title"><i class="fa fa-building" style="color:#3498db;"></i> 회사개요 /
                                인사말 / 비젼
                                <a href="../?co_id=<?php echo $co['co_id']; ?>" target="_blank" class="btn btn_02"
                                    style="float:right; font-weight:normal; font-size:12px; padding:5px 10px;">페이지 보기 <i
                                        class="fa fa-external-link-alt"></i></a>
                            </div>
                            <div class="skin-selector-container">
                                <?php
                                $skins_v1 = array(
                                    'type_a' => array('Type A', 'fa-id-card'),
                                    'type_a_1' => array('Type A-1 (CEO)', 'fa-user-tie'),
                                    'type_a_2' => array('Type A-2 (Vision)', 'fa-lightbulb'),
                                    'type_b' => array('Type B', 'fa-id-card'),
                                    'type_b_1' => array('Type B-1 (CEO)', 'fa-user-tie'),
                                    'type_b_2' => array('Type B-2 (Vision)', 'fa-lightbulb'),
                                    'type_c' => array('Type C', 'fa-align-center'),
                                    'type_c_1' => array('Type C-1 (CEO)', 'fa-user-tie'),
                                    'type_c_2' => array('Type C-2 (Vision)', 'fa-lightbulb'),
                                    'instinct' => array('Instinct (서브 히어로)', 'fa-quote-left'),
                                    'overview' => array('Overview (회사 개요)', 'fa-info-circle'),
                                );
                                foreach ($skins_v1 as $sk => $sd) {
                                    $act = ($co['co_skin'] == $sk) ? 'active' : '';
                                    echo '<div class="skin-card ' . $act . '" onclick="select_ci_skin(\'' . $sk . '\', this)"><div class="skin-badge"></div><i class="fa ' . $sd[1] . '"></i><div class="skin-name">' . $sd[0] . '</div></div>';
                                }
                                ?>
                            </div>

                            <div class="skin-category-title"><i class="fa fa-history" style="color:#e67e22;"></i> 연혁 / 실적 /
                                인증서</div>
                            <div class="skin-selector-container">
                                <?php
                                $skins_v2 = array(
                                    'history_photo' => array('연혁 (포토)', 'fa-camera'),
                                    'history_simple' => array('연혁 (심플)', 'fa-list-ul'),
                                    'history_timeline' => array('연혁 (타임라인)', 'fa-stream'),
                                    'performance_gallery' => array('실적 (갤러리)', 'fa-trophy'),
                                    'performance_simple' => array('실적 (심플)', 'fa-list-ol'),
                                    'performance_timeline' => array('실적 (타임라인)', 'fa-chart-line'),
                                    'cert_a' => array('인증서 (갤러리)', 'fa-certificate'),
                                    'cert_b' => array('인증서 (심플)', 'fa-file-signature'),
                                    'cert_c' => array('인증서 (카드)', 'fa-address-card'),
                                );
                                foreach ($skins_v2 as $sk => $sd) {
                                    $act = ($co['co_skin'] == $sk) ? 'active' : '';
                                    echo '<div class="skin-card ' . $act . '" onclick="select_ci_skin(\'' . $sk . '\', this)"><div class="skin-badge"></div><i class="fa ' . $sd[1] . '"></i><div class="skin-name">' . $sd[0] . '</div></div>';
                                }
                                ?>
                            </div>

                            <div class="skin-category-title"><i class="fa fa-map-marker-alt" style="color:#2ecc71;"></i> 조직
                                / 사업 / 채용 / 오시는 길</div>
                            <div class="skin-selector-container">
                                <?php
                                $skins_page = array(
                                    'org_a' => array('조직도 A', 'fa-sitemap'),
                                    'org_b' => array('조직도 B', 'fa-users'),
                                    'team' => array('Team (임원진)', 'fa-user-friends'),
                                    'biz_a' => array('사업분야 A', 'fa-briefcase'),
                                    'biz_b' => array('사업분야 B', 'fa-project-diagram'),
                                    'biz_c' => array('사업분야 C', 'fa-layer-group'),
                                    'recruit_a' => array('채용정보 A', 'fa-user-plus'),
                                    'recruit_b' => array('채용정보 B', 'fa-id-badge'),
                                    'recruit_c' => array('채용정보 C', 'fa-handshake'),
                                    'location' => array('오시는 길 A', 'fa-map-marked'),
                                    'location_b' => array('오시는 길 B', 'fa-directions'),
                                    'location_c' => array('오시는 길 C', 'fa-street-view'),
                                );
                                foreach ($skins_page as $sk => $sd) {
                                    $act = ($co['co_skin'] == $sk) ? 'active' : '';
                                    echo '<div class="skin-card ' . $act . '" onclick="select_ci_skin(\'' . $sk . '\', this)"><div class="skin-badge"></div><i class="fa ' . $sd[1] . '"></i><div class="skin-name">' . $sd[0] . '</div></div>';
                                }
                                ?>
                            </div>

                            <!-- [NEW] Main Sections Group -->
                            <div class="skin-category-title"><i class="fa fa-star" style="color:#9b59b6;"></i> 메인 섹션 전용
                                (Main Page)</div>
                            <div class="skin-selector-container">
                                <?php
                                $skins_main = array(
                                    'main_latest' => array('메인 최신글', 'fa-images'),
                                    'main_map' => array('메인 지도 (Map)', 'fa-map-marked-alt'),
                                    'main_inquiry' => array('메인 온라인 문의', 'fa-envelope-open-text'),
                                );
                                foreach ($skins_main as $sk => $sd) {
                                    $act = ($co['co_skin'] == $sk) ? 'active' : '';
                                    echo '<div class="skin-card ' . $act . '" onclick="select_ci_skin(\'' . $sk . '\', this)"><div class="skin-badge"></div><i class="fa ' . $sd[1] . '"></i><div class="skin-name">' . $sd[0] . '</div></div>';
                                }
                                ?>
                            </div>

                            <!-- [NEW] Latest Skin Picker (Appears only for main_latest) -->
                            <div id="latest_skin_selector_wrap"
                                style="display: <?php echo ($co['co_skin'] == 'main_latest') ? 'block' : 'none'; ?>; margin-top: 20px; padding: 20px; background: #fdf6e3; border: 1px solid #eee8d5; border-radius: 12px;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div
                                        style="width: 45px; height: 45px; background: #cb4b16; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px;">
                                        <i class="fa fa-plug"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <label for="linked_ls_id"
                                            style="font-weight: 800; display: block; margin-bottom: 5px; color: #586e75;">연결할
                                            최신글 위젯 선택 (Management Name)</label>
                                        <select id="linked_ls_id" class="frm_input" style="width: 100%; max-width: 400px;"
                                            onchange="update_linked_latest_skin()">
                                            <option value="">위젯 선택 안함</option>
                                            <?php
                                            $ls_res = sql_query(" select ls_id, ls_title from " . G5_TABLE_PREFIX . "plugin_latest_skin_config order by ls_id desc ");
                                            while ($ls_row = sql_fetch_array($ls_res)) {
                                                echo '<option value="' . $ls_row['ls_id'] . '">' . get_text($ls_row['ls_title']) . ' (' . $ls_row['ls_id'] . ')</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <p style="margin-top: 10px; font-size: 12px; color: #93a1a1; padding-left: 60px;">※ 선택한 위젯의
                                    제목(관리 명칭), 더보기 링크, 내용이 메인 섹션에 자동으로 연결됩니다.</p>
                            </div>

                            <div
                                style="background:#fffcf5; border:1px solid #ffeeba; padding:15px; border-radius:12px; display:flex; align-items:center; gap:12px; margin-top:10px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                                <i class="fa fa-exclamation-triangle" style="color:#f39c12; font-size:20px;"></i>
                                <div style="color:#856404; font-size:13px; font-weight:600;">스킨을 선택하면 기본 양식이 에디터에 자동으로
                                    입력됩니다. 기존 내용은 삭제되니 주의하세요.</div>
                            </div>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">이미지 교체</th>
                    <td>
                        <button type="button" class="btn btn_03" onclick="openUnsplashPopup();">Unsplash 이미지 검색 및
                            교체</button>
                        <span class="frm_info">※ 현재 본문에 있는 이미지의 크기를 자동으로 감지하여, 검색 팝업에서 동일한 비율로 자를 수 있게 해줍니다.</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">내용</th>
                    <td>
                        <?php echo editor_html('co_content', get_text($co['co_content'], 0)); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="확인" class="btn_submit" accesskey="s">
        <a href="./list.php" class="btn btn_02">목록</a>
    </div>

</form>

<script>
    // [Infrastructure] 테마 주권(Theme Sovereignty) 기반 에디터 스타일 자동 상속
    function update_editor_background() {
        if (typeof oEditors !== 'undefined' && oEditors.getById["co_content"]) {
            try {
                // SmartEditor2의 편집 영역(iframe 내부 body) 접근
                var doc = oEditors.getById["co_content"].getWYSIWYGDocument();
                if (!doc || !doc.body) return;

                // 1. CSS Rule Injection (Enforce Theme Variables)
                var styleId = 'theme_sovereignty_style';
                var styleTag = doc.getElementById(styleId);
                if (!styleTag) {
                    styleTag = doc.createElement('style');
                    styleTag.id = styleId;
                    doc.head.appendChild(styleTag);
                }

                styleTag.innerHTML = `
                    html, body.se2_input_area { 
                        background-color: var(--color-bg-dark, #121212) !important; 
                        color: var(--color-text-primary, #e0e0e0) !important; 
                        margin: 0 !important;
                        padding: 0 !important;
                    }
                    body.se2_input_area { padding: 20px !important; }
                    body.se2_input_area a { color: var(--color-accent-gold, #d4af37) !important; }
                    /* Force background for all direct children if they cover the area */
                    body.se2_input_area > * { background-color: transparent !important; }
                `;

                // Backup direct JS styling for immediate effect
                doc.body.style.backgroundColor = '#121212'; // Immediate fallback
                setTimeout(function () {
                    // Try to use CSS variable if possible, otherwise keep fallback
                    doc.body.style.backgroundColor = '';
                }, 100);

                // 2. Inject Theme CSS (For Variables & Fonts)
                if (!doc.getElementById('theme_css_injection')) {
                    var link = doc.createElement('link');
                    link.id = 'theme_css_injection';
                    link.rel = 'stylesheet';
                    link.href = '<?php echo G5_THEME_URL; ?>/css/default.css?v=' + Date.now();
                    doc.head.appendChild(link);
                }

                // 3. Inject Font CSS
                if (!doc.getElementById('font_css_injection')) {
                    var link = doc.createElement('link');
                    link.id = 'font_css_injection';
                    link.rel = 'stylesheet';
                    link.href = 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap';
                    doc.head.appendChild(link);
                }

            } catch (e) {
                console.log("에디터 로딩 중이거나 접근 불가: " + e);
            }
        }
    }

    function update_theme_defaults() {
        update_editor_background();
    }

    function change_skin(skin_name) {
        if (!confirm("스킨을 변경하면 현재 작성된 내용이 사라지고 초기화됩니다.\n계속하시겠습니까?")) {
            return false;
        }

        $.ajax({
            url: '../skin/' + skin_name + '.html?v=' + Math.random(), // Stronger Cache Busting
            dataType: 'html',
            success: function (data) {
                // Formatting Check
                console.log("Loaded Skin Data:", data);

                if (typeof oEditors !== 'undefined' && oEditors.getById["co_content"]) {
                    oEditors.getById["co_content"].exec("SET_IR", [""]);
                    setTimeout(function () {
                        oEditors.getById["co_content"].exec("PASTE_HTML", [data]);
                    }, 100); // Slight delay to ensure editor is ready

                    update_editor_background(); // No args needed as we force it
                } else {
                    alert('에디터 객체를 찾을 수 없습니다.');
                }
            },
            error: function () {
                alert('스킨 파일을 불러오는데 실패했습니다.');
            }
        });
    }

    var is_checked_id = false;

    // [Unsplash Integration]
    var targetImageIndex = -1; // -1: Insert New, 0+: Replace specific index

    function openUnsplashPopup() {
        if (typeof oEditors === 'undefined' || !oEditors.getById["co_content"]) {
            alert("에디터가 로드되지 않았습니다.");
            return;
        }

        var doc = oEditors.getById["co_content"].getWYSIWYGDocument();
        var imgs = doc.body.querySelectorAll("img");

        if (imgs.length > 1) {
            // Multiple images found -> Show Picker
            showImagePicker(imgs);
        } else if (imgs.length === 1) {
            // Single image -> Auto select
            selectTargetImage(0);
        } else {
            // No image -> Insert Mode
            targetImageIndex = -1;
            openRealPopup(0, 0);
        }
    }

    function showImagePicker(imgs) {
        var html = '';
        for (var i = 0; i < imgs.length; i++) {
            var src = imgs[i].src;
            var w = imgs[i].width || imgs[i].naturalWidth;
            var h = imgs[i].height || imgs[i].naturalHeight;

            html += '<div class="img-picker-item" onclick="selectTargetImage(' + i + ')">';
            html += '<img src="' + src + '">';
            html += '<div class="img-picker-info">이미지 #' + (i + 1) + ' (' + w + 'x' + h + ')</div>';
            html += '</div>';
        }

        $('#img_picker_list').html(html);
        $('#img_picker_modal').css('display', 'flex');
    }

    function selectTargetImage(index) {
        $('#img_picker_modal').hide();
        targetImageIndex = index;

        // Analyze size
        var doc = oEditors.getById["co_content"].getWYSIWYGDocument();
        var imgs = doc.body.querySelectorAll("img");
        var img = imgs[index];

        var w = parseInt(img.getAttribute("width")) || parseInt(img.style.width) || img.naturalWidth || 0;
        var h = parseInt(img.getAttribute("height")) || parseInt(img.style.height) || img.naturalHeight || 0;

        openRealPopup(w, h);
    }

    function openRealPopup(w, h) {
        // [MODIFIED] Point to Unified Image Manager
        var url = './image_manager.php?v=' + Date.now();
        if (w > 0 && h > 0) {
            url += '&w=' + w + '&h=' + h;
            console.log("Detected Image Size for Crop: " + w + "x" + h);
        }

        var iframe = document.getElementById('unsplash_iframe');
        iframe.src = url;
        document.getElementById('unsplash_modal').style.display = 'flex';
    }

    function closeUnsplashModal() {
        document.getElementById('unsplash_modal').style.display = 'none';
        document.getElementById('unsplash_iframe').src = '';
    }

    function receiveImageUrl(url) {
        closeUnsplashModal();

        var doc = oEditors.getById["co_content"].getWYSIWYGDocument();

        if (targetImageIndex >= 0) {
            // Replace specific image
            var imgs = doc.body.querySelectorAll("img");
            if (imgs[targetImageIndex]) {
                imgs[targetImageIndex].src = url;
            } else {
                pasteNewImage(url);
            }
        } else {
            // Insert new
            pasteNewImage(url);
        }
    }

    function select_ci_skin(skin_name, el) {
        $('.skin-card').removeClass('active');
        $(el).addClass('active');
        $('#co_skin').val(skin_name);

        // Show/Hide Portfolio Widget Selector
        if (skin_name == 'main_latest') {
            $('#latest_skin_selector_wrap').show();
        } else {
            $('#latest_skin_selector_wrap').hide();
        }

        change_skin(skin_name);
    }

    function update_linked_latest_skin() {
        var ls_id = $('#linked_ls_id').val();
        if (!ls_id) return;

        // AJAX to get latest skin details
        $.ajax({
            url: '../../latest_skin_manager/adm/ajax.get_config.php',
            type: 'POST',
            data: { ls_id: ls_id },
            dataType: 'json',
            success: function (data) {
                if (data.error) {
                    console.error("Latest Skin Data Error:", data.error);
                    return;
                }

                if (typeof oEditors !== 'undefined' && oEditors.getById["co_content"]) {
                    var content = oEditors.getById["co_content"].getIR();

                    // 1. Identification Marker
                    var newMarker = '{LATEST_SKIN:' + ls_id + '}';
                    if (content.indexOf('{LATEST_SKIN:') !== -1) {
                        content = content.replace(/\{LATEST_SKIN:([a-zA-Z0-9_]+)\}/, newMarker);
                    } else if (content.indexOf('{LATEST_SKIN_DISPLAY}') !== -1) {
                        content = content.replace('{LATEST_SKIN_DISPLAY}', newMarker);
                    } else {
                        content += '<p>' + newMarker + '</p>';
                    }

                    // 2. Title & Description Sync (Visual Feedback in Editor)
                    // We replace placeholders if they exist, or look for standard classes
                    if (data.ls_title) {
                        if (content.indexOf('{LS_TITLE}') !== -1) {
                            content = content.replace('{LS_TITLE}', data.ls_title);
                        } else {
                            // Try to replace content inside h2.section-title if possible (regex)
                            content = content.replace(/(<h2[^>]*class="[^"]*section-title[^"]*"[^>]*>)([^<]*)(<\/h2>)/i, '$1' + data.ls_title + '$3');
                        }
                    }
                    if (data.ls_description) {
                        if (content.indexOf('{LS_DESCRIPTION}') !== -1) {
                            content = content.replace('{LS_DESCRIPTION}', data.ls_description);
                        } else {
                            content = content.replace(/(<p[^>]*class="[^"]*section-subtitle[^"]*"[^>]*>)([^<]*)(<\/p>)/i, '$1' + data.ls_description + '$3');
                        }
                    }

                    oEditors.getById["co_content"].exec("SET_IR", [content]);
                    update_editor_background();
                }
            }
        });
    }

    function receiveUnsplashUrl(url) {
        receiveImageUrl(url);
    }

    function pasteNewImage(url) {
        var newHtml = '<img src="' + url + '" style="max-width:100%;">';
        oEditors.getById["co_content"].exec("PASTE_HTML", [newHtml]);
    }

    function generate_co_id() {
        var theme = $('#co_theme').val();
        var lang = $('#co_lang').val();
        var custom = $('#co_custom').val().trim();

        if (!theme) {
            $('#generated_id_display').text('-');
            $('#co_id').val('');
            return;
        }

        var co_id = theme + '_' + lang;
        if (custom) {
            co_id += '_' + custom;
        }

        $('#generated_id_display').text(co_id);
        $('#co_id').val(co_id);
    }

    function fcompanyform_submit(f) {
        <?php echo get_editor_js('co_content', true); // Only for content sync ?>

        if (confirm("저장하시겠습니까?")) {
            return true;
        }
        return false;
    }

    // [IMPORTANT] Initialize SmartEditor2 globally so oEditors is populated
    <?php echo get_editor_js('co_content', false); // Global init ?>

    $(function () {
        // [Editor Infrastructure Fix] 로딩 즉시 배경색 & 가로폭/높이 강력 제어
        var init_retry_count = 0;
        function init_editor_state() {
            var editorExists = (typeof oEditors !== 'undefined' && oEditors.getById && oEditors.getById["co_content"]);

            if (!editorExists) {
                if (init_retry_count < 30) {
                    init_retry_count++;
                    setTimeout(init_editor_state, 300);
                }
                return;
            }

            setTimeout(function () {
                update_editor_background();
                forceResizeEditor();

                var enforceCount = 0;
                var enforceInterval = setInterval(function () {
                    update_editor_background();
                    forceResizeEditor(); // Apply height resize continuously during init
                    if (enforceCount++ > 15) {
                        clearInterval(enforceInterval);
                    }
                }, 400);
            }, 500);
        }

        function forceResizeEditor() {
            if (typeof oEditors !== 'undefined' && oEditors.getById["co_content"]) {
                var frames = document.getElementsByTagName('iframe');
                for (var i = 0; i < frames.length; i++) {
                    var f = frames[i];
                    // Target by ID or by SmartEditor skin path
                    var isEditorFrame = (f.id && f.id.indexOf('co_content') !== -1) ||
                        (f.src && f.src.indexOf('SmartEditor2Skin.html') !== -1);

                    if (isEditorFrame) {
                        f.style.height = "1000px";

                        // Try to reach into the content area too
                        try {
                            var innerDoc = f.contentWindow.document;
                            var inputArea = innerDoc.querySelector('.se2_input_area');
                            if (inputArea) {
                                inputArea.style.height = "920px"; // Slightly less for toolbar
                            }
                            var editFrame = innerDoc.getElementById('se2_iframe');
                            if (editFrame) {
                                editFrame.style.height = "920px";
                            }
                        } catch (e) { }
                    }
                }
            }
        }

        // 초기화 실행
        init_editor_state();

        // ID 중복확인
        $('#co_id').on('keyup blur', function () {
            var co_id = $(this).val();
            var $msg = $('#msg_co_id');

            if (co_id == '') {
                $msg.text('코드를 입력해주세요.').css('color', 'red');
                is_checked_id = false;
                return;
            }

            $.ajax({
                url: './ajax.check_id.php',
                type: 'POST',
                data: { co_id: co_id },
                dataType: 'json',
                success: function (data) {
                    if (data.count > 0) {
                        $msg.text(data.msg).css('color', 'red');
                        is_checked_id = false;
                    } else {
                        $msg.text(data.msg).css('color', 'blue');
                        is_checked_id = true;
                    }
                }
            });
        });

        // ID Generation Listeners
        $('#co_theme, #co_lang, #co_custom').on('change keyup input', function () {
            generate_co_id();
        });
    });
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>