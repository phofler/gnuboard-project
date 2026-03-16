<?php
include_once('./_common.php');
include_once('../lib.php');
include_once(G5_EDITOR_LIB);

$sub_menu = "950350";
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
                    <th scope="row">식별코드 (ID)</th>
                    <td>
                        <?php
                        // Theme Discovery (Standard Pattern A)
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

                        // ID Parsing
                        $sel_theme = '';
                        $sel_lang = '';
                        $sel_custom = '';

                        if ($w == 'u' && isset($cp['cp_id']) && $cp['cp_id']) {
                            $parts = explode('_', $cp['cp_id']);
                            if (isset($parts[0]) && in_array($parts[0], $themes)) {
                                $sel_theme = $parts[0];
                                if (isset($parts[1]) && in_array($parts[1], array('kr', 'en', 'jp', 'cn'))) {
                                    $sel_lang = $parts[1];
                                    if (isset($parts[2])) {
                                        array_shift($parts);
                                        array_shift($parts);
                                        $sel_custom = implode('_', $parts);
                                    }
                                } else {
                                    if (isset($parts[1])) {
                                        array_shift($parts);
                                        $sel_custom = implode('_', $parts);
                                    }
                                }
                            } else if ($cp['cp_id'] == 'default') {
                                $sel_theme = '';
                                $sel_custom = 'default';
                            } else {
                                $sel_theme = '';
                                $sel_custom = $cp['cp_id'];
                            }
                        }
                        ?>
                        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                            <select name="cp_theme" id="cp_theme" class="frm_input" onchange="generate_id()" <?php echo $readonly ? 'disabled' : ''; ?>>
                                <option value="">테마 선택</option>
                                <?php foreach ($themes as $theme) {
                                    $selected = ($theme == $sel_theme) ? 'selected' : '';
                                    echo '<option value="' . $theme . '" ' . $selected . '>' . $theme . '</option>';
                                } ?>
                            </select>
                            <select name="cp_lang" id="cp_lang" class="frm_input" onchange="generate_id()" <?php echo $readonly ? 'disabled' : ''; ?>>
                                <option value="">언어 선택</option>
                                <option value="kr" <?php echo ($sel_lang == 'kr' ? 'selected' : ''); ?>>한국어</option>
                                <option value="en" <?php echo ($sel_lang == 'en' ? 'selected' : ''); ?>>English</option>
                                <option value="jp" <?php echo ($sel_lang == 'jp' ? 'selected' : ''); ?>>Japanese</option>
                                <option value="cn" <?php echo ($sel_lang == 'cn' ? 'selected' : ''); ?>>Chinese</option>
                            </select>
                            <input type="text" name="cp_custom" id="cp_custom" value="<?php echo $sel_custom; ?>"
                                class="frm_input" placeholder="커스텀 이름 (영문/숫자)" onkeyup="generate_id()" <?php echo $readonly ? 'readonly' : ''; ?>>
                        </div>
                        <div
                            style="margin-top:8px; font-size:12px; color:#666; padding:10px; background:#f9f9f9; border:1px solid #eee; display:inline-block;">
                            생성된 식별코드(ID): <strong id="generated_id_display"
                                style="color:#d4af37; font-size:1.1em;"><?php echo isset($cp['cp_id']) ? $cp['cp_id'] : '-'; ?></strong>
                        </div>
                        <p class="frm_info" style="margin-top:5px;">테마와 언어를 선택하면 식별코드가 자동으로 생성됩니다.</p>
                        <input type="hidden" name="cp_id" id="cp_id"
                            value="<?php echo isset($cp['cp_id']) ? $cp['cp_id'] : ''; ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="cp_subject">제목 (관리용)</label></th>
                    <td>
                        <input type="text" name="cp_subject" value="<?php echo get_text($cp['cp_subject']); ?>"
                            id="cp_subject" required class="frm_input" size="60">
                    </td>
                </tr>

                <tr>
                    <th scope="row">하단 정보 (Quick Info)</th>
                    <td>
                        <div style="background:#f9f9f9; padding:20px; border-radius:8px; border:1px solid #eee;">
                            <div style="margin-bottom:15px;">
                                <label style="display:inline-block; width:120px; font-weight:bold;">하단 로고</label>
                                <input type="file" name="logo_file" id="logo_file" class="frm_input">
                                <?php if ($cp['logo_url']): ?>
                                    <div
                                        style="margin-top:5px; background:#333; display:inline-block; padding:5px; border-radius:4px;">
                                        <img src="<?php echo $cp['logo_url']; ?>" style="max-height:30px;">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div style="margin-bottom:15px;">
                                <label for="slogan"
                                    style="display:inline-block; width:120px; font-weight:bold;">슬로건</label>
                                <input type="text" name="slogan" value="<?php echo get_text($cp['slogan'] ?? ''); ?>"
                                    id="slogan" class="frm_input" size="60">
                            </div>

                            <div style="display:flex; gap:20px; margin-bottom:15px;">
                                <div style="flex:1;">
                                    <label for="addr_val" style="display:block; font-weight:bold; margin-bottom:5px;">주소
                                        (Address)</label>
                                    <input type="text" name="addr_label"
                                        value="<?php echo get_text(($cp['addr_label'] ?? '') ?: 'ADD'); ?>"
                                        class="frm_input" size="10" placeholder="라벨">
                                    <input type="text" name="addr_val"
                                        value="<?php echo get_text($cp['addr_val'] ?? ''); ?>" id="addr_val"
                                        class="frm_input" style="width:calc(100% - 100px);" placeholder="내용">
                                </div>
                                <div style="flex:1;">
                                    <label for="tel_val" style="display:block; font-weight:bold; margin-bottom:5px;">연락처
                                        (Tel)</label>
                                    <input type="text" name="tel_label"
                                        value="<?php echo get_text(($cp['tel_label'] ?? '') ?: 'TEL'); ?>"
                                        class="frm_input" size="10" placeholder="라벨">
                                    <input type="text" name="tel_val"
                                        value="<?php echo get_text($cp['tel_val'] ?? ''); ?>" id="tel_val"
                                        class="frm_input" style="width:calc(100% - 100px);" placeholder="내용">
                                </div>
                            </div>

                            <div style="display:flex; gap:20px; margin-bottom:15px;">
                                <div style="flex:1;">
                                    <label for="fax_val" style="display:block; font-weight:bold; margin-bottom:5px;">팩스
                                        (Fax)</label>
                                    <input type="text" name="fax_label"
                                        value="<?php echo get_text(($cp['fax_label'] ?? '') ?: 'FAX'); ?>"
                                        class="frm_input" size="10" placeholder="라벨">
                                    <input type="text" name="fax_val"
                                        value="<?php echo get_text($cp['fax_val'] ?? ''); ?>" id="fax_val"
                                        class="frm_input" style="width:calc(100% - 100px);" placeholder="내용">
                                </div>
                                <div style="flex:1;">
                                    <label for="email_val"
                                        style="display:block; font-weight:bold; margin-bottom:5px;">이메일 (Email)</label>
                                    <input type="text" name="email_label"
                                        value="<?php echo get_text(($cp['email_label'] ?? '') ?: 'EMAIL'); ?>"
                                        class="frm_input" size="10" placeholder="라벨">
                                    <input type="text" name="email_val"
                                        value="<?php echo get_text($cp['email_val'] ?? ''); ?>" id="email_val"
                                        class="frm_input" style="width:calc(100% - 100px);" placeholder="내용">
                                </div>
                            </div>

                            <div style="display:flex; gap:20px;">
                                <div style="flex:1;">
                                    <label for="link1_url"
                                        style="display:block; font-weight:bold; margin-bottom:5px;">링크 1 (Privacy Policy
                                        등)</label>
                                    <input type="text" name="link1_name"
                                        value="<?php echo get_text($cp['link1_name'] ?? ''); ?>" class="frm_input"
                                        size="15" placeholder="링크명">
                                    <input type="text" name="link1_url"
                                        value="<?php echo get_text($cp['link1_url'] ?? ''); ?>" id="link1_url"
                                        class="frm_input" style="width:calc(100% - 140px);" placeholder="URL">
                                </div>
                                <div style="flex:1;">
                                    <label for="link2_url"
                                        style="display:block; font-weight:bold; margin-bottom:5px;">링크 2 (Terms
                                        등)</label>
                                    <input type="text" name="link2_name"
                                        value="<?php echo get_text($cp['link2_name'] ?? ''); ?>" class="frm_input"
                                        size="15" placeholder="링크명">
                                    <input type="text" name="link2_url"
                                        value="<?php echo get_text($cp['link2_url'] ?? ''); ?>" id="link2_url"
                                        class="frm_input" style="width:calc(100% - 140px);" placeholder="URL">
                                </div>
                            </div>

                            <div style="margin-top:15px;">
                                <label for="copyright"
                                    style="display:inline-block; width:120px; font-weight:bold;">카피라이트 문구</label>
                                <input type="text" name="copyright"
                                    value="<?php echo get_text($cp['copyright'] ?? ''); ?>" id="copyright"
                                    class="frm_input" size="80">
                            </div>
                            <input type="hidden" name="logo_url" value="<?php echo $cp['logo_url'] ?? ''; ?>">
                        </div>
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
                                        <span class="skin-desc" style="color:#ff3b30; font-weight:bold;">Editorial
                                            Bold</span>
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
                        <div class="frm_info" style="margin-bottom:10px; color:#2980b9;">
                            ※ 위 하단 정보(Quick Info)에 입력한 내용은 <strong>{addr}, {tel}, {fax}, {email}, {logo}, {copyright},
                                {link1}, {link2}</strong> 치환자로 자동 치환되어 에디터에 로드됩니다.
                        </div>
                        <?php
                        $content = isset($cp['cp_content']) ? $cp['cp_content'] : '';

                        // Auto-recovery: If content starts with escaped HTML tag (e.g. &lt;div, &lt;p), decode it
                        // This handles the "corrupted" DB data case
                        if (preg_match('/^\s*&lt;[a-z]+/', $content) || preg_match('/^\s*&amp;lt;/', $content)) {
                            $content = html_entity_decode($content);
                            // Double decode check for &amp;lt; case
                            if (preg_match('/^\s*&lt;[a-z]+/', $content)) {
                                $content = html_entity_decode($content);
                            }
                        }

                        echo editor_html('cp_content', $content);
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
    // Pattern A: Dynamic ID Generation (Standardized)
    function generate_id() {
        var theme = $('#cp_theme').val();
        var lang = $('#cp_lang').val();
        var custom = $('#cp_custom').val().trim();

        if (custom === 'default') {
            $('#generated_id_display').text('default');
            $('#cp_id').val('default');
            return;
        }

        if (!theme) {
            // If custom input exists but no theme, use custom as ID (Legacy support or Pure Custom)
            if (custom) {
                $('#generated_id_display').text(custom);
                $('#cp_id').val(custom);
            } else {
                $('#generated_id_display').text('-');
                $('#cp_id').val('');
            }
            return;
        }

        var new_id = theme;
        if (lang && lang !== 'kr') {
            new_id += '_' + lang;
        }
        if (custom) {
            new_id += '_' + custom.replace(/[^a-z0-9_]/gi, '');
        }

        $('#generated_id_display').text(new_id);
        $('#cp_id').val(new_id);
    }

    // Initial ID Generation trigger if in write mode
    $(document).ready(function () {
        // Only auto-generate if we ALREADY HAVE AN ID (Edit mode)
        // For new entries, wait for theme selection
        if ($('#cp_id').val()) {
            generate_id();
        }
    });

    function load_template(skin) {
        if (!confirm('현재 에디터의 내용이 삭제되고 선택한 스킨의 기본 템플릿으로 변경됩니다. 계속하시겠습니까?')) return;

        // Collect Quick Info for live replacement
        // Collect Quick Info for live replacement (matching template.html placeholders)
        var replacements = {
            '{addr}': $('#addr_val').val(),
            '{tel}': $('#tel_val').val(),
            '{fax}': $('#fax_val').val(),
            '{email}': $('#email_val').val(),
            '{addr_name}': $('input[name="addr_label"]').val(),
            '{tel_name}': $('input[name="tel_label"]').val(),
            '{fax_name}': $('input[name="fax_label"]').val(),
            '{email_name}': $('input[name="email_label"]').val(),
            '{logo}': $('input[name="logo_url"]').val() ? '<img src="' + $('input[name="logo_url"]').val() + '" class="footer-logo">' : '',
            '{copyright}': $('#copyright').val(),
            '{slogan}': $('#slogan').val()
        };

        $.ajax({
            url: './ajax.load_template.php',
            type: 'POST',
            data: {
                skin: skin
            },
            dataType: 'json',
            success: function (res) {
                if (res.error) {
                    alert(res.error);
                    return;
                }

                var content = res.template;

                // Add link 1 & 2 replacements if provided
                var link1_name = $('input[name="link1_name"]').val();
                var link1_url = $('#link1_url').val();
                var link2_name = $('input[name="link2_name"]').val();
                var link2_url = $('#link2_url').val();

                replacements['{link1}'] = link1_name ? '<a href="' + link1_url + '">' + link1_name + '</a>' : '';
                replacements['{link2}'] = link2_name ? '<a href="' + link2_url + '">' + link2_name + '</a>' : '';

                // Substitute values
                for (var key in replacements) {
                    var regex = new RegExp(key.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
                    content = content.replace(regex, replacements[key]);
                }

                if (typeof oEditors !== 'undefined' && oEditors.getById["cp_content"]) {
                    oEditors.getById["cp_content"].exec("SET_IR", [content]); // Replace content directly

                    // Sync background color after load
                    setTimeout(function () {
                        update_editor_background($('#cp_bgcolor').val());
                    }, 300);
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
        if (!color) return;
        if (typeof oEditors !== 'undefined' && oEditors.getById["cp_content"]) {
            try {
                var doc = oEditors.getById["cp_content"].getWYSIWYGDocument();
                if (doc && doc.body) {
                    doc.body.style.backgroundColor = color;
                    doc.body.style.setProperty('--cp-bg', color);

                    // Try to find any container and force background
                    var containers = doc.querySelectorAll('.footer-skin-a, .footer-skin-b, .footer-skin-c, .footer-skin-d');
                    containers.forEach(function (el) {
                        el.style.backgroundColor = color;
                    });
                }
            } catch (e) {
                console.log("Editor Background Sync Error: " + e);
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
        // 초기 로드 시 지연 실행 (더 빠르게 반응하도록 조정)
        setTimeout(function () {
            update_editor_background($('#cp_bgcolor').val());
        }, 500);

        // 텍스트 인풋 변경 시에도 적용
        $('#cp_bgcolor').on('change keyup', function () {
            update_editor_background($(this).val());
        });
    });
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>