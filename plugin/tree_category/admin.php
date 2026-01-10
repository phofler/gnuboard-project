<?php
$sub_menu = "950500";
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

$g5['title'] = '트리 카테고리 관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');

// Table Auto Install
$table_name = "g5_tree_category_add";
if (!sql_query(" DESCRIBE {$table_name} ", false)) {
    $sql = " CREATE TABLE IF NOT EXISTS `{$table_name}` (
                `tc_id` int(11) NOT NULL AUTO_INCREMENT,
                `tc_code` varchar(20) NOT NULL DEFAULT '',
                `tc_name` varchar(255) NOT NULL DEFAULT '',
                `tc_order` int(11) NOT NULL DEFAULT '0',
                `tc_use` tinyint(4) NOT NULL DEFAULT '1',
                `tc_regdt` datetime DEFAULT NULL,
                PRIMARY KEY (`tc_id`),
                UNIQUE KEY `tc_code` (`tc_code`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";
    sql_query($sql, true);
    echo '<div class="alert alert-success">테이블(' . $table_name . ')이 성공적으로 생성되었습니다.</div>';
}

// Column Auto Add (Migration) - Run always to ensure columns exist
$row = sql_fetch(" SHOW COLUMNS FROM {$table_name} LIKE 'tc_link' ");
if (!$row)
    sql_query(" ALTER TABLE {$table_name} ADD COLUMN `tc_link` varchar(255) NOT NULL DEFAULT '' AFTER `tc_name` ", false);

$row = sql_fetch(" SHOW COLUMNS FROM {$table_name} LIKE 'tc_target' ");
if (!$row)
    sql_query(" ALTER TABLE {$table_name} ADD COLUMN `tc_target` varchar(10) NOT NULL DEFAULT '' AFTER `tc_link` ", false);

$row = sql_fetch(" SHOW COLUMNS FROM {$table_name} LIKE 'tc_menu_use' ");
if (!$row)
    sql_query(" ALTER TABLE {$table_name} ADD COLUMN `tc_menu_use` tinyint(4) NOT NULL DEFAULT '1' AFTER `tc_use` ", false);

// --- Logic Merged from update.php ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_admin_token();

    $w = $_POST['w'];
    $tc_code = $_POST['tc_code'];
    $tc_name = $_POST['tc_name'];
    $tc_link = isset($_POST['tc_link']) ? $_POST['tc_link'] : '';
    $tc_target = isset($_POST['tc_target']) ? $_POST['tc_target'] : '';
    $tc_order = $_POST['tc_order'];
    $tc_use = $_POST['tc_use'];

    if ($w == 'c' || $w == 'u') {
        if (!$tc_code)
            alert('코드를 입력하세요.');
        if (!$tc_name)
            alert('카테고리명을 입력하세요.');
    }

    if ($w == 'c') {
        $sql = " select count(*) as cnt from {$table_name} where tc_code = '{$tc_code}' ";
        $row = sql_fetch($sql);
        if ($row['cnt'])
            alert('이미 존재하는 코드입니다.');

        $sql = " insert into {$table_name}
                    set tc_code = '{$tc_code}',
                        tc_name = '{$tc_name}',
                        tc_link = '{$tc_link}',
                        tc_target = '{$tc_target}',
                        tc_order = '{$tc_order}',
                        tc_use = '{$tc_use}',
                        tc_regdt = '" . G5_TIME_YMDHIS . "' ";
        sql_query($sql);
        alert('추가되었습니다.', './admin.php');

    } else if ($w == 'u') {
        $sql = " update {$table_name}
                    set tc_name = '{$tc_name}',
                        tc_link = '{$tc_link}',
                        tc_target = '{$tc_target}',
                        tc_order = '{$tc_order}',
                        tc_use = '{$tc_use}'
                    where tc_code = '{$tc_code}' ";
        sql_query($sql);
        alert('수정되었습니다.', './admin.php');

    } else if ($w == 'd') {
        if (!$tc_code)
            alert('삭제할 카테고리를 선택하세요.');

        // Recursive Delete
        $len = strlen($tc_code);
        $sql = " delete from {$table_name} where substring(tc_code, 1, {$len}) = '{$tc_code}' ";
        sql_query($sql);
        alert('삭제되었습니다.', './admin.php');
    }
}
// ------------------------------------

// Fetch Roots for Tabs (Always need all roots for tabs)
$sql_roots = " SELECT * FROM {$table_name} WHERE length(tc_code) = 2 ORDER BY tc_order, tc_code ASC ";
$res_roots = sql_query($sql_roots);
$roots = array();
while ($row = sql_fetch_array($res_roots)) {
    $roots[] = $row;
}

// Current Root for Tab Active State (Passed to tree_list via GET if reload, but here for initial include)
$root_code = isset($_GET['root_code']) ? $_GET['root_code'] : '';
?>

<!-- Tab Menu for Roots -->
<div id="category_tabs">
    <a href="./admin.php" class="btn_tab <?php echo $root_code == '' ? 'active' : ''; ?>">전체</a>
    <?php foreach ($roots as $root) { ?>
        <a href="./admin.php?root_code=<?php echo $root['tc_code']; ?>"
            class="btn_tab <?php echo $root_code == $root['tc_code'] ? 'active' : ''; ?>">
            <?php echo $root['tc_name']; ?>
        </a>
    <?php } ?>
</div>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">전체 카테고리</span> <span class="ov_num">관리</span></span>
</div>

<style>
    #category_tabs {
        margin: 20px 0 10px;
        border-bottom: 2px solid #555;
    }

    #category_tabs .btn_tab {
        display: inline-block;
        padding: 10px 20px;
        background: #eee;
        border: 1px solid #ccc;
        border-bottom: none;
        margin-right: 5px;
        text-decoration: none;
        color: #333;
        border-radius: 5px 5px 0 0;
    }

    #category_tabs .btn_tab:hover {
        background: #f9f9f9;
    }

    #category_tabs .btn_tab.active {
        background: #555;
        color: #fff;
        border-color: #555;
        font-weight: bold;
    }
</style>

<div id="tree_layout">
    <!-- Left: Tree View -->
    <div class="tc-panel-left">
        <div class="tc-header">
            <h3>카테고리 목록</h3>
            <button type="button" class="btn btn_02 btn_sm" onclick="init_form()">신규 최상위 추가</button>
        </div>
        <div class="tc-body custom_scroll">
            <?php include('./admin.tree_list.php'); ?>
        </div>
    </div>

    <!-- Right: Edit Form -->
    <div class="tc-panel-right">
        <div class="tc-header">
            <h3 id="form_title">카테고리 등록/수정</h3>
        </div>
        <div class="tc-body">
            <!-- Action to SELF -->
            <form name="fcate" action="./admin.php" onsubmit="return save_category_ajax(this);" method="post"
                autocomplete="off">
                <input type="hidden" name="token" value="<?php echo get_admin_token(); ?>"> <!-- Token Added -->
                <input type="hidden" name="w" value="c">
                <input type="hidden" name="tc_id" value="">

                <div class="tbl_frm01 tbl_wrap">
                    <table>
                        <caption>카테고리 입력</caption>
                        <colgroup>
                            <col class="grid_4">
                            <col>
                        </colgroup>
                        <tbody>
                            <tr>
                                <th scope="row"><label for="tc_code">코드</label></th>
                                <td>
                                    <input type="text" name="tc_code" id="tc_code" required class="frm_input required"
                                        size="20" placeholder="예: 10, 1010">
                                    <span class="frm_info" id="code_desc">2자리씩 계층 구조 (예: 10 -> 1010 -> 101010)</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="tc_name">카테고리명</label></th>
                                <td>
                                    <input type="text" name="tc_name" id="tc_name" required class="frm_input required"
                                        size="50">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="tc_link">링크 URL</label></th>
                                <td>
                                    <input type="text" name="tc_link" id="tc_link" class="frm_input" size="60"
                                        placeholder="예: /bbs/board.php?bo_table=notification">
                                    <input type="checkbox" name="tc_target" id="tc_target" value="_blank"> <label
                                        for="tc_target">새창열기</label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="tc_order">출력순서</label></th>
                                <td>
                                    <input type="text" name="tc_order" id="tc_order" value="0" class="frm_input"
                                        size="10">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">사용여부</th>
                                <td>
                                    <label><input type="radio" name="tc_use" value="1" checked> 사용</label>
                                    <label><input type="radio" name="tc_use" value="0"> 미사용</label>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">메뉴 노출</th>
                                <td>
                                    <label><input type="radio" name="tc_menu_use" value="1"> 노출</label>
                                    <label><input type="radio" name="tc_menu_use" value="0" checked> 숨김</label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="btn_confirm01 btn_confirm">
                    <button type="submit" class="btn_submit btn">저장</button>
                    <button type="button" class="btn_02 btn" id="btn_add_child" style="display:none;"
                        onclick="add_child()">하위분류 추가</button>
                    <button type="button" class="btn_02 btn" id="btn_delete" style="display:none;"
                        onclick="delete_category()">삭제</button>
                    <a href="./admin.php" class="btn_frmline btn">초기화</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    #tree_layout {
        display: flex;
        gap: 20px;
        align-items: flex-start;
        margin-top: 20px;
    }

    .tc-panel-left,
    .tc-panel-right {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .tc-panel-left {
        flex: 1;
        min-width: 300px;
    }

    .tc-panel-right {
        flex: 2;
    }

    .tc-header {
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
        background: #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .tc-header h3 {
        margin: 0;
        font-size: 1.1em;
        font-weight: bold;
    }

    .tc-body {
        padding: 20px;
    }

    #tree_layout .custom_scroll {
        max-height: 600px;
        overflow-y: auto;
    }

    #tree_layout .tree-root,
    #tree_layout .tree-group {
        list-style: none;
        padding-left: 20px;
        margin: 0;
    }

    #tree_layout .tree-root {
        padding-left: 0;
    }

    #tree_layout .tree-item {
        margin: 2px 0;
    }

    #tree_layout .tree-content {
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 3px;
        border: 1px solid transparent;
    }

    #tree_layout .tree-content:hover {
        background-color: #f1f3f5;
        border-color: #e9ecef;
    }

    #tree_layout .tree-content.active {
        background-color: #e7f5ff;
        border-color: #d0ebff;
        color: #1c7ed6;
        font-weight: bold;
    }

    #tree_layout .tree-icon {
        color: #fcc419;
        margin-right: 5px;
    }

    #tree_layout .empty_msg {
        color: #868e96;
        text-align: center;
        padding: 20px;
    }
</style>

<script>
    function load_category(el) {
        $(".tree-content").removeClass("active");
        $(el).addClass("active");
        var p = $(el).parent();
        var code = p.data("code");
        var name = p.data("name");
        var link = p.data("link");
        var target = p.data("target");
        var order = p.data("order");
        var order = p.data("order");
        var use = p.data("use");
        var menu_use = p.data("menu-use"); // [NEW]

        var f = document.fcate;
        f.w.value = "u";
        f.tc_code.value = code;
        f.tc_code.readOnly = true;
        f.tc_code.style.backgroundColor = "#f0f0f0";
        f.tc_name.value = name;
        f.tc_link.value = link ? link : "";
        f.tc_target.checked = (target == "_blank");
        f.tc_order.value = order;
        f.tc_order.value = order;
        $("input[name='tc_use'][value='" + use + "']").prop("checked", true);
        $("input[name='tc_menu_use'][value='" + menu_use + "']").prop("checked", true); // [NEW]

        $("#form_title").text("카테고리 수정 (" + code + ")");
        $("#btn_add_child").show();
        $("#btn_delete").show();
        $("#code_desc").text("수정 모드에서는 코드를 변경할 수 없습니다.");
    }

    function get_next_code(parent_code) {
        var parent_len = parent_code ? parent_code.length : 0;
        var target_len = parent_len + 2;
        var max_val = 0;

        $(".tree-item").each(function () {
            var code = String($(this).data("code"));
            if (code.length == target_len) {
                if (parent_code && code.substring(0, parent_len) != parent_code) return; // Wrong parent
                var suffix = parseInt(code.substring(parent_len));
                if (suffix > max_val) max_val = suffix;
            }
        });

        var next_val = max_val + 10;
        if (next_val == 10 && max_val == 0) next_val = 10;

        return parent_code + next_val;
    }

    function init_form() {
        $(".tree-content").removeClass("active");
        var f = document.fcate;
        f.w.value = "c";
        f.tc_id.value = "";

        var next_code = get_next_code("");
        f.tc_code.value = next_code;
        f.tc_code.readOnly = true;
        f.tc_code.style.backgroundColor = "#f0f0f0";

        f.tc_name.value = "";
        f.tc_link.value = "";
        f.tc_target.checked = false;
        f.tc_order.value = "0";
        f.tc_order.value = "0";
        $("input[name='tc_use'][value='1']").prop("checked", true);
        $("input[name='tc_menu_use'][value='0']").prop("checked", true); // [NEW] Default to Hidden
        $("#form_title").text("새 카테고리 등록");
        $("#btn_add_child").hide();
        $("#btn_delete").hide();
        $("#code_desc").text("자동 생성된 코드입니다 (최상위: " + next_code + ")");
    }

    function add_child() {
        var parent_code = document.fcate.tc_code.value;
        if (!parent_code) return;
        var p_code = parent_code;
        init_form();
        var next_code = get_next_code(p_code);
        document.fcate.tc_code.value = next_code;
        $("#form_title").text("하위 카테고리 추가 (상위: " + p_code + ")");
        $("#code_desc").text("자동 생성된 코드입니다 (" + p_code + " > " + next_code + ")");
        document.fcate.tc_name.focus();
    }

    // Refresh Tree HTML
    function refresh_tree_view() {
        // Keep current tabs state if possible (root_code)
        // Parse current URL for root_code or simple load
        var urlParams = new URLSearchParams(window.location.search);
        var root_code = urlParams.get('root_code');
        var dataPayload = {};
        if (root_code) dataPayload.root_code = root_code;

        $.get("./admin.tree_list.php", dataPayload, function (html) {
            $(".tc-panel-left .tc-body").html(html);
            // After refresh, maybe re-highlight if we knew what was edited? 
            // For now, form is reset or stays same, but tree highlight is lost. 
            // That's acceptable for now.
            init_form(); // Reset form to "New" state to avoid data mismatch
        });
    }

    // AJAX Save
    function save_category_ajax(f) {
        if (!f.tc_code.value) {
            alert("코드가 없습니다.");
            return false;
        }
        if (!f.tc_name.value) {
            alert("카테고리명을 입력하세요.");
            return false;
        }

        var formData = $(f).serialize();

        $.ajax({
            url: "./ajax.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    // alert(data.msg); // Optional feedback
                    refresh_tree_view();
                }
            },
            error: function (xhr, status, error) {
                alert("통신 오류가 발생했습니다.");
                console.error(error);
            }
        });

        return false; // Prevent Normal Submit
    }

    // AJAX Delete
    function delete_category() {
        var f = document.fcate;
        var code = f.tc_code.value;
        if (!code) return;

        if (confirm("정말 삭제하시겠습니까?\n하위 카테고리가 있다면 함께 삭제될 수 있습니다.")) {
            $.ajax({
                url: "./ajax.php",
                type: "POST",
                data: {
                    w: 'd',
                    tc_code: code,
                    token: f.token.value
                },
                dataType: "json",
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        alert(data.msg);
                        refresh_tree_view();
                    }
                },
                error: function () {
                    alert("통신 오류");
                }
            });
        }
    }

    $(document).ready(function () {
        init_form();
    });
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>