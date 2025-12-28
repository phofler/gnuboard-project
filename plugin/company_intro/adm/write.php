<?php
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

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
        'co_bgcolor' => '#000000'
    );
}

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
        width: 90%;
        max-width: 1200px;
        height: 90%;
        max-height: 900px;
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

<style>
    .color_picker_wrapper {
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
    }

    .color_picker_wrapper input[type="color"] {
        width: 50px;
        height: 30px;
        border: none;
        padding: 0;
        cursor: pointer;
    }
</style>

<form name="fcompanyform" id="fcompanyform" action="./write_update.php" onsubmit="return fcompanyform_submit(this);"
    method="post" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="token" value="">

    <div class="tbl_frm01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?></caption>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row"><label for="co_id">ID (식별코드)</label></th>
                    <td>
                        <input type="text" name="co_id" value="<?php echo $co['co_id']; ?>" id="co_id" required
                            class="frm_input <?php echo $readonly ? 'readonly' : ''; ?>" <?php echo $readonly; ?>
                            size="20">
                        <?php if ($w == '')
                            echo '<span class="frm_info">중복되지 않는 영문 코드를 입력하세요. 예) greeting, history</span>'; ?>
                        <span id="msg_co_id" style="margin-left: 10px; font-weight: bold;"></span>
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
                    <style>
                        .skin-group {
                            border: 1px solid #ddd;
                            border-radius: 5px;
                            padding: 15px;
                            margin-bottom: 10px;
                            background: #f9f9f9;
                            transition: background 0.2s;
                        }

                        .skin-group:hover {
                            background: #f0f0f0;
                            border-color: #bbb;
                        }

                        .skin-group h4 {
                            margin: 0 0 10px;
                            font-size: 14px;
                            color: #333;
                            border-bottom: 2px solid #555;
                            padding-bottom: 5px;
                            display: inline-block;
                        }

                        /* 3x3 Grid Layout */
                        .skin-list {
                            display: grid;
                            grid-template-columns: repeat(3, 1fr);
                            gap: 12px;
                        }

                        /* 2-Column Grid Layout */
                        .skin-list-2 {
                            display: grid;
                            grid-template-columns: repeat(2, 1fr);
                            gap: 12px;
                        }

                        .skin-list label {
                            display: block;
                            width: 100%;
                            box-sizing: border-box;
                            padding: 12px;
                            border: 1px solid #ddd;
                            border-radius: 4px;
                            background: #fff;
                            cursor: pointer;
                            transition: all 0.2s;
                        }

                        .skin-list-2 label {
                            display: block;
                            width: 100%;
                            box-sizing: border-box;
                            padding: 12px;
                            border: 1px solid #ddd;
                            border-radius: 4px;
                            background: #fff;
                            cursor: pointer;
                            transition: all 0.2s;
                        }

                        .skin-list label:hover,
                        .skin-list-2 label:hover {
                            border-color: #666;
                            background: #fafafa;
                        }

                        .skin-list label input,
                        .skin-list-2 label input {
                            margin-right: 6px;
                            vertical-align: middle;
                        }

                        /* Highlight for Vision/CEO items */
                        .skin-premium {
                            border-left: 3px solid #d4af37 !important;
                            background: #fffdf5 !important;
                        }

                        .skin-list label span,
                        .skin-list-2 label span {
                            vertical-align: middle;
                            font-size: 13px;
                        }

                        .skin-premium {
                            color: #d4af37;
                            font-weight: bold;
                        }
                    </style>

                    <th scope="row">스킨 선택</th>
                    <td>
                        <?php if ($w == 'u') { ?>
                            <!-- 수정 모드: 현재 스킨 표시 -->
                            <input type="hidden" name="co_skin" value="<?php echo $co['co_skin']; ?>">
                            <div style="padding:10px; background:#f5f5f5; border-radius:4px; border:1px solid #ddd;">
                                <strong style="font-size:15px; color:#000;">
                                    <?php
                                    $skin_names = array(
                                        'type_a' => 'Type A (이미지 / 텍스트)',
                                        'type_a_1' => 'Type A-1 (이미지 / 텍스트 - CEO)',
                                        'type_a_2' => 'Type A-2 (이미지 / 텍스트 - 비젼)',
                                        'type_b' => 'Type B (텍스트 / 이미지)',
                                        'type_b_1' => 'Type B-1 (텍스트 / 이미지 - CEO)',
                                        'type_b_2' => 'Type B-2 (텍스트 / 이미지 - 비젼)',
                                        'type_c' => 'Type C (중앙정렬)',
                                        'type_c_1' => 'Type C-1 (중앙정렬 - CEO)',
                                        'type_c_2' => 'Type C-2 (중앙정렬 - 비젼)',

                                        // History Skins
                                        'history_photo' => '연혁 (포토 갤러리)',
                                        'history_simple' => '연혁 (심플 리스트)',
                                        'history_timeline' => '연혁 (타임라인)',

                                        // Performance Skins
                                        'performance_gallery' => '실적 (포토 갤러리)',
                                        'performance_simple' => '실적 (심플 리스트)',
                                        'performance_timeline' => '실적 (타임라인)',

                                        // Certificate Skins
                                        'cert_a' => '인증서 (갤러리)',
                                        'cert_b' => '인증서 (심플 리스트)',
                                        'cert_c' => '인증서 (상세/카드)',

                                        'org_a' => '조직도 A (이미지/좌측)',
                                        'org_b' => '조직도 B (이미지/중앙)',
                                        'biz_a' => '사업분야 A (Grid)',
                                        'biz_b' => '사업분야 B (지그재그)',
                                        'biz_c' => '사업분야 C (오버레이)',
                                        'recruit_a' => '채용정보 A (표준형)',
                                        'recruit_b' => '채용정보 B (카드형)',
                                        'recruit_c' => '채용정보 C (분할형)',
                                        'location' => '오시는 길 A (표준형/하단지도)',
                                        'location_b' => '오시는 길 B (좌우분할)',
                                        'location_c' => '오시는 길 C (오버레이)',
                                    );
                                    echo isset($skin_names[$co['co_skin']]) ? $skin_names[$co['co_skin']] : $co['co_skin'];
                                    ?>
                                </strong>
                                <p class="frm_info" style="margin:5px 0 0;">※ 데이터 보호를 위해 수정 모드에서는 스킨 변경이 제한됩니다.</p>
                            </div>
                        <?php } else { ?>
                            <!-- 입력 모드: 카테고리별 선택 -->

                            <!-- 1. 회사소개 / 인사말 / 비전 -->
                            <div class="skin-group">
                                <h4>회사개요 / 인사말 / 비젼</h4>
                                <div class="skin-list">
                                    <label><input type="radio" name="co_skin" value="type_a" <?php echo ($co['co_skin'] == 'type_a') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>Type A (이미지 / 텍스트)</span></label>
                                    <label class="skin-premium"><input type="radio" name="co_skin" value="type_a_1" <?php echo ($co['co_skin'] == 'type_a_1') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>Type A-1 (이미지 / 텍스트 -
                                            CEO)</span></label>
                                    <label class="skin-premium"><input type="radio" name="co_skin" value="type_a_2" <?php echo ($co['co_skin'] == 'type_a_2') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>Type A-2 (이미지 / 텍스트 -
                                            비젼)</span></label>
                                    <label><input type="radio" name="co_skin" value="type_b" <?php echo ($co['co_skin'] == 'type_b') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>Type B (텍스트 / 이미지)</span></label>
                                    <label class="skin-premium"><input type="radio" name="co_skin" value="type_b_1" <?php echo ($co['co_skin'] == 'type_b_1') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>Type B-1 (텍스트 / 이미지 -
                                            CEO)</span></label>
                                    <label class="skin-premium"><input type="radio" name="co_skin" value="type_b_2" <?php echo ($co['co_skin'] == 'type_b_2') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>Type B-2 (텍스트 / 이미지 -
                                            비젼)</span></label>
                                    <label><input type="radio" name="co_skin" value="type_c" <?php echo ($co['co_skin'] == 'type_c') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>Type C (중앙정렬)</span></label>
                                    <label class="skin-premium"><input type="radio" name="co_skin" value="type_c_1" <?php echo ($co['co_skin'] == 'type_c_1') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>Type C-1 (중앙정렬 - CEO)</span></label>
                                    <label class="skin-premium"><input type="radio" name="co_skin" value="type_c_2" <?php echo ($co['co_skin'] == 'type_c_2') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>Type C-2 (중앙정렬 - 비젼)</span></label>
                                </div>
                            </div>

                            <!-- 2. 연혁 / 실적 / 인증서 (3-Column Layout) -->
                            <div class="skin-group">
                                <h4>연혁 / 실적 / 인증서</h4>
                                <!-- Changed class to skin-list for 3 columns -->
                                <div class="skin-list">
                                    <!-- Row 1 -->
                                    <label><input type="radio" name="co_skin" value="history_photo" <?php echo ($co['co_skin'] == 'history_photo') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>연혁 (포토)</span></label>
                                    <label><input type="radio" name="co_skin" value="performance_gallery" <?php echo ($co['co_skin'] == 'performance_gallery') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>실적 (포토/갤러리)</span></label>
                                    <label><input type="radio" name="co_skin" value="cert_a" <?php echo ($co['co_skin'] == 'cert_a') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>인증서 (갤러리)</span></label>

                                    <!-- Row 2 -->
                                    <label><input type="radio" name="co_skin" value="history_simple" <?php echo ($co['co_skin'] == 'history_simple') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>연혁 (심플리스트)</span></label>
                                    <label><input type="radio" name="co_skin" value="performance_simple" <?php echo ($co['co_skin'] == 'performance_simple') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>실적 (심플리스트)</span></label>
                                    <label><input type="radio" name="co_skin" value="cert_b" <?php echo ($co['co_skin'] == 'cert_b') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>인증서 (심플리스트)</span></label>

                                    <!-- Row 3 -->
                                    <label><input type="radio" name="co_skin" value="history_timeline" <?php echo ($co['co_skin'] == 'history_timeline') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>연혁 (타임라인)</span></label>
                                    <label><input type="radio" name="co_skin" value="performance_timeline" <?php echo ($co['co_skin'] == 'performance_timeline') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>실적 (타임라인)</span></label>
                                    <label><input type="radio" name="co_skin" value="cert_c" <?php echo ($co['co_skin'] == 'cert_c') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>인증서 (상세/카드)</span></label>
                                </div>
                            </div>

                            <!-- 3. 조직 / 사업 / 채용 / 오시는 길 -->
                            <div class="skin-group">
                                <h4>조직 / 사업 / 채용 / 오시는 길</h4>
                                <div class="skin-list">
                                    <label><input type="radio" name="co_skin" value="org_a" <?php echo ($co['co_skin'] == 'org_a') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>조직도 A (이미지/좌측)</span></label>
                                    <label><input type="radio" name="co_skin" value="org_b" <?php echo ($co['co_skin'] == 'org_b') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>조직도 B (이미지/중앙)</span></label>
                                    
                                    <label><input type="radio" name="co_skin" value="biz_a" <?php echo ($co['co_skin'] == 'biz_a') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>사업분야 A (Grid)</span></label>
                                    <label><input type="radio" name="co_skin" value="biz_b" <?php echo ($co['co_skin'] == 'biz_b') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>사업분야 B (지그재그)</span></label>
                                    <label><input type="radio" name="co_skin" value="biz_c" <?php echo ($co['co_skin'] == 'biz_c') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>사업분야 C (오버레이)</span></label>
                                    <label><input type="radio" name="co_skin" value="recruit_a" <?php echo ($co['co_skin'] == 'recruit_a') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>채용정보 A (표준형)</span></label>
                                    <label><input type="radio" name="co_skin" value="recruit_b" <?php echo ($co['co_skin'] == 'recruit_b') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>채용정보 B (카드형)</span></label>
                                    <label><input type="radio" name="co_skin" value="recruit_c" <?php echo ($co['co_skin'] == 'recruit_c') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>채용정보 C (분할형)</span></label>
                                    
                                    <label><input type="radio" name="co_skin" value="location" <?php echo ($co['co_skin'] == 'location') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>오시는 길 A (표준형)</span></label>
                                    <label><input type="radio" name="co_skin" value="location_b" <?php echo ($co['co_skin'] == 'location_b') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>오시는 길 B (좌우분할)</span></label>
                                    <label><input type="radio" name="co_skin" value="location_c" <?php echo ($co['co_skin'] == 'location_c') ? 'checked' : ''; ?>
                                            onclick="change_skin(this.value);"> <span>오시는 길 C (오버레이)</span></label>
                                </div>
                            </div>

                            <div class="frm_info" style="color:red; margin-top:5px;">
                                ※ 스킨을 선택하면 기본 양식이 에디터에 자동으로 입력됩니다.
                            </div>
                        <?php } ?>
                    </td>
                </tr>
                <!-- [HIDDEN] Background Color Selection: Forced to Theme Inheritance
                <tr>
                    <th scope="row"><label for="co_bgcolor">배경색 선택</label></th>
                    <td>
                        <div class="color_picker_wrapper">
                            <input type="color" name="co_bgcolor"
                                value="<?php echo $co['co_bgcolor'] ? $co['co_bgcolor'] : '#000000'; ?>"
                                id="co_bgcolor">
                        </div>
                        <span class="frm_info">이 페이지의 배경색을 선택하세요. 본문 글자색은 배경색에 따라 자동(흰색/검정)으로 보정되거나 스킨 스타일을 따릅니다.</span>
                    </td>
                </tr>
                -->
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
    // 에디터 배경색 실시간 변경 (전역 함수로 정의 - onclick 호출 가능하도록)
    function update_editor_background(color) {
        if (typeof oEditors !== 'undefined' && oEditors.getById["co_content"]) {
            try {
                // SmartEditor2의 편집 영역(iframe 내부 body) 접근
                var doc = oEditors.getById["co_content"].getWYSIWYGDocument();

                // 1. Background Color - [FORCE THEME DARK]
                // 사용자가 선택한 색상이 있어도 '일관성'을 위해 테마 기본색을 우선시하거나,
                // 입력폼에서 투명하게 처리하고 여기서 강제할 수 있습니다.
                // 여기서는 인자로 넘어온 color를 무시하고 테마색을 적용합니다. (사용자 요청 반영)
                var themeColor = "#121212";
                doc.body.style.backgroundColor = themeColor;

                // 2. Inject Theme CSS (For Variables & Fonts)
                // Avoid Duplicate Injection
                if (!doc.getElementById('theme_css_injection')) {
                    var link = doc.createElement('link');
                    link.id = 'theme_css_injection';
                    link.rel = 'stylesheet';
                    link.href = '<?php echo G5_THEME_URL; ?>/css/default.css?v=' + new Date().getTime();
                    doc.head.appendChild(link);
                }

                // 3. Inject Font CSS (If separate)
                if (!doc.getElementById('font_css_injection')) {
                    var link = doc.createElement('link');
                    link.id = 'font_css_injection';
                    link.rel = 'stylesheet';
                    link.href = 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap';
                    doc.head.appendChild(link);
                }

                // 4. Force Text Color for Visibility
                doc.body.style.color = "#e0e0e0";

            } catch (e) {
                console.log("에디터 로딩 중이거나 접근 불가: " + e);
            }
        }
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

                    // DEBUG: Notify user that new skin is loaded
                    // alert("새로운 스킨 파일이 로드되었습니다.\n확인 후 저장해주세요.");
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

    // Renamed for clarity, but kept logic
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

    // Alias for compatibility if needed
    function receiveUnsplashUrl(url) {
        receiveImageUrl(url);
    }

    function pasteNewImage(url) {
        var newHtml = '<img src="' + url + '" style="max-width:100%;">';
        oEditors.getById["co_content"].exec("PASTE_HTML", [newHtml]);
    }

    function fcompanyform_submit(f) {
        <?php echo get_editor_js('co_content'); ?>

        if (f.w.value == '' && !is_checked_id) {
            alert('코드를 확인해주세요.');
            f.co_id.focus();
            return false;
        }

        return true;
    }

    $(document).ready(function () {
        $('#co_bgcolor').on('input change', function () {
            update_editor_background(); // Ignore value, enforce theme
        });

        // [Editor Height Resize] 에디터 높이 3배(1000px) 확장 - 강력 적용 (내부 요소까지)
        function forceResizeEditor() {
            var frames = document.getElementsByTagName('iframe');
            for (var i = 0; i < frames.length; i++) {
                if (frames[i].title == 'SmartEditor' || frames[i].src.indexOf('SmartEditor2Skin.html') > -1) {
                    // 1. iframe 자체 높이
                    frames[i].style.height = "1000px";
                    frames[i].setAttribute('height', '1000');

                    // 2. iframe 내부 요소 (.se2_input_area) 높이 조절
                    try {
                        var innerDoc = frames[i].contentWindow.document;
                        var inputArea = innerDoc.querySelector('.se2_input_area');
                        if (inputArea) {
                            inputArea.style.height = "960px"; // 툴바 높이 제외 대략값
                        }
                        // 편집 모드 iframe (#se2_iframe)
                        var editFrame = innerDoc.getElementById('se2_iframe');
                        if (editFrame) {
                            editFrame.style.height = "960px";
                        }
                    } catch (e) {
                        console.log("Cross-origin or load error: " + e);
                    }
                }
            }
        }

        // 반복 시도
        setTimeout(function () { update_editor_background(); forceResizeEditor(); }, 500);
        setTimeout(forceResizeEditor, 1500);
        setTimeout(forceResizeEditor, 3000);

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
    });
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>