<?php
$sub_menu = "950400";
include_once('./_common.php');
include_once('../lib/map.lib.php');
include_once('./check_db.php');

$html_title = '지도 설정';
$readonly = '';

if ($w == 'u') {
    $html_title .= ' 수정';
    $readonly = ' readonly';
} else {
    $html_title .= ' 입력';
}

$ma_id = isset($_REQUEST['ma_id']) ? clean_xss_tags($_REQUEST['ma_id']) : '';

$map = array();
if ($w == 'u' && $ma_id) {
    $map = sql_fetch(" SELECT * FROM {$table_name} WHERE ma_id = '{$ma_id}' ");
    if (!$map) {
        alert('존재하지 않는 자료입니다.');
    }
} else {
    // Defaults
    $map = array(
        'ma_id' => '',
        'ma_provider' => 'naver',
        'ma_lat' => '37.5665',
        'ma_lng' => '126.9780',
        'ma_api_key' => '',
        'ma_client_id' => ''
    );
}

$g5['title'] = $html_title;
include_once(G5_ADMIN_PATH . '/admin.head.php');
?>

<form name="fmapform" id="fmapform" action="./write_update.php" onsubmit="return fmapform_submit(this);" method="post">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="token" value="<?php echo get_admin_token(); ?>">

    <div class="btn_fixed_top">
        <input type="submit" value="확인" class="btn_submit btn">
        <a href="./list.php" class="btn btn_02">목록</a>
    </div>

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

                        // ID Parsing for Edit Mode via Pattern Matching
                        $sel_theme = '';
                        $sel_lang = '';
                        $sel_custom = '';

                        if ($w == 'u' && $map['ma_id']) {
                            $parts = explode('_', $map['ma_id']);
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
                            } else if ($map['ma_id'] == 'default') {
                                $sel_theme = '';
                                $sel_custom = 'default';
                            } else {
                                $sel_theme = '';
                                $sel_custom = $map['ma_id'];
                            }
                        }
                        ?>
                        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                            <select name="ma_theme" id="ma_theme" class="frm_input" onchange="generate_id()" <?php echo $readonly ? 'disabled' : ''; ?>>
                                <option value="">테마 선택</option>
                                <?php foreach ($themes as $theme) {
                                    $selected = ($theme == $sel_theme) ? 'selected' : '';
                                    echo '<option value="' . $theme . '" ' . $selected . '>' . $theme . '</option>';
                                } ?>
                            </select>
                            <select name="ma_lang" id="ma_lang" class="frm_input" onchange="generate_id()" <?php echo $readonly ? 'disabled' : ''; ?>>
                                <option value="">언어 선택</option>
                                <option value="kr" <?php echo ($sel_lang == 'kr' ? 'selected' : ''); ?>>한국어</option>
                                <option value="en" <?php echo ($sel_lang == 'en' ? 'selected' : ''); ?>>English</option>
                                <option value="jp" <?php echo ($sel_lang == 'jp' ? 'selected' : ''); ?>>Japanese</option>
                                <option value="cn" <?php echo ($sel_lang == 'cn' ? 'selected' : ''); ?>>Chinese</option>
                            </select>
                            <input type="text" name="ma_custom" id="ma_custom" value="<?php echo $sel_custom; ?>"
                                class="frm_input" placeholder="커스텀 이름 (영문/숫자)" onkeyup="generate_id()" <?php echo $readonly ? 'readonly' : ''; ?>>
                        </div>
                        <div
                            style="margin-top:8px; font-size:12px; color:#666; padding:10px; background:#f9f9f9; border:1px solid #eee; display:inline-block;">
                            식별코드(ID): <strong id="generated_id_display" style="color:#d4af37; font-size:1.1em;">
                                <?php echo $map['ma_id']; ?>
                            </strong>
                        </div>
                        <input type="hidden" name="ma_id" id="ma_id" value="<?php echo $map['ma_id']; ?>">
                    </td>
                </tr>

                <tr>
                    <th scope="row">지도 서비스 제공자</th>
                    <td>
                        <input type="radio" name="ma_provider" value="naver" id="p_naver" <?php echo ($map['ma_provider'] == 'naver') ? 'checked' : ''; ?>> <label for="p_naver">네이버
                            (Naver)</label>
                        &nbsp;&nbsp;
                        <input type="radio" name="ma_provider" value="google" id="p_google" <?php echo ($map['ma_provider'] == 'google') ? 'checked' : ''; ?>> <label for="p_google">구글
                            (Google)</label>
                        &nbsp;&nbsp;
                        <input type="radio" name="ma_provider" value="kakao" id="p_kakao" <?php echo ($map['ma_provider'] == 'kakao') ? 'checked' : ''; ?>> <label for="p_kakao">카카오
                            (Kakao)</label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">네이버 Client ID</th>
                    <td>
                        <input type="text" name="ma_client_id" value="<?php echo $map['ma_client_id']; ?>"
                            class="frm_input" size="50">
                        <span class="frm_info">네이버 지도 선택 시 필수</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">구글/카카오 API Key</th>
                    <td>
                        <input type="text" name="ma_api_key" value="<?php echo $map['ma_api_key']; ?>" class="frm_input"
                            size="50">
                        <span class="frm_info">구글/카카오 지도 선택 시 필수</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">위도 (Latitude)</th>
                    <td>
                        <input type="text" name="ma_lat" value="<?php echo $map['ma_lat']; ?>" class="frm_input"
                            required>
                    </td>
                </tr>
                <tr>
                    <th scope="row">경도 (Longitude)</th>
                    <td>
                        <input type="text" name="ma_lng" value="<?php echo $map['ma_lng']; ?>" class="frm_input"
                            required>
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
    function generate_id() {
        var theme = $('#ma_theme').val();
        var lang = $('#ma_lang').val();
        var custom = $('#ma_custom').val().trim().replace(/[^a-z0-9_]/gi, '');
        document.getElementById('ma_custom').value = custom; // Filter input live

        if (custom === 'default') {
            $('#generated_id_display').text('default');
            $('#ma_id').val('default');
            return;
        }

        if (!theme) {
            if (custom) {
                $('#generated_id_display').text(custom);
                $('#ma_id').val(custom);
            } else {
                $('#generated_id_display').text('-');
                $('#ma_id').val('');
            }
            return;
        }

        var new_id = theme;
        if (lang && lang !== 'kr') new_id += '_' + lang;
        if (custom) new_id += '_' + custom;

        $('#generated_id_display').text(new_id);
        $('#ma_id').val(new_id);
    }

    function fmapform_submit(f) {
        if ($('#ma_id').val() == '') {
            alert('식별코드가 생성되지 않았습니다. 테마를 선택하거나 커스텀 이름을 입력해주세요.');
            return false;
        }
        return true;
    }

    $(function () {
        if ($('#ma_id').val()) {
            generate_id();
        }
    });
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>