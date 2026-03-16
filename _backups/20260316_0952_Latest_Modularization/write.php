<?php
$sub_menu = "950193"; // Matches hook.php
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'w');

$ls_id = isset($_REQUEST['ls_id']) ? $_REQUEST['ls_id'] : '';
$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';

$admin_token = get_admin_token();

$html_title = '보드 최근글 스킨 위젯';

if ($w == 'u') {
    $ls = sql_fetch(" select * from " . G5_PLUGIN_LATEST_SKIN_TABLE . " where ls_id = '{$ls_id}' ");
    if (!$ls['ls_id'])
        alert('존재하지 않는 자료입니다.');
    $html_title .= ' 수정';
} else {
    $ls = array(
        'ls_skin' => 'theme/basic',
        'ls_count' => 4,
        'ls_subject_len' => 30,
        'ls_active' => 1,
        'ls_sort' => 0,
        'ls_theme' => '',
        'ls_lang' => ''
    );
    $html_title .= ' 추가';
}

$g5['title'] = $html_title;
include_once(G5_ADMIN_PATH . '/admin.head.php');

// 1. Board List (for Dropdown)
$bo_list = array();
$sql = " select bo_table, bo_subject from {$g5['board_table']} order by bo_table ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    $bo_list[] = $row;
}

// 2. Skin List (Scan theme/skin/latest AND skin/latest)
$skin_list = array();
function scan_latest_skins($dir, $prefix = '', $base_url = '')
{
    $skins = array();
    if (!is_dir($dir))
        return $skins;
    $d = dir($dir);
    while ($entry = $d->read()) {
        if ($entry == '.' || $entry == '..')
            continue;
        if (is_dir($dir . '/' . $entry)) {
            $skins[] = array(
                'path' => $prefix . $entry,
                'name' => $entry,
                'url' => $base_url . '/' . $entry
            );
        }
    }
    $d->close();
    sort($skins);
    return $skins;
}

// Theme Skins
$theme_skins = scan_latest_skins(G5_THEME_PATH . '/skin/latest', 'theme/', G5_THEME_URL . '/skin/latest');
// Plugin Skins
$plugin_skins = scan_latest_skins(G5_PLUGIN_PATH . '/latest_skin_manager/skins', 'plugin/', G5_PLUGIN_URL . '/latest_skin_manager/skins');
// Core Skins
$core_skins = scan_latest_skins(G5_PATH . '/skin/latest', '', G5_SKIN_URL . '/latest');

$all_skins = array_merge($plugin_skins, $theme_skins);

// 3. Theme List (Scan G5_PATH/theme)
$theme_list = array();
$exclude_dirs = array('.', '..', 'css', 'js', 'img', 'image', 'skin', 'mobile', 'shop', 'lib', 'extend', 'adm', 'bbs', 'plugin', 'readme.txt');
$theme_path = G5_PATH . '/theme';
if (is_dir($theme_path)) {
    $d = dir($theme_path);
    while ($entry = $d->read()) {
        if (in_array($entry, $exclude_dirs))
            continue;
        if (is_dir($theme_path . '/' . $entry)) {
            $theme_list[] = $entry;
        }
    }
    $d->close();
}
sort($theme_list);
?>

<style>
    /* Premium Skin Selector Grid (Copied from Online Inquiry) */
    .skin-selector-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 12px;
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
        height: 60px;
        background: #f8fafc;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid #f1f5f9;
        position: relative;
    }

    .skin-preview-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Cover for full image look */
        transition: transform 0.5s;
    }

    /* Fallback text style */
    .skin-preview-wrap .no-preview {
        color: #94a3b8;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .skin-item-card:hover .skin-preview-wrap img {
        transform: scale(1.05);
    }

    .skin-info-wrap {
        padding: 10px;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .skin-icon-box {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
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
        font-size: 13px;
        margin-bottom: 2px;
        text-transform: capitalize;
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
</style>

<form name="flatest_skin" id="flatest_skin" action="./update.php" onsubmit="return flatest_skin_submit(this);"
    method="post" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="ls_id" value="<?php echo $ls_id; ?>">
    <input type="hidden" name="token" value="<?php echo $admin_token; ?>">

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
                    <th scope="row"><label for="ls_theme">설정 대상 (Theme & Lang)</label></th>
                    <td>
                        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                            <select name="ls_theme" id="ls_theme" class="frm_input" onchange="generate_widget_code()"
                                required>
                                <option value="">테마 선택</option>
                                <?php foreach ($theme_list as $th) { ?>
                                    <option value="<?php echo $th; ?>" <?php echo (isset($ls['ls_theme']) && $ls['ls_theme'] == $th) ? 'selected' : ''; ?>>
                                        <?php echo $th; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <select name="ls_lang" id="ls_lang" class="frm_input" onchange="generate_widget_code()">
                                <option value="">언어 선택</option>
                                <option value="kr" <?php echo (isset($ls['ls_lang']) && $ls['ls_lang'] == 'kr') ? 'selected' : ''; ?>>한국어 (kr)</option>
                                <option value="en" <?php echo (isset($ls['ls_lang']) && $ls['ls_lang'] == 'en') ? 'selected' : ''; ?>>English (en)</option>
                                <option value="jp" <?php echo (isset($ls['ls_lang']) && $ls['ls_lang'] == 'jp') ? 'selected' : ''; ?>>Japanese (jp)</option>
                                <option value="cn" <?php echo (isset($ls['ls_lang']) && $ls['ls_lang'] == 'cn') ? 'selected' : ''; ?>>Chinese (cn)</option>
                            </select>
                            <input type="text" name="ls_options" id="ls_options"
                                value="<?php echo isset($ls['ls_options']) ? get_text($ls['ls_options']) : ''; ?>"
                                class="frm_input" style="width:150px;" placeholder="커스텀 이름 (영문/숫자)"
                                onkeyup="generate_widget_code()">
                        </div>
                        <div
                            style="margin-top:8px; font-size:12px; color:#666; padding:10px; background:#f9f9f9; border:1px solid #eee; display:inline-block;">
                            <?php if ($ls_id) { ?>
                                위젯 호출 코드: <strong id="generated_code_display"
                                    style="color:#d4af37; font-size:1.1em; cursor:pointer;"
                                    onclick="copy_widget_code('<?php echo $ls_id; ?>');"
                                    title="클릭하여 복사"><?php echo "latest_widget({$ls_id})"; ?></strong>
                                <span style="color:#888; margin-left:5px;"><i class="fa fa-copy"></i></span>
                            <?php } else { ?>
                                위젯 호출 코드: <span id="generated_code_display" style="color:#999;">저장 완료 후 생성됩니다.</span>
                            <?php } ?>
                        </div>
                        <p class="frm_info" style="margin-top:5px;">테마와 언어를 선택하고 저장하면 식별코드가 생성됩니다.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ls_title">웹에디터 타이틀 명칭 (관리 명칭)<strong
                                class="sound_only">필수</strong></label></th>
                    <td>
                        <input type="text" name="ls_title"
                            value="<?php echo isset($ls['ls_title']) ? get_text($ls['ls_title']) : ''; ?>" id="ls_title"
                            required class="required frm_input" size="50" placeholder="예: CONSTRUCTION CASE">
                        <p class="frm_info">메인 페이지와 웹에디터에서 섹션 타이틀로 사용되는 공식 명칭입니다.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ls_more_link">더보기 링크 (URL)</label></th>
                    <td>
                        <input type="text" name="ls_more_link"
                            value="<?php echo isset($ls['ls_more_link']) ? get_text($ls['ls_more_link']) : ''; ?>"
                            id="ls_more_link" class="frm_input" size="70"
                            placeholder="예: /bbs/board.php?bo_table=gallery">
                        <p class="frm_info">입력 시 메인 섹션 우측에 '더보기 / MORE' 링크가 자동 생성됩니다.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ls_description">섹션 설명글</label></th>
                    <td>
                        <textarea name="ls_description" id="ls_description" rows="3" class="frm_input"
                            style="width:100%"><?php echo isset($ls['ls_description']) ? get_text($ls['ls_description']) : ''; ?></textarea>
                        <p class="frm_info">제목 아래에 작게 표시될 부연 설명글입니다. (선택사항)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">스킨 선택</th>
                    <td>
                        <input type="hidden" name="ls_skin" id="ls_skin" value="<?php echo $ls['ls_skin']; ?>" required>
                        <div class="skin-selector-grid">
                            <?php foreach ($all_skins as $skin) {
                                // Clean up name for display
                                $skin_path = $skin['path'];
                                $skin_name = $skin['name'];
                                $skin_url = $skin['url'];

                                $display_name = ucfirst(str_replace('_', ' ', $skin_name));
                                $is_active = (isset($ls['ls_skin']) && $ls['ls_skin'] == $skin_path) ? 'active' : '';

                                // Check for preview image (preview.png, screenshot.png, etc)
                                $preview_img = '';

                                // Need absolute path to check file_exists
                                $abs_path = '';
                                if (strpos($skin_path, 'theme/') === 0)
                                    $abs_path = G5_THEME_PATH . '/skin/latest/' . $skin_name;
                                else if (strpos($skin_path, 'plugin/') === 0)
                                    $abs_path = G5_PLUGIN_PATH . '/latest_skin_manager/skins/' . $skin_name;
                                else
                                    $abs_path = G5_PATH . '/skin/latest/' . $skin_name;

                                if (file_exists($abs_path . '/preview.png'))
                                    $preview_img = $skin_url . '/preview.png';
                                else if (file_exists($abs_path . '/screenshot.png'))
                                    $preview_img = $skin_url . '/screenshot.png';
                                else if (file_exists($abs_path . '/preview.jpg'))
                                    $preview_img = $skin_url . '/preview.jpg';
                                ?>
                                <div class="skin-item-card <?php echo $is_active; ?>"
                                    onclick="selectSkin(this, '<?php echo $skin_path; ?>')">
                                    <div class="skin-active-badge"><i class="fa fa-check-circle"></i> SELECTED</div>
                                    <div class="skin-preview-wrap">
                                        <?php if ($preview_img) { ?>
                                            <img src="<?php echo $preview_img; ?>" alt="<?php echo $skin_name; ?>">
                                        <?php } else { ?>
                                            <span class="no-preview">No Preview</span>
                                        <?php } ?>
                                    </div>
                                    <div class="skin-info-wrap">
                                        <div class="skin-icon-box">
                                            <i class="fa fa-cubes"></i>
                                        </div>
                                        <div>
                                            <div class="skin-label-text"><?php echo $display_name; ?></div>
                                            <div class="skin-desc-text"><?php echo $skin_path; ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ls_bo_table">대상 게시판<strong class="sound_only">필수</strong></label>
                    </th>
                    <td>
                        <select name="ls_bo_table" id="ls_bo_table" required class="required">
                            <option value="">선택하세요</option>
                            <?php foreach ($bo_list as $bo) { ?>
                                <option value="<?php echo $bo['bo_table']; ?>" <?php echo (isset($ls['ls_bo_table']) && $ls['ls_bo_table'] == $bo['bo_table']) ? 'selected' : ''; ?>>
                                    <?php echo $bo['bo_subject']; ?> (
                                    <?php echo $bo['bo_table']; ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">출력 설정</th>
                    <td>
                        <label for="ls_count">출력 개수</label>
                        <input type="number" name="ls_count"
                            value="<?php echo isset($ls['ls_count']) ? $ls['ls_count'] : 4; ?>" id="ls_count"
                            class="frm_input" size="5"> 개
                        &nbsp;&nbsp;
                        <label for="ls_subject_len">제목 길이</label>
                        <input type="number" name="ls_subject_len"
                            value="<?php echo isset($ls['ls_subject_len']) ? $ls['ls_subject_len'] : 30; ?>"
                            id="ls_subject_len" class="frm_input" size="5"> 자
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ls_sort">출력 순서</label></th>
                    <td>
                        <input type="number" name="ls_sort" value="<?php echo $ls['ls_sort']; ?>" id="ls_sort"
                            class="frm_input" size="5">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ls_active">노출 여부</label></th>
                    <td>
                        <input type="checkbox" name="ls_active" value="1" id="ls_active" <?php echo ($ls['ls_active'] ? 'checked' : ''); ?>>
                        <label for="ls_active">사용함</label>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="확인" class="btn_submit btn">
        <a href="./list.php" class="btn_cancel btn">목록</a>
    </div>
</form>

<script>
    function selectSkin(element, value) {
        // Remove active class from all
        var cards = document.querySelectorAll('.skin-item-card');
        cards.forEach(function (card) {
            card.classList.remove('active');
        });

        // Add active to clicked
        element.classList.add('active');

        // Update hidden input
        document.getElementById('ls_skin').value = value;
    }

    function flatest_skin_submit(f) {
        if (!f.ls_skin.value) {
            alert('스킨을 선택해주세요.');
            return false;
        }
        return true;
    }

    function generate_widget_code() {
        var theme = document.getElementById('ls_theme').value;
        var lang = document.getElementById('ls_lang').value;
        var custom = document.getElementById('ls_options').value.trim().replace(/[^a-z0-9_]/gi, '');
        document.getElementById('ls_options').value = custom; // Filter input live
        var display = document.getElementById('generated_code_display');

        // Console log to verify event triggering
        console.log("Widget setup changed: " + theme + " / " + lang);

        // Only update text if in 'New' mode (no ID yet)
        // Check if copy button exists (means ID exists)
        if (!document.querySelector('#generated_code_display i.fa-copy') && display) {
            var generated_id = "";
            if (theme) {
                generated_id = theme;
                // If lang is selected and not 'kr', append it
                if (lang && lang != 'kr') generated_id += "_" + lang;
                // If custom is provided, append it
                if (custom) generated_id += "_" + custom;

                display.innerHTML = "<span style='color:#2563eb'>저장 후 생성 (latest_widget(" + generated_id + "))</span>";
            } else {
                display.innerHTML = "<span style='color:#999'>테마를 선택하면 코드가 생성됩니다.</span>";
            }
        }
    }

    function copy_widget_code(id) {
        var code = "<?php echo '<?php latest_widget('; ?>" + id + "); ?>";
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = code;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        alert("위젯 호출 코드가 복사되었습니다: " + code);
    }

    $(function () {
        generate_widget_code();
    });
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>