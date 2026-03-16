<?php
$sub_menu = "950193"; // Matches hook.php
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'w');

// Shared UI Extension check
if (!function_exists('get_theme_lang_select_ui')) {
    @include_once(G5_PATH . '/extend/project_ui.extend.php');
}

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
        'ls_id' => '',
        'ls_skin' => 'theme/basic',
        'ls_count' => 4,
        'ls_subject_len' => 30,
        'ls_active' => 1,
        'ls_sort' => 0,
        'ls_theme' => '',
        'ls_lang' => '',
        'ls_options' => '',
        'ls_title' => '',
        'ls_more_link' => '',
        'ls_description' => '',
        'ls_bo_table' => ''
    );
    $html_title .= ' 추가';
}

$g5['title'] = $html_title;
include_once(G5_ADMIN_PATH . '/admin.head.php');

// Board List
$bo_list = array();
$sql = " select bo_table, bo_subject from {$g5['board_table']} order by bo_table ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    $bo_list[] = $row;
}
?>

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
                        <?php
                        if (function_exists('get_theme_lang_select_ui')) {
                            echo get_theme_lang_select_ui(array(
                                "prefix" => "ls_",
                                "theme" => $ls["ls_theme"],
                                "lang" => $ls["ls_lang"] ? $ls["ls_lang"] : "kr",
                                "custom" => $ls["ls_options"],
                                "id" => $ls["ls_id"],
                                "id_input_id" => "ls_id_new" // Use a temporary ID field if needed, but update.php expects ls_id
                            ));
                        }
                        ?>
                        <div style="margin-top:8px; font-size:12px; color:#666; padding:10px; background:#f9f9f9; border:1px solid #eee; display:inline-block;">
                            <?php if ($ls_id) { ?>
                                위젯 호출 코드: <strong id="generated_code_display"
                                    style="color:#2563eb; font-size:1.1em; cursor:pointer;"
                                    onclick="copy_widget_code('<?php echo $ls_id; ?>');"
                                    title="클릭하여 복사"><?php echo "latest_widget('{$ls_id}')"; ?></strong>
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
                            value="<?php echo get_text($ls['ls_title']); ?>" id="ls_title"
                            required class="required frm_input" size="50" placeholder="예: CONSTRUCTION CASE">
                        <p class="frm_info">메인 페이지와 웹에디터에서 섹션 타이틀로 사용되는 공식 명칭입니다.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ls_more_link">더보기 링크 (URL)</label></th>
                    <td>
                        <input type="text" name="ls_more_link"
                            value="<?php echo get_text($ls['ls_more_link']); ?>"
                            id="ls_more_link" class="frm_input" size="70"
                            placeholder="예: /bbs/board.php?bo_table=gallery">
                        <p class="frm_info">입력 시 메인 섹션 우측에 '더보기 / MORE' 링크가 자동 생성됩니다.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ls_description">섹션 설명글</label></th>
                    <td>
                        <?php
                        if (function_exists('get_premium_editor_ui')) {
                            echo get_premium_editor_ui(array(
                                'id' => 'ls_description',
                                'name' => 'ls_description',
                                'value' => $ls['ls_description'],
                                'height' => '80px',
                                'placeholder' => '제목 아래에 작게 표시될 부연 설명글입니다. (선택사항)'
                            ));
                        } else {
                            echo '<textarea name="ls_description" id="ls_description" rows="3" class="frm_input" style="width:100%">' . get_text($ls['ls_description']) . '</textarea>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">스킨 선택</th>
                    <td>
                        <?php
                        if (function_exists('get_skin_select_ui')) {
                            echo get_skin_select_ui(array(
                                'name' => 'ls_skin',
                                'selected' => $ls['ls_skin'],
                                'skins_dir' => G5_PLUGIN_PATH . '/latest_skin_manager/skins',
                                'priority' => array('works_dark', 'kukdong_best')
                            ));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ls_bo_table">대상 게시판<strong class="sound_only">필수</strong></label>
                    </th>
                    <td>
                        <select name="ls_bo_table" id="ls_bo_table" required class="required">
                            <option value="">선택하세요</option>
                            <?php foreach ($bo_list as $bo) { ?>
                                <option value="<?php echo $bo['bo_table']; ?>" <?php echo ($ls['ls_bo_table'] == $bo['bo_table']) ? 'selected' : ''; ?>>
                                    <?php echo $bo['bo_subject']; ?> (<?php echo $bo['bo_table']; ?>)
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
                            value="<?php echo $ls['ls_count']; ?>" id="ls_count"
                            class="frm_input" size="5"> 개
                        &nbsp;&nbsp;
                        <label for="ls_subject_len">제목 길이</label>
                        <input type="number" name="ls_subject_len"
                            value="<?php echo $ls['ls_subject_len']; ?>"
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
    function flatest_skin_submit(f) {
        if (!f.ls_skin.value) {
            alert('스킨을 선택해주세요.');
            return false;
        }
        return true;
    }

    // Sync standardized ID to the hidden input
    function sync_menu_table_info() {
        var new_id = document.getElementById("ls_id").value;
        var display = document.getElementById("generated_code_display");
        if (display && !document.querySelector("#generated_code_display i.fa-copy")) {
            if (new_id) {
                display.innerHTML = "<span style='color:#2563eb'>저장 후 생성 (latest_widget('" + new_id + "'))</span>";
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
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>