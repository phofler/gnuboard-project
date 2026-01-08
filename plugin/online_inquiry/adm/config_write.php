<?php
$sub_menu = '800300';
define('G5_IS_ADMIN', true);
include_once(dirname(__FILE__) . '/../_common.php');

if (!defined('G5_ADMIN_PATH')) {
    define('G5_ADMIN_PATH', G5_PATH . '/adm');
}
include_once(G5_ADMIN_PATH . '/admin.lib.php');
include_once(G5_EDITOR_LIB);
include_once(G5_PATH . '/lib/theme_css.lib.php');

auth_check_menu($auth, $sub_menu, 'w');

$g5['title'] = '온라인 문의 설정 등록/수정';
include_once(G5_ADMIN_PATH . '/admin.head.php');
?>

<style>
    /* Premium Skin Selector Grid */
    .skin-selector-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .skin-item-card {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 0;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #fff;
        overflow: hidden;
        position: relative;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .skin-preview-wrap {
        width: 100%;
        height: 160px;
        background: #f8fafc;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid #f1f5f9;
    }

    .skin-preview-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .skin-item-card:hover .skin-preview-wrap img {
        transform: scale(1.05);
    }

    .skin-info-wrap {
        padding: 15px;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .skin-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #64748b;
    }

    .skin-item-card.active {
        border-color: #3498db;
        border-width: 2px;
        box-shadow: 0 10px 15px -3px rgba(52, 152, 219, 0.2);
    }

    .skin-item-card.active .skin-icon-box {
        background: #3498db;
        color: #fff;
    }

    .skin-label-text {
        font-weight: 700;
        color: #1e293b;
        font-size: 15px;
        margin-bottom: 2px;
    }

    .skin-desc-text {
        font-size: 12px;
        color: #64748b;
    }

    .skin-active-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #3498db;
        color: #fff;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        opacity: 0;
        transform: translateY(-5px);
        transition: all 0.3s;
        z-index: 10;
    }

    .skin-item-card.active .skin-active-badge {
        opacity: 1;
        transform: translateY(0);
    }

    /* Admin Responsiveness */
    @media (max-width: 768px) {
        .tbl_frm01 th {
            width: 100% !important;
            display: block !important;
            padding: 15px !important;
            background: #f8f9fa !important;
            border-bottom: 0 !important;
        }

        .tbl_frm01 td {
            width: 100% !important;
            display: block !important;
            padding: 15px !important;
        }

        .skin-selector-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php
$config_table = G5_TABLE_PREFIX . 'plugin_online_inquiry_config';

$oi_id = isset($_REQUEST['oi_id']) ? clean_xss_tags($_REQUEST['oi_id']) : '';
$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';

$row = array(
    'oi_id' => '',
    'theme' => $config['cf_theme'],
    'lang' => 'kr',
    'skin' => 'basic',
    'subject' => '',
    'content' => '',
    'label_name' => 'Name',
    'label_phone' => 'Phone',
    'label_msg' => 'Message',
    'label_submit' => 'Submit',
    'oi_bgcolor' => ''
);

if ($w == 'u' && $oi_id) {
    $row = sql_fetch(" select * from {$config_table} where oi_id = '{$oi_id}' ");
    if (!$row)
        alert('존재하지 않는 설정입니다.');
} else if ($w == '') {
    // New entry: Load default template (basic)
    $tpl_path = dirname(__FILE__) . '/../skin/user/basic/template.html';
    if (file_exists($tpl_path)) {
        $row['content'] = file_get_contents($tpl_path);
    }
}

// Scan Skins
$skin_dir = dirname(__FILE__) . '/../skin/user';
$skins = array();
if (is_dir($skin_dir)) {
    $dir = dir($skin_dir);
    while ($entry = $dir->read()) {
        if ($entry != '.' && $entry != '..') {
            if (is_dir($skin_dir . '/' . $entry))
                $skins[] = $entry;
        }
    }
    $dir->close();
}
sort($skins);

// Theme Discovery
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

// ID Parsing for Edit Mode
$sel_theme = $row['theme'];
$sel_lang = $row['lang'];
$sel_custom = '';

if ($w == 'u' && $row['oi_id']) {
    $parts = explode('_', $row['oi_id']);
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

// [DYNAMIC THEME BG] Always prioritize ACTIVE SITE THEME for the "Absolute Default" reference
$theme_bg_default = get_theme_css_value($config['cf_theme'], array('--color-bg', '--color-bg-dark'), '#121212');
$theme_text_default = get_theme_css_value($config['cf_theme'], array('--color-text-primary'), '#e0e0e0');

// Preview logic: if stored bgcolor exists, use it; otherwise use the site's default
$preview_bg = (isset($row['oi_bgcolor']) && $row['oi_bgcolor']) ? $row['oi_bgcolor'] : $theme_bg_default;
?>

<form name="fconfigform" method="post" action="./config_update.php" onsubmit="return fconfigform_submit(this);"
    enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="old_oi_id" value="<?php echo $row['oi_id']; ?>">

    <div class="tbl_frm01 tbl_wrap">
        <table>
            <caption>
                <?php echo $g5['title']; ?>
            </caption>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row">설정 대상 (Theme & Lang)</th>
                    <td>
                        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                            <select name="oi_theme" id="oi_theme" class="frm_input" onchange="generate_oi_id()"
                                required>
                                <option value="">테마 선택</option>
                                <?php foreach ($themes as $theme) {
                                    $selected = ($theme == $sel_theme) ? 'selected' : '';
                                    $t_bg = get_theme_css_value($theme, array('--color-bg', '--color-bg-dark'), '#121212');
                                    $t_text = get_theme_css_value($theme, array('--color-text-primary'), '#e0e0e0');
                                    echo '<option value="' . $theme . '" ' . $selected . ' data-bg="' . $t_bg . '" data-text="' . $t_text . '">' . $theme . '</option>';
                                } ?>
                            </select>
                            <select name="oi_lang" id="oi_lang" class="frm_input" onchange="generate_oi_id()">
                                <option value="kr" <?php echo ($sel_lang == 'kr' ? 'selected' : ''); ?>>한국어 (기본)</option>
                                <option value="en" <?php echo ($sel_lang == 'en' ? 'selected' : ''); ?>>English (EN)
                                </option>
                                <option value="jp" <?php echo ($sel_lang == 'jp' ? 'selected' : ''); ?>>Japanese (JP)
                                </option>
                                <option value="cn" <?php echo ($sel_lang == 'cn' ? 'selected' : ''); ?>>Chinese (CN)
                                </option>
                            </select>
                            <input type="text" name="oi_custom" id="oi_custom" value="<?php echo $sel_custom; ?>"
                                class="frm_input" placeholder="커스텀 이름 (선택)" onkeyup="generate_oi_id()">
                        </div>
                        <div
                            style="margin-top:8px; font-size:12px; color:#666; padding:10px; background:#f9f9f9; border:1px solid #eee; display:inline-block;">
                            생성된 식별코드(ID): <strong id="generated_id_display"
                                style="color:#d4af37; font-size:1.1em;"><?php echo $row['oi_id'] ? $row['oi_id'] : '-'; ?></strong>
                        </div>
                        <p class="frm_info" style="margin-top:5px;">테마와 언어를 선택하면 식별코드가 자동으로 생성됩니다.</p>
                        <input type="hidden" name="oi_id" id="oi_id" value="<?php echo $row['oi_id']; ?>">
                    </td>
                </tr>

                <tr>
                    <th scope="row">스킨 선택 (Skin Type)</th>
                    <td>
                        <input type="hidden" name="skin" id="skin_id" value="<?php echo $row['skin']; ?>">
                        <div class="skin-selector-grid">
                            <?php
                            $skin_info = array(
                                'basic' => array('Classic Basic', 'fa-align-left', '표준형 입력 폼'),
                                'corporate' => array('Premium Editorial', 'fa-building', '테마 맞춤형 디자인'),
                                'modern' => array('Modern Minimal', 'fa-cube', '세련된 미니멀 디자인')
                            );

                            foreach ($skins as $sk) {
                                $display_name = isset($skin_info[$sk]) ? $skin_info[$sk][0] : $sk;
                                $icon = isset($skin_info[$sk]) ? $skin_info[$sk][1] : 'fa-paint-brush';
                                $desc = isset($skin_info[$sk]) ? $skin_info[$sk][2] : '플러그인 기본 스킨';
                                $active = ($row['skin'] == $sk) ? 'active' : '';
                                $preview = ONLINE_INQUIRY_URL . '/skin/user/' . $sk . '/preview.png';
                                ?>
                                <div class="skin-item-card <?php echo $active; ?>"
                                    onclick="select_premium_skin('<?php echo $sk; ?>', this)">
                                    <div class="skin-active-badge"><i class="fa fa-check-circle"></i> SELECTED</div>
                                    <div class="skin-preview-wrap">
                                        <img src="<?php echo $preview; ?>"
                                            onerror="this.src='https://placehold.co/400x200?text=No+Preview'">
                                    </div>
                                    <div class="skin-info-wrap">
                                        <div class="skin-icon-box">
                                            <i class="fa <?php echo $icon; ?>"></i>
                                        </div>
                                        <div>
                                            <div class="skin-label-text"><?php echo $display_name; ?></div>
                                            <div class="skin-desc-text"><?php echo $desc; ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div
                            style="background:#fffcf5; border:1px solid #ffeeba; padding:15px; border-radius:12px; display:flex; align-items:center; gap:12px; margin-top:10px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                            <i class="fa fa-exclamation-triangle" style="color:#f39c12; font-size:20px;"></i>
                            <div style="color:#856404; font-size:13px; font-weight:600;">스킨을 선택하면 기본 양식이 에디터에 자동으로
                                입력됩니다. 기존 내용은 삭제되니 주의하세요.</div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="oi_bgcolor">배경색 선택</label></th>
                    <td>
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
                        <div class="color_picker_wrapper" style="display:flex; align-items:center; gap:10px;">
                            <input type="color" id="oi_bgcolor_picker" value="<?php echo $preview_bg; ?>"
                                onchange="$('#oi_bgcolor').val(this.value); update_editor_bg(this.value);">
                            <input type="text" name="oi_bgcolor"
                                value="<?php echo isset($row['oi_bgcolor']) ? $row['oi_bgcolor'] : ''; ?>"
                                id="oi_bgcolor" class="frm_input" size="10"
                                placeholder="기본값 (<?php echo $theme_bg_default; ?>)">
                            <button type="button" class="btn btn_02 btn_sm" onclick="reset_bgcolor()">기본값으로 복원</button>
                        </div>
                        <span class="frm_info">이 페이지의 배경색을 선택하세요. 기본값은 테마의
                            <strong id="theme_bg_label"><?php echo $theme_bg_default; ?></strong> 입니다.</span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">입력 폼 라벨 (Labels)</th>
                    <td>
                        <div style="display:grid; grid-template-columns: repeat(2, 1fr); gap:10px;">
                            <div class="input-group">
                                <span class="frm_info" style="margin-bottom:2px;">이름 필드 라벨</span>
                                <input type="text" name="label_name" value="<?php echo get_text($row['label_name']); ?>"
                                    class="frm_input" style="width:100%" placeholder="Name">
                            </div>
                            <div class="input-group">
                                <span class="frm_info" style="margin-bottom:2px;">연락처 필드 라벨</span>
                                <input type="text" name="label_phone"
                                    value="<?php echo get_text($row['label_phone']); ?>" class="frm_input"
                                    style="width:100%" placeholder="Phone">
                            </div>
                            <div class="input-group">
                                <span class="frm_info" style="margin-bottom:2px;">메시지 필드 라벨</span>
                                <input type="text" name="label_msg" value="<?php echo get_text($row['label_msg']); ?>"
                                    class="frm_input" style="width:100%" placeholder="Message">
                            </div>
                            <div class="input-group">
                                <span class="frm_info" style="margin-bottom:2px;">전송 버튼 텍스트</span>
                                <input type="text" name="label_submit"
                                    value="<?php echo get_text($row['label_submit']); ?>" class="frm_input"
                                    style="width:100%" placeholder="Submit">
                            </div>
                        </div>
                        <p class="frm_info" style="color:#d4af37;">※ 선택한 언어(예: English)에 맞춰 각 필드의 안내 문구와 버튼 텍스트를 수정하세요.
                        </p>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="subject">페이지 제목</label></th>
                    <td>
                        <input type="text" name="subject" value="<?php echo get_text($row['subject']); ?>" id="subject"
                            class="frm_input" size="50" style="width:100%; max-width:400px;"
                            placeholder="예: 온라인 문의, Contact Us">
                        <span class="frm_info">페이지 상단에 표시될 제목입니다.</span>
                    </td>
                </tr>

                <tr>
                    <th scope="row">내용 (상단 안내글)</th>
                    <td>
                        <?php echo editor_html('content', $row['content']); ?>
                        <div style="margin-top:10px; color:#666;">
                            * 이곳에 작성한 내용이 문의 폼 <strong>위쪽</strong>에 표시됩니다.<br>
                            * 지도, 주소, 연락처 안내 등을 자유롭게 작성하세요.
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="저장 완료" class="btn_submit btn">
        <a href="./skin_list.php" class="btn_cancel btn">목록으로</a>
    </div>
</form>

<script>
    function select_premium_skin(skin, el) {
        if ($('#skin_id').val() == skin) return;

        if (confirm("스킨을 변경하시겠습니까?\n변경 시 에디터에 작성된 내용이 해당 스킨의 기본 양식으로 초기화됩니다.")) {
            $('.skin-item-card').removeClass('active');
            $(el).addClass('active');
            $('#skin_id').val(skin);
            change_oi_skin(skin);
        }
    }

    function change_oi_skin(skin_name) {
        $.ajax({
            url: '../skin/user/' + skin_name + '/template.html?v=' + Math.random(),
            dataType: 'html',
            success: function (data) {
                if (typeof oEditors !== 'undefined' && oEditors.getById["content"]) {
                    oEditors.getById["content"].exec("SET_IR", [""]);
                    setTimeout(function () {
                        oEditors.getById["content"].exec("PASTE_HTML", [data]);
                    }, 100);

                    // Corporate 스킨인 경우 에디터 배경색 자동 조절 (Dark Mode Preview)
                    if (skin_name == 'corporate') {
                        update_editor_bg("#121212");
                    } else {
                        update_editor_bg("#ffffff");
                    }
                }
            },
            error: function () {
                console.log('스킨 템플릿 파일이 없거나 로드에 실패했습니다.');
            }
        });
    }

    function update_editor_bg(color) {
        if (typeof oEditors !== 'undefined' && oEditors.getById["content"]) {
            try {
                var doc = oEditors.getById["content"].getWYSIWYGDocument();

                var targetColor = color;
                if (!targetColor) targetColor = theme_bg_default;

                doc.body.style.backgroundColor = targetColor;
                if (targetColor == theme_bg_default) {
                    doc.body.style.color = theme_text_default;
                } else if (targetColor == "#121212" || targetColor == "#000000") {
                    doc.body.style.color = "#eee";
                } else if (targetColor == "#ffffff" || targetColor == "#f3f3f3") {
                    doc.body.style.color = "#121212";
                }
            } catch (e) { }
        }
    }

    function generate_oi_id() {
        var theme = $('#oi_theme').val();
        var lang = $('#oi_lang').val();
        var custom = $('#oi_custom').val().trim();

        if (!theme) {
            $('#generated_id_display').text('-');
            $('#oi_id').val('');
            return;
        }

        // Live color update via select attribute (pre-loaded)
        var selected_opt = $('#oi_theme option:selected');
        var selected_bg = selected_opt.data('bg');
        var selected_text = selected_opt.data('text');
        if (selected_bg) {
            update_theme_ui(selected_bg, selected_text);
        }

        var id = theme;
        if (lang && lang != 'kr') id += '_' + lang;
        if (custom) id += '_' + custom.replace(/[^a-z0-9_]/gi, '');

        $('#generated_id_display').text(id);
        $('#oi_id').val(id);
    }

    var theme_bg_default = '<?php echo $theme_bg_default; ?>';
    var theme_text_default = '<?php echo $theme_text_default; ?>';

    function update_theme_ui(bg, text) {
        theme_bg_default = bg;
        if (text) theme_text_default = text;

        $('#theme_bg_label').text(bg);
        $('#oi_bgcolor').attr('placeholder', '기본값 (' + bg + ')');

        // If no custom color is set, update visual preview
        if (!$('#oi_bgcolor').val()) {
            $('#oi_bgcolor_picker').val(bg);
            update_editor_bg(bg);
        }
    }

    function fconfigform_submit(f) {
        if (!f.oi_id.value) {
            alert('테마를 선택하여 식별코드를 생성해주세요.');
            f.oi_theme.focus();
            return false;
        }
        <?php echo get_editor_js('content'); ?>
        return true;
    }

    function reset_bgcolor() {
        $('#oi_bgcolor').val('');
        $('#oi_bgcolor_picker').val(theme_bg_default);
        update_editor_bg(theme_bg_default);
    }

    $(document).ready(function () {
        if (!$('#oi_id').val()) generate_oi_id();

        $('#oi_bgcolor').on('input change', function () {
            update_editor_bg($(this).val());
        });

        // 초기 로드시 스킨/배경색 설정
        setTimeout(function () {
            var current_bg = $('#oi_bgcolor').val();
            if (!current_bg) current_bg = theme_bg_default;
            update_editor_bg(current_bg);
        }, 1000);
    });
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>