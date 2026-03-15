<?php
$sub_menu = "950195";
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'w');

$bs_id = isset($_REQUEST['bs_id']) ? trim($_REQUEST['bs_id']) : '';
$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';

$config_table = G5_TABLE_PREFIX . 'plugin_board_skin_config';

if ($w == 'u') {
    $bs = sql_fetch(" select * from {$config_table} where bs_id = '{$bs_id}' ");
    if (!$bs['bs_id'])
        alert('존재하지 않는 설정입니다.');
    $g5['title'] = '보드 스킨 설정 수정 : ' . $bs_id;
} else {
    $g5['title'] = '보드 스킨 설정 추가';
    $bs = array(
        'bs_theme' => '',
        'bs_lang' => '',
        'bo_table' => '',
        'bs_skin' => 'basic',
        'bs_layout' => 'list',
        'bs_cols' => '4',
        'bs_ratio' => '4x3',
        'bs_theme_mode' => ''
    );
}

include_once(G5_ADMIN_PATH . '/admin.head.php');

// Get All Boards for Selection
$boards = sql_query(" select bo_table, bo_subject from {$g5['board_table']} order by bo_table asc ");
?>

<form name="fboard_skin_write" id="fboard_skin_write" action="./update.php"
    onsubmit="return fboard_skin_write_submit(this);" method="post">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="bs_id" value="<?php echo $bs_id; ?>">
    <input type="hidden" name="token" value="<?php echo get_admin_token(); ?>">

    <div class="tbl_frm01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?></caption>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row">테마 및 언어 선택 (ID 생성)</th>
                    <td>
                        <div style="display:flex; gap:10px; align-items:center;">
                            <select name="bs_theme" id="bs_theme" required onchange="generate_bs_id()">
                                <option value="">테마 선택</option>
                                <option value="corporate" <?php echo ($bs['bs_theme'] == 'corporate') ? 'selected' : ''; ?>>Corporate (기본)</option>
                                <option value="corporate_light" <?php echo ($bs['bs_theme'] == 'corporate_light') ? 'selected' : ''; ?>>Corporate Light</option>
                            </select>

                            <select name="bs_lang" id="bs_lang" required onchange="generate_bs_id()">
                                <option value="">언어 선택</option>
                                <option value="kr" <?php echo ($bs['bs_lang'] == 'kr') ? 'selected' : ''; ?>>한국어 (kr)
                                </option>
                                <option value="en" <?php echo ($bs['bs_lang'] == 'en') ? 'selected' : ''; ?>>English (en)
                                </option>
                                <option value="jp" <?php echo ($bs['bs_lang'] == 'jp') ? 'selected' : ''; ?>>Japanese (jp)
                                </option>
                                <option value="cn" <?php echo ($bs['bs_lang'] == 'cn') ? 'selected' : ''; ?>>Chinese (cn)
                                </option>
                            </select>

                            <input type="text" name="custom_name" id="custom_name" placeholder="커스텀 이름 (영문/숫자)"
                                class="frm_input" onkeyup="generate_bs_id()" style="width:150px;">
                        </div>
                        <div id="id_preview"
                            style="margin-top:10px; color:#2c3e50; font-weight:bold; font-size:1.1rem;">
                            식별코드(ID): <span
                                id="generated_id_display"><?php echo $bs_id ? $bs_id : '테마와 언어를 선택하세요.'; ?></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bo_table">대상 게시판</label></th>
                    <td>
                        <select name="bo_table" id="bo_table" required>
                            <option value="">게시판 선택</option>
                            <?php while ($row = sql_fetch_array($boards)) { ?>
                                <option value="<?php echo $row['bo_table']; ?>" <?php echo ($bs['bo_table'] == $row['bo_table']) ? 'selected' : ''; ?>>
                                    <?php echo $row['bo_subject']; ?> (<?php echo $row['bo_table']; ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bs_skin">사용 스킨</label></th>
                    <td>
                        <?php
                        // [SCAN] Theme Board Skins
                        // Priority: Theme Skin > Global Skin (We focus on Theme Skin here per user request)
                        $theme_skin_path = G5_THEME_PATH . '/skin/board';
                        $theme_skins = array();
                        if (is_dir($theme_skin_path)) {
                            if ($dh = opendir($theme_skin_path)) {
                                while (($file = readdir($dh)) !== false) {
                                    if ($file != "." && $file != ".." && is_dir($theme_skin_path . '/' . $file)) {
                                        $theme_skins[] = $file;
                                    }
                                }
                                closedir($dh);
                            }
                            sort($theme_skins);
                        }
                        ?>
                        
                        <select name="bs_skin" id="bs_skin" required style="width:100%; max-width:400px;">
                            <option value="">스킨을 선택하세요</option>
                            
                            <optgroup label="[테마] 게시판 스킨 (Theme Board)">
                                <?php foreach ($theme_skins as $skin) { 
                                    // [FIX] Canonical G5 Format: "theme/skin_name"
                                    // admin.lib.php's get_skin_select() scans theme/skin/board/* 
                                    // and prepends "theme/" to the directory name.
                                    // We must match this format EXACTLY.
                                    $value = 'theme/' . $skin;
                                    $selected = ($bs['bs_skin'] == $value) ? 'selected' : '';
                                ?>
                                <option value="<?php echo $value; ?>" <?php echo $selected; ?>>
                                    <?php echo $skin; ?>
                                </option>
                                <?php } ?>
                            </optgroup>
                        </select>
                        <div style="margin-top:5px; color:#888; font-size:12px;">
                            * 현재 테마(corporate_light)의 /skin/board 디렉토리를 스캔합니다.
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bs_layout">레이아웃 타입</label></th>
                    <td>
                        <select name="bs_layout" id="bs_layout">
                            <option value="list" <?php echo ($bs['bs_layout'] == 'list') ? 'selected' : ''; ?>>리스트형 (List)
                            </option>
                            <option value="gallery" <?php echo ($bs['bs_layout'] == 'gallery') ? 'selected' : ''; ?>>갤러리형
                                (Gallery)</option>
                            <option value="webzine" <?php echo ($bs['bs_layout'] == 'webzine') ? 'selected' : ''; ?>>웹진형
                                (Webzine)</option>
                            <option value="swiper" <?php echo ($bs['bs_layout'] == 'swiper') ? 'selected' : ''; ?>>슬라이드형
                                (Swiper)</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">그리드 설정</th>
                    <td>
                        <label for="bs_cols" style="margin-right:10px;">가로 개수</label>
                        <select name="bs_cols" id="bs_cols" style="margin-right:20px;">
                            <?php for ($i = 1; $i <= 6; $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php echo ($bs['bs_cols'] == $i) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?>개씩 보기
                                </option>
                            <?php } ?>
                        </select>

                        <label for="bs_ratio" style="margin-right:10px;">이미지 비율</label>
                        <select name="bs_ratio" id="bs_ratio">
                            <option value="16x9" <?php echo ($bs['bs_ratio'] == '16x9') ? 'selected' : ''; ?>>16:9 와이드
                            </option>
                            <option value="4x3" <?php echo ($bs['bs_ratio'] == '4x3') ? 'selected' : ''; ?>>4:3 일반
                            </option>
                            <option value="1x1" <?php echo ($bs['bs_ratio'] == '1x1') ? 'selected' : ''; ?>>1:1 정방형
                            </option>
                            <option value="3x4" <?php echo ($bs['bs_ratio'] == '3x4') ? 'selected' : ''; ?>>3:4 세로형
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">디자인 테마 모드</th>
                    <td>
                        <label><input type="radio" name="bs_theme_mode" value="" <?php echo (!$bs['bs_theme_mode']) ? 'checked' : ''; ?>> 기본 (None)</label>
                        &nbsp;
                        <label><input type="radio" name="bs_theme_mode" value="dark" <?php echo ($bs['bs_theme_mode'] == 'dark') ? 'checked' : ''; ?>> 다크 모드 (Dark)</label>
                        &nbsp;
                        <label><input type="radio" name="bs_theme_mode" value="light" <?php echo ($bs['bs_theme_mode'] == 'light') ? 'checked' : ''; ?>> 라이트 모드 (Light)</label>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="저장" class="btn_submit btn" accesskey="s">
        <a href="./list.php" class="btn_cancel btn">목록</a>
    </div>
</form>

<script>
    function generate_bs_id() {
        var theme = document.getElementById('bs_theme').value;
        var lang = document.getElementById('bs_lang').value;
        var custom = document.getElementById('custom_name').value;
        var bo_table = document.getElementById('bo_table').value;

        // Alphanumeric filtering
        custom = custom.replace(/[^a-z0-9_]/gi, '');
        document.getElementById('custom_name').value = custom;

        var generated = "";
        if (theme && lang) {
            generated = theme;
            if (lang != 'kr') {
                generated += "_" + lang;
            }

            if (custom) {
                generated += "_" + custom;
            } else if (bo_table) {
                generated += "_" + bo_table;
            }
        }

        if (generated) {
            document.getElementById('generated_id_display').innerText = generated;
            <?php if ($w != 'u') { ?>
                document.getElementsByName('bs_id')[0].value = generated;
            <?php } ?>
        } else {
            document.getElementById('generated_id_display').innerText = "테마와 언어를 선택하세요.";
        }
    }

    // Initial binding for bo_table change
    document.getElementById('bo_table').onchange = generate_bs_id;

    function fboard_skin_write_submit(f) {
        if (f.w.value != 'u' && !f.bs_id.value) {
            alert("식별코드가 생성되지 않았습니다. 테마와 언어를 선택하세요.");
            return false;
        }
        return true;
    }
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>