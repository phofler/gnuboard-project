<?php
$sub_menu = "800195";
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'w');

$bs_id = isset($_REQUEST['bs_id']) ? (int) $_REQUEST['bs_id'] : 0;
$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';

$html_title = '보드 스킨 위젯';

if ($w == 'u') {
    $bs = sql_fetch(" select * from " . G5_PLUGIN_BOARD_SKIN_TABLE . " where bs_id = '{$bs_id}' ");
    if (!$bs['bs_id'])
        alert('존재하지 않는 자료입니다.');
    $html_title .= ' 수정';
} else {
    $bs = array(
        'bs_skin' => 'theme/basic',
        'bs_count' => 4,
        'bs_subject_len' => 30,
        'bs_active' => 1,
        'bs_sort' => 0
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
// Function to scan directory
function scan_latest_skins($dir, $prefix = '')
{
    $skins = array();
    if (!is_dir($dir))
        return $skins;
    $d = dir($dir);
    while ($entry = $d->read()) {
        if ($entry == '.' || $entry == '..')
            continue;
        if (is_dir($dir . '/' . $entry)) {
            $skins[] = $prefix . $entry;
        }
    }
    $d->close();
    sort($skins);
    return $skins;
}

// Theme Skins
$theme_skins = scan_latest_skins(G5_THEME_PATH . '/skin/latest', 'theme/');
// Core Skins
$core_skins = scan_latest_skins(G5_PATH . '/skin/latest', '');
// Plugin Skins [New]
$plugin_skins = scan_latest_skins(G5_PLUGIN_PATH . '/board_skin_manager/skins', 'plugin/');

$all_skins = array_merge($plugin_skins, $theme_skins, $core_skins);
?>

<form name="fboard_skin" id="fboard_skin" action="./update.php" onsubmit="return fboard_skin_submit(this);"
    method="post" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="bs_id" value="<?php echo $bs_id; ?>">
    <input type="hidden" name="token" value="">

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
                    <th scope="row"><label for="bs_title">관리 명칭<strong class="sound_only">필수</strong></label></th>
                    <td>
                        <input type="text" name="bs_title"
                            value="<?php echo isset($bs['bs_title']) ? get_text($bs['bs_title']) : ''; ?>" id="bs_title"
                            required class="required frm_input" size="50" placeholder="예: 메인 포트폴리오 섹션">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bs_bo_table">대상 게시판<strong class="sound_only">필수</strong></label>
                    </th>
                    <td>
                        <select name="bs_bo_table" id="bs_bo_table" required class="required">
                            <option value="">선택하세요</option>
                            <?php foreach ($bo_list as $bo) { ?>
                                <option value="<?php echo $bo['bo_table']; ?>" <?php echo (isset($bs['bs_bo_table']) && $bs['bs_bo_table'] == $bo['bo_table']) ? 'selected' : ''; ?>>
                                    <?php echo $bo['bo_subject']; ?> (
                                    <?php echo $bo['bo_table']; ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bs_skin">사용 스킨<strong class="sound_only">필수</strong></label></th>
                    <td>
                        <select name="bs_skin" id="bs_skin" required class="required">
                            <option value="">선택하세요</option>
                            <?php foreach ($all_skins as $skin) { ?>
                                <option value="<?php echo $skin; ?>" <?php echo (isset($bs['bs_skin']) && $bs['bs_skin'] == $skin) ? 'selected' : ''; ?>>
                                    <?php echo $skin; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <span class="frm_info">theme/ 로 시작하면 테마 스킨, 나머지는 플러그인/코어 스킨입니다.</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">출력 설정</th>
                    <td>
                        <label for="bs_count">출력 개수</label>
                        <input type="number" name="bs_count"
                            value="<?php echo isset($bs['bs_count']) ? $bs['bs_count'] : 4; ?>" id="bs_count"
                            class="frm_input" size="5"> 개
                        &nbsp;&nbsp;
                        <label for="bs_subject_len">제목 길이</label>
                        <input type="number" name="bs_subject_len"
                            value="<?php echo isset($bs['bs_subject_len']) ? $bs['bs_subject_len'] : 30; ?>"
                            id="bs_subject_len" class="frm_input" size="5"> 자
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bs_options">추가 옵션</label></th>
                    <td>
                        <input type="text" name="bs_options"
                            value="<?php echo isset($bs['bs_options']) ? get_text($bs['bs_options']) : ''; ?>"
                            id="bs_options" class="frm_input" size="50">
                        <span class="frm_info">예: me_code (뉴스 게시판 분류 등), 비워두면 무시</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bs_sort">출력 순서</label></th>
                    <td>
                        <input type="number" name="bs_sort" value="<?php echo $bs['bs_sort']; ?>" id="bs_sort"
                            class="frm_input" size="5">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bs_active">노출 여부</label></th>
                    <td>
                        <input type="checkbox" name="bs_active" value="1" id="bs_active" <?php echo ($bs['bs_active'] ? 'checked' : ''); ?>>
                        <label for="bs_active">사용함</label>
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
    function fboard_skin_submit(f) {
        return true;
    }
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>