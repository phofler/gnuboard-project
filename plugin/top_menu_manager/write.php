<?php
$sub_menu = "800150";
include_once('./_common.php');

define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!$is_admin) {
    alert('관리자만 접근 가능합니다.');
}

$tm_id = isset($_REQUEST['tm_id']) ? $_REQUEST['tm_id'] : '';
$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';

$plugin_path = G5_PLUGIN_PATH . '/top_menu_manager';
$skins_path = $plugin_path . '/skins';

// Load existing config if edit mode
$tm = array(
    'tm_id' => '',
    'tm_skin' => 'basic',
    'tm_menu_table' => '',
    'tm_logo_pc' => '',
    'tm_logo_mo' => ''
);

if ($w == 'u' && $tm_id) {
    $tm = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");
    if (!$tm)
        alert('존재하지 않는 설정입니다.');
}

// Skin Discovery
$skins = array();
$dir = dir($skins_path);
while ($entry = $dir->read()) {
    if ($entry == '.' || $entry == '..')
        continue;
    if (is_dir($skins_path . '/' . $entry))
        $skins[] = $entry;
}
$dir->close();

$priority_order = array('basic', 'centered', 'modern', 'transparent', 'minimal');
usort($skins, function ($a, $b) use ($priority_order) {
    $pos_a = array_search($a, $priority_order);
    $pos_b = array_search($b, $priority_order);
    if ($pos_a === false)
        $pos_a = 999;
    if ($pos_b === false)
        $pos_b = 999;
    return $pos_a - $pos_b;
});

$g5['title'] = "상단 메뉴 설정 " . ($w == 'u' ? '수정' : '추가');
include_once(G5_ADMIN_PATH . '/admin.head.php');
?>

<form name="fconfig" method="post" action="./update.php" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="token" value="<?php echo get_admin_token(); ?>">

    <div class="tbl_frm01 tbl_wrap">
        <table>
            <caption>
                <?php echo $g5['title']; ?>
            </caption>
            <colgroup>
                <col width="150">
                <col>
            </colgroup>
            <tbody>
                <?php
                // [Standardization] Theme Discovery
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

                // [Standardization] Parsing Existing ID for Edit Mode
                $sel_theme = '';
                $sel_lang = 'kr';
                $sel_custom = '';
                if ($w == 'u' && $tm['tm_id']) {
                    $parts = explode('_', $tm['tm_id']);

                    // Check if second part is a language
                    if (isset($parts[1]) && in_array($parts[1], array('en', 'jp', 'cn'))) {
                        $sel_theme = $parts[0];
                        $sel_lang = $parts[1];
                        if (isset($parts[2])) {
                            array_shift($parts); // remove theme
                            array_shift($parts); // remove lang
                            $sel_custom = implode('_', $parts);
                        }
                    } else if (isset($parts[0])) {
                        $sel_theme = $parts[0];
                        $sel_lang = 'kr';
                        if (isset($parts[1])) {
                            array_shift($parts); // remove theme
                            $sel_custom = implode('_', $parts);
                        }
                    }
                }
                ?>
                <tr>
                    <th scope="row">설정 대상 (Theme & Lang)</th>
                    <td>
                        <div style="display:flex; gap:10px; align-items:center;">
                            <!-- Theme Select -->
                            <select name="tm_theme" id="tm_theme" class="frm_input" onchange="generate_tm_id()"
                                required>
                                <option value="">테마 선택</option>
                                <?php foreach ($themes as $theme) {
                                    $selected = ($theme == $sel_theme) ? 'selected' : '';
                                    echo '<option value="' . $theme . '" ' . $selected . '>' . $theme . '</option>';
                                } ?>
                            </select>

                            <!-- Language Select -->
                            <select name="tm_lang" id="tm_lang" class="frm_input" onchange="generate_tm_id()" required>
                                <option value="kr" <?php echo ($sel_lang == 'kr') ? 'selected' : ''; ?>>한국어 (기본)</option>
                                <option value="en" <?php echo ($sel_lang == 'en') ? 'selected' : ''; ?>>English (EN)
                                </option>
                                <option value="jp" <?php echo ($sel_lang == 'jp') ? 'selected' : ''; ?>>Japanese (JP)
                                </option>
                                <option value="cn" <?php echo ($sel_lang == 'cn') ? 'selected' : ''; ?>>Chinese (CN)
                                </option>
                            </select>

                            <!-- Custom Suffix -->
                            <input type="text" name="tm_id_custom" id="tm_id_custom" value="<?php echo $sel_custom; ?>"
                                class="frm_input" style="width:150px;" placeholder="커스텀 이름 (선택)"
                                onkeyup="generate_tm_id()">
                        </div>

                        <div style="margin-top:5px; padding:10px; background:#f9f9f9; border:1px solid #eee;">
                            생성된 식별코드(ID): <strong id="display_tm_id"
                                style="color:#e74c3c; font-size:1.2em;"><?php echo $tm['tm_id']; ?></strong>
                            <input type="hidden" name="tm_id" id="tm_id" value="<?php echo $tm['tm_id']; ?>">
                        </div>
                        <span class="frm_info">테마와 언어를 선택하면 식별코드가 자동으로 생성됩니다. (예: corporate_en_sub)</span>

                        <script>
                            function generate_tm_id() {
                                var theme = document.getElementById('tm_theme').value;
                                var lang = document.getElementById('tm_lang').value;
                                var custom = document.getElementById('tm_id_custom').value.trim();
                                var id_field = document.getElementById('tm_id');
                                var display_field = document.getElementById('display_tm_id');

                                if (theme) {
                                    var new_id = theme;
                                    if (lang !== 'kr') {
                                        new_id += '_' + lang;
                                    }

                                    if (custom) {
                                        new_id += '_' + custom.replace(/[^a-z0-9_]/gi, '');
                                    }

                                    id_field.value = new_id;
                                    display_field.innerText = new_id;

                                    // Menu Table Mapping
                                    if (lang === 'kr') {
                                        document.getElementById('tm_menu_table').value = '';
                                        document.getElementById('display_menu_table_info').innerHTML = '기본 (Default)';
                                    } else {
                                        document.getElementById('tm_menu_table').value = lang;
                                        document.getElementById('display_menu_table_info').innerHTML = 'g5_write_menu_pdc_' + lang;
                                    }
                                } else {
                                    id_field.value = '';
                                    display_field.innerText = '-';
                                    document.getElementById('tm_menu_table').value = '';
                                    document.getElementById('display_menu_table_info').innerHTML = '-';
                                }
                            }
                            // Init on load
                            window.addEventListener('DOMContentLoaded', function () {
                                if (document.getElementById('tm_id').value == '') generate_tm_id();
                            });
                        </script>
                        <div style="margin-top:5px; color:#888; font-size:12px;">
                            연결된 메뉴 데이터: <strong id="display_menu_table_info" style="color:#000;">기본 (Default)</strong>
                        </div>
                    </td>
                </tr>
                <!-- Auto-Generated Menu Source (Hidden) -->
                <input type="hidden" name="tm_menu_table" id="tm_menu_table"
                    value="<?php echo $tm['tm_menu_table']; ?>">
                <tr>
                    <th scope="row">스킨 선택</th>
                    <td>
                        <div style="display:flex; flex-wrap:wrap; gap:15px;">
                            <?php foreach ($skins as $skin) {
                                $checked = ($skin == $tm['tm_skin']) ? 'checked' : '';
                                $preview_img = G5_PLUGIN_URL . '/top_menu_manager/skins/' . $skin . '/preview.png';
                                ?>
                                <label style="border:1px solid #ddd; padding:10px; border-radius:5px; cursor:pointer;">
                                    <input type="radio" name="tm_skin" value="<?php echo $skin; ?>" <?php echo $checked; ?>>
                                    <strong>
                                        <?php echo $skin; ?>
                                    </strong><br>

                                </label>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">PC 로고</th>
                    <td>
                        <input type="file" name="tm_logo_pc">
                        <?php if ($tm['tm_logo_pc']) {
                            echo '<br><img src="' . G5_DATA_URL . '/common/' . $tm['tm_logo_pc'] . '" style="max-height:50px;"> <input type="checkbox" name="del_logo_pc" value="1"> 삭제';
                        } ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">모바일 로고</th>
                    <td>
                        <input type="file" name="tm_logo_mo">
                        <?php if ($tm['tm_logo_mo']) {
                            echo '<br><img src="' . G5_DATA_URL . '/common/' . $tm['tm_logo_mo'] . '" style="max-height:50px;"> <input type="checkbox" name="del_logo_mo" value="1"> 삭제';
                        } ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="설정 저장" class="btn_submit">
        <button type="button" class="btn btn_03" onclick="view_preview();">미리보기</button>
        <a href="./list.php" class="btn btn_02">목록으로</a>
    </div>
</form>

<!-- Preview Modal -->
<div id="preview_modal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:9999;">
    <div
        style="position:relative; width:98%; height:96%; margin:1% auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow: 0 0 40px rgba(0,0,0,0.6);">
        <button type="button" onclick="close_preview()"
            style="position:absolute; top:20px; right:20px; width:44px; height:44px; border:none; background:#fff; border-radius:50%; font-size:28px; cursor:pointer; color:#333; z-index:10001; box-shadow: 0 4px 15px rgba(0,0,0,0.3); line-height:44px; text-align:center; padding:0;">&times;</button>
        <iframe id="preview_frame" name="preview_frame" src="" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<script>
    function view_preview() {
        var f = document.fconfig;
        var skin = '';

        // Get Selected Skin
        var skins = document.getElementsByName("tm_skin");
        for (var i = 0; i < skins.length; i++) {
            if (skins[i].checked) {
                skin = skins[i].value;
                break;
            }
        }

        var menu_table = f.tm_menu_table.value; // Get Menu Source

        // Construct Preview URL
        var url = "./adm/preview_style.php?skin=" + skin + "&menu_table=" + menu_table;

        var modal = document.getElementById('preview_modal');
        var frame = document.getElementById('preview_frame');

        frame.src = url;
        modal.style.display = 'block';

        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    function close_preview() {
        var modal = document.getElementById('preview_modal');
        var frame = document.getElementById('preview_frame');

        modal.style.display = 'none';
        frame.src = ''; // clear
        document.body.style.overflow = '';
    }
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>