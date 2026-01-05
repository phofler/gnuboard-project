<?php
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

$sub_menu = "800350";
$html_title = '카피라이트';
$readonly = '';
$table_name = G5_TABLE_PREFIX . 'plugin_copyright';

if ($w == 'u') {
    $html_title .= ' 수정';
    $readonly = ' readonly';
} else {
    $html_title .= ' 입력';
}

$cp_id = isset($_REQUEST['cp_id']) ? clean_xss_tags($_REQUEST['cp_id']) : '';

// Theme-Aware ID Detection for "Input" mode or if not provided
// REMOVED: This prevents adding NEW IDs because it forces the current theme ID.
// if (!$cp_id) {
//    $theme_name = (isset($config['cf_theme']) && $config['cf_theme']) ? $config['cf_theme'] : 'default';
//    $cp_id = $theme_name;
// }

$cp = sql_fetch(" select * from {$table_name} where cp_id = '{$cp_id}' ");

if ($cp && !$w) {
    $w = 'u';
}

if (!$cp) {
    if ($w == 'u') {
        alert('등록된 자료가 없습니다.');
    } else {
        // Prepare Default data if no theme-specific row exists
        $default_config = sql_fetch(" select * from {$table_name} where cp_id = 'default' ");

        // Initial setup for new entry
        $cp = array(
            'addr_label' => $default_config['addr_label'] ?: '주소',
            'tel_label' => $default_config['tel_label'] ?: '연락처',
            'fax_label' => $default_config['fax_label'] ?: '팩스',
            'email_label' => $default_config['email_label'] ?: '이메일',
            'addr_val' => $default_config['addr_val'] ?: '',
            'tel_val' => $default_config['tel_val'] ?: '',
            'fax_val' => $default_config['fax_val'] ?: '',
            'email_val' => $default_config['email_val'] ?: '',
            'logo_url' => $default_config['logo_url'] ?: '',
            'slogan' => $default_config['slogan'] ?: '',
            'copyright' => $default_config['copyright'] ?: 'Copyright &copy; All rights reserved.',
            'cp_skin' => 'style_a' // Force Style A by default for NEW entries
        );

        $cp['cp_id'] = $cp_id;
        $cp['cp_subject'] = '신규 카피라이트';

        // Load Style A template explicitly for NEW entries
        $template_path = G5_PLUGIN_PATH . '/copyright_manager/skins/style_a/template.html';
        if (file_exists($template_path)) {
            $cp['cp_content'] = file_get_contents($template_path);
        }
    }
}

$g5['title'] = $html_title;
include_once(G5_ADMIN_PATH . '/admin.head.php');
?>

<form name="fcopyrightform" id="fcopyrightform" action="./write_update.php"
    onsubmit="return fcopyrightform_submit(this);" method="post" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="token" value="">
    <input type="hidden" name="logo_url" value="<?php echo $cp['logo_url']; ?>">

    <div class="btn_fixed_top">
        <input type="submit" value="확인" class="btn_submit btn">
        <a href="./list.php" class="btn btn_02">목록</a>
    </div>

    <h2 class="h2_frm">기본 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row"><label for="cp_id">ID (식별코드)</label></th>
                    <td>
                        <input type="text" name="cp_id" value="<?php echo $cp['cp_id']; ?>" id="cp_id" required
                            class="frm_input <?php echo $readonly ? 'readonly' : ''; ?>" <?php echo $readonly; ?>
                            size="20">
                        <?php if ($w == '')
                            echo '<span class="frm_info">중복되지 않는 영문 코드를 입력하세요. <strong>팁: 사용 중인 테마명(예: corporate, corporate_light)과 똑같이 만들면 해당 테마에서 자동으로 매칭됩니다.</strong></span>'; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="cp_subject">제목 (관리용)</label></th>
                    <td>
                        <input type="text" name="cp_subject" value="<?php echo $cp['cp_subject']; ?>" id="cp_subject"
                            required class="frm_input" size="60">
                    </td>
                </tr>



                <tr>
                    <th scope="row">스킨 선택</th>
                    <td>
                        <style>
                            .skin-group {
                                border: 1px solid #eee;
                                border-radius: 8px;
                                padding: 20px;
                                background: #fff;
                            }

                            .skin-list {
                                display: grid;
                                grid-template-columns: repeat(4, 1fr);
                                gap: 15px;
                            }

                            .skin-item {
                                cursor: pointer;
                                transition: all 0.2s;
                            }

                            .skin-item label {
                                display: block;
                                padding: 15px;
                                border: 1px solid #ddd;
                                border-radius: 6px;
                                background: #fafafa;
                                cursor: pointer;
                                text-align: center;
                                transition: all 0.2s;
                            }

                            .skin-item label:hover {
                                border-color: #999;
                                background: #f0f0f0;
                            }

                            .skin-item input[type="radio"] {
                                display: none;
                            }

                            .skin-item input[type="radio"]:checked+label {
                                border-color: #3498db;
                                background: #ebf5fb;
                                box-shadow: 0 4px 8px rgba(52, 152, 219, 0.1);
                            }

                            .skin-name {
                                display: block;
                                font-weight: bold;
                                font-size: 14px;
                                margin-bottom: 5px;
                                color: #333;
                            }

                            .skin-desc {
                                display: block;
                                font-size: 12px;
                                color: #777;
                            }

                            .skin-premium {
                                color: #d4af37 !important;
                            }
                        </style>
                        <div class="skin-group">
                            <div class="skin-list">
                                <div class="skin-item">
                                    <input type="radio" name="cp_skin" value="style_a" id="skin_a" <?php echo ($cp['cp_skin'] == 'style_a' || !$cp['cp_skin']) ? 'checked' : ''; ?>
                                        onchange="load_template(this.value)">
                                    <label for="skin_a">
                                        <span class="skin-name">Style A</span>
                                        <span class="skin-desc">Classic Centered</span>
                                    </label>
                                </div>
                                <div class="skin-item">
                                    <input type="radio" name="cp_skin" value="style_b" id="skin_b" <?php echo ($cp['cp_skin'] == 'style_b') ? 'checked' : ''; ?>
                                        onchange="load_template(this.value)">
                                    <label for="skin_b">
                                        <span class="skin-name">Style B</span>
                                        <span class="skin-desc">Modern Split</span>
                                    </label>
                                </div>
                                <div class="skin-item">
                                    <input type="radio" name="cp_skin" value="style_c" id="skin_c" <?php echo ($cp['cp_skin'] == 'style_c') ? 'checked' : ''; ?>
                                        onchange="load_template(this.value)">
                                    <label for="skin_c">
                                        <span class="skin-name">Style C</span>
                                        <span class="skin-desc">Cinematic Grid</span>
                                    </label>
                                </div>
                                <div class="skin-item">
                                    <input type="radio" name="cp_skin" value="style_d" id="skin_d" <?php echo ($cp['cp_skin'] == 'style_d') ? 'checked' : ''; ?>
                                        onchange="load_template(this.value)">
                                    <label for="skin_d">
                                        <span class="skin-name">Style D</span>
                                        <span class="skin-desc" style="color:#ff3b30; font-weight:bold;">Editorial Bold</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="frm_info" style="color: #e74c3c;">※ 스킨 변경 시 현재 에디터 내용이 해당 스킨의 기본 양식으로 초기화됩니다.</div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="cp_bgcolor">배경색 (Background)</label></th>
                    <td>
                        <?php
                        $default_theme_bg = get_theme_default_bgcolor($config['cf_theme']);
                        $current_bg = (isset($cp['cp_bgcolor']) && $cp['cp_bgcolor']) ? $cp['cp_bgcolor'] : $default_theme_bg;
                        ?>
                        <div style="display:flex; align-items:center; gap:5px;">
                            <input type="text" name="cp_bgcolor" value="<?php echo $current_bg; ?>" id="cp_bgcolor"
                                class="frm_input" size="10">
                            <input type="color" id="cp_bgcolor_picker" value="<?php echo $current_bg; ?>"
                                onchange="document.getElementById('cp_bgcolor').value = this.value; update_editor_background(this.value);">

                            <button type="button" class="btn_frmline"
                                style="height:24px; line-height:24px; padding:0 10px;"
                                onclick="restore_default_bgcolor('<?php echo $default_theme_bg; ?>');">
                                기본값 복원
                            </button>
                        </div>
                        <div class="frm_info">푸터 영역의 배경색을 지정합니다. (현재 테마 기준 기본값 자동 적용)</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <h2 class="h2_frm" style="margin-top:30px;">자유 에디터 관리 (디자인 레이아웃)</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row">에디터 내용</th>
                    <td>
                        <div class="frm_info" style="margin-bottom:10px;">
                            <strong>TIP</strong>: [리스트 페이지] 하단의 '하단 정보 관리'에서 설정한 내용을 자동으로 가져오려면 다음 치환자를 사용하세요.<br>
                            주소: {addr} | 연락처: {tel} | 팩스: {fax} | 이메일: {email} | 로고: {logo} | 카피라이트: {copyright} | 링크:
                            {link1}, {link2}<br>
                            <span style="color:#3498db;">※ 현재 활성화된 테마(<?php echo $config['cf_theme']; ?>)와 동일한 ID로 생성하면
                                별도 설정 없이 자동으로 노출됩니다.</span>
                        </div>
                        <?php
                        // Fetch Default Config for Substitution
                        $default_cp = sql_fetch(" select * from {$table_name} where cp_id = 'default' ");

                        // Content to be displayed in Editor
                        $editor_content = $cp['cp_content'];

                        // If it's a new entry (w=''), start with default content if valid
                        if ($w == '' && $default_cp['cp_content']) {
                            $editor_content = $default_cp['cp_content'];
                        }

                        // Variable Substitution Logic (User Request: Show actual values in editor)
                        if ($default_cp) {
                            $replacements = array(
                                '{addr}' => $default_cp['addr_val'],
                                '{tel}' => $default_cp['tel_val'],
                                '{fax}' => $default_cp['fax_val'],
                                '{email}' => $default_cp['email_val'],
                                '{addr_name}' => $default_cp['addr_label'],
                                '{tel_name}' => $default_cp['tel_label'],
                                '{fax_name}' => $default_cp['fax_label'],
                                '{email_name}' => $default_cp['email_label'],
                                '{addr_label}' => $default_cp['addr_label'],
                                '{tel_label}' => $default_cp['tel_label'],
                                '{fax_label}' => $default_cp['fax_label'],
                                '{email_label}' => $default_cp['email_label'],
                                '{copyright}' => $default_cp['copyright'],
                                '{slogan}' => $default_cp['slogan'],
                                '{link1_name}' => $default_cp['link1_name'],
                                '{link1_url}' => $default_cp['link1_url'],
                                '{link2_name}' => $default_cp['link2_name'],
                                '{link2_url}' => $default_cp['link2_url'],
                                '{logo}' => ($default_cp['logo_url'] ? '<img src="' . $default_cp['logo_url'] . '" class="footer-logo">' : '')
                            );

                            // Also handle link tags
                            $replacements['{link1}'] = ($default_cp['link1_url'] ? '<a href="' . $default_cp['link1_url'] . '">' . $default_cp['link1_name'] . '</a>' : '');
                            $replacements['{link2}'] = ($default_cp['link2_url'] ? '<a href="' . $default_cp['link2_url'] . '">' . $default_cp['link2_name'] . '</a>' : '');

                            // Perform Substitution
                            foreach ($replacements as $key => $val) {
                                $editor_content = str_replace($key, $val, $editor_content);
                            }
                        }

                        echo editor_html('cp_content', get_text($editor_content, 0));
                        ?>
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
    // Pass PHP replacements to JS for dynamic skin loading
    var default_replacements = <?php echo json_encode($replacements ? $replacements : (object) array()); ?>;

    function load_template(skin) {
        if (!confirm('현재 에디터 내용이 소실됩니다. 진행하시겠습니까?')) return;

        // Auto-switch background color based on skin
        var skin_colors = {
            'style_a': '#ffffff',
            'style_b': '#1a1a1a',
            'style_c': '#111111',
            'style_d': '#ff3b30'
        };
        if (skin_colors[skin]) {
            $('#cp_bgcolor').val(skin_colors[skin]);
            $('#cp_bgcolor_picker').val(skin_colors[skin]);
        }

        $.ajax({
            url: '<?php echo G5_PLUGIN_URL; ?>/copyright_manager/adm/ajax.load_template.php',
            type: 'GET',
            data: {
                skin: skin,
                cp_id: '<?php echo $cp_id; ?>'
            },
            success: function (data) {
                // Perform substitution in JS before pasting
                var content = data;
                if (default_replacements) {
                    for (var key in default_replacements) {
                        // Global replace using regex with escaped key
                        var escapedKey = key.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                        var regex = new RegExp(escapedKey, 'g');
                        content = content.replace(regex, default_replacements[key]);
                    }
                }

                if (typeof oEditors !== 'undefined' && oEditors.getById["cp_content"]) {
                    oEditors.getById["cp_content"].exec("SET_IR", [""]); // Clear existing content
                    oEditors.getById["cp_content"].exec("PASTE_HTML", [content]); // Insert user-friendly substituted HTML

                    // 스킨 로드 후 배경색 동기화 (company_intro 방식)
                    setTimeout(function () {
                        update_editor_background($('#cp_bgcolor').val());
                    }, 500);
                } else {
                    alert('에디터 객체를 찾을 수 없습니다.');
                }
            },
            error: function () {
                alert('스킨 템플릿 파일을 불러오는데 실패했습니다.');
            }
        });
    }

    // 에디터 배경색 실시간 변경 (company_intro 벤치마킹)
    function update_editor_background(color) {
        if (typeof oEditors !== 'undefined' && oEditors.getById["cp_content"]) {
            try {
                // SmartEditor2의 편집 영역 접근
                var doc = oEditors.getById["cp_content"].getWYSIWYGDocument();

                // 1. Background Color
                if (color) {
                    doc.body.style.backgroundColor = color;
                    doc.body.style.setProperty('--cp-bg', color);

                    // Footer Skin Specific Background
                    var footer = doc.querySelector('.footer-skin-a, .footer-skin-b, .footer-skin-c');
                    if (footer) {
                        footer.style.backgroundColor = color;
                    }
                }
            } catch (e) {
                console.log("Editor access error: " + e);
            }
        }
    }

    function fcopyrightform_submit(f) {
        <?php echo get_editor_js('cp_content'); ?>
        return true;
    }

    // 배경색 기본값 복원 함수
    function restore_default_bgcolor(defaultColor) {
        if (!confirm('배경색을 테마 기본값(' + defaultColor + ')으로 초기화하시겠습니까?')) return;

        $('#cp_bgcolor').val(defaultColor);
        $('#cp_bgcolor_picker').val(defaultColor); // Color picker sync
        update_editor_background(defaultColor);
    }

    // 초기 로드시 및 텍스트박스 변경시 배경색 동기화
    $(function () {
        // 초기 로드 시 지연 실행
        setTimeout(function () {
            update_editor_background($('#cp_bgcolor').val());
        }, 1000);

        // 텍스트 인풋 변경 시에도 적용
        $('#cp_bgcolor').on('change keyup', function () {
            update_editor_background($(this).val());
        });
    });
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>