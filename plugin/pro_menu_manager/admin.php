<?php
include_once('./_common.php');

if (!$is_admin) {
    alert('관리자만 접근 가능합니다.');
}

$sub_menu = '800160';

// [AUTO INSTALL] Table Check & Create
$table_name = "g5_write_menu_pdc";
if (!sql_query(" DESCRIBE {$table_name} ", false)) {
    $sql = " CREATE TABLE IF NOT EXISTS `{$table_name}` (
      `ma_id` int(11) NOT NULL AUTO_INCREMENT,
      `ma_code` varchar(255) NOT NULL DEFAULT '',
      `ma_name` varchar(255) NOT NULL DEFAULT '',
      `ma_link` varchar(255) NOT NULL DEFAULT '',
      `ma_target` varchar(255) NOT NULL DEFAULT '',
      `ma_order` int(11) NOT NULL DEFAULT '0',
      `ma_use` tinyint(4) NOT NULL DEFAULT '1',
      `ma_mobile_use` tinyint(4) NOT NULL DEFAULT '1',
      `ma_menu_use` tinyint(4) NOT NULL DEFAULT '1',
      `ma_icon` varchar(255) NOT NULL DEFAULT '',
      `ma_regdt` datetime DEFAULT NULL,
      PRIMARY KEY (`ma_id`),
      KEY `ma_code` (`ma_code`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";
    sql_query($sql);
}

// Column Auto Add (Migration)
$row = sql_fetch(" SHOW COLUMNS FROM {$table_name} LIKE 'ma_menu_use' ");
if (!$row) {
    sql_query(" ALTER TABLE {$table_name} ADD COLUMN `ma_menu_use` tinyint(4) NOT NULL DEFAULT '1' AFTER `ma_mobile_use` ", false);
}

include_once(dirname(__FILE__) . '/lib.php');

$g5['title'] = "Pro 상단 메뉴 관리 (Customize)";
include_once(G5_ADMIN_PATH . '/admin.head.php');

$menus = get_pro_menu_list($table_name);
$menus = build_pro_menu_tree($menus, false); // Do not inject categories in Admin view
?>

<div class="local_desc01 local_desc">
    <p>
        <strong>Pro Menu Manager</strong><br>
        3단계 이상의 깊이(Depth)를 지원하며, 독립적인 테이블(<?php echo $table_name; ?>)을 사용하여 안전하게 관리할 수 있습니다.<br>
        메뉴 순서는 각 단계별로 코드순으로 정렬됩니다.
    </p>
</div>

<form name="fmenulist" id="fmenulist" method="post" action="./update.php" onsubmit="return fmenulist_submit(this);">
    <input type="hidden" name="token" value="<?php echo get_admin_token(); ?>">

    <div class="tbl_head01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <colgroup>
                <col style="width: 300px;">
                <col>
                <col style="width: 100px;">
                <col style="width: 80px;">
                <col style="width: 100px;">
                <col style="width: 100px;">
                <col style="width: 100px;">
                <col style="width: 120px;">
            </colgroup>
            <thead>
                <tr>
                    <th scope="col">메뉴명 (코드)</th>
                    <th scope="col">링크</th>
                    <th scope="col">새창</th>
                    <th scope="col">순서</th>
                    <th scope="col">PC사용</th>
                    <th scope="col">모바일사용</th>
                    <th scope="col">메뉴노출</th>
                    <th scope="col">관리</th>
                </tr>
            </thead>
            <tbody id="menu_list_body">
                <?php
                // Recursive or linear loop to render properly
                // get_pro_menu_list returns a hierarchical array (tree)
                // We need to flatten it or traverse it for the table
                function render_menu_table_rows($list, $depth = 0)
                {
                    global $g5;
                    if (empty($list))
                        return;

                    foreach ($list as $row) {
                        $bg = ($depth == 0) ? 'bg0' : 'bg1'; // basic bg alternation or depth-based?
                
                        $td_class = 'td_category';
                        $sub_menu_ico = '';
                        $padding_left = 10; // Default
                
                        if ($depth > 0) {
                            $td_class .= ' sub_menu_class';
                            $sub_menu_ico = '<span class="sub_menu_ico">└</span>';
                            // Additional indent for depth > 1 (3rd level etc)
                            // Standard G5 only has 2 levels, so we just add padding for deeper levels
                            $padding_left += ($depth * 20);
                        }
                        ?>
                        <tr class="<?php echo $bg; ?>">
                            <td class="<?php echo $td_class; ?>" style="padding-left:<?php echo $padding_left; ?>px;">
                                <input type="hidden" name="ma_id[]" value="<?php echo $row['ma_id']; ?>">
                                <input type="hidden" name="ma_code[]" value="<?php echo $row['ma_code']; ?>">
                                <input type="hidden" name="ma_parent_code[]" value="">
                                <?php echo $sub_menu_ico; ?>
                                <input type="text" name="ma_name[]" value="<?php echo get_sanitize_input($row['ma_name']); ?>"
                                    class="frm_input full_input" style="width:90%;" required>
                                <!-- Reduced width to fit indent -->
                            </td>
                            <td>
                                <input type="text" name="ma_link[]" value="<?php echo $row['ma_link']; ?>"
                                    class="frm_input full_input" size="40">
                            </td>
                            <td class="td_mng">
                                <select name="ma_target[]">
                                    <option value="" <?php echo get_selected($row['ma_target'], ''); ?>>사용안함</option>
                                    <option value="_blank" <?php echo get_selected($row['ma_target'], '_blank'); ?>>사용함</option>
                                </select>
                            </td>
                            <td class="td_num">
                                <input type="text" name="ma_order[]" value="<?php echo $row['ma_order']; ?>" class="frm_input"
                                    size="5">
                            </td>
                            <td class="td_mng">
                                <select name="ma_use[]">
                                    <option value="1" <?php echo get_selected($row['ma_use'], '1'); ?>>사용함</option>
                                    <option value="0" <?php echo get_selected($row['ma_use'], '0'); ?>>사용안함</option>
                                </select>
                            </td>
                            <td class="td_mng">
                                <select name="ma_mobile_use[]">
                                    <option value="1" <?php echo get_selected($row['ma_mobile_use'], '1'); ?>>사용함</option>
                                    <option value="0" <?php echo get_selected($row['ma_mobile_use'], '0'); ?>>사용안함</option>
                                </select>
                            </td>
                            <td class="td_mng">
                                <select name="ma_menu_use[]">
                                    <option value="1" <?php echo get_selected($row['ma_menu_use'], '1'); ?>>노출</option>
                                    <option value="0" <?php echo get_selected($row['ma_menu_use'], '0'); ?>>숨김</option>
                                </select>
                            </td>
                            <td class="td_mng">
                                <button type="button" class="btn_add_submenu btn_03"
                                    onclick="add_submenu('<?php echo $row['ma_code']; ?>')">추가</button>
                                <button type="button" class="btn_del_menu btn_02" onclick="delete_menu_row(this)">삭제</button>
                            </td>
                        </tr>
                        <?php
                        if (isset($row['sub']) && is_array($row['sub']) && count($row['sub']) > 0) {
                            render_menu_table_rows($row['sub'], $depth + 1);
                        }
                    }
                }

                if (!empty($menus)) {
                    render_menu_table_rows($menus);
                } else {
                    echo '<tr id="empty_row"><td colspan="8" class="empty_table">등록된 메뉴가 없습니다. 메뉴추가 버튼을 눌러 추가해주세요.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="btn_fixed_top">
        <button type="button" onclick="add_submenu('')" class="btn btn_02">메뉴추가</button>
        <input type="submit" value="확인" class="btn_submit btn">
    </div>

</form>

<script>
    function fmenulist_submit(f) {
        if (!confirm("변경사항을 저장하시겠습니까? (삭제된 메뉴는 복구할 수 없습니다)"))
            return false;
        return true;
    }

    function add_submenu(parent_code) {
        var $tbody = $("#menu_list_body");
        var depth = 0;

        // Calculate new code logic is complicated on frontend without DB
        // Instead, we will submit 'new_parent_code[]' and 'new_name[]' etc for new items?
        // OR simpler: we create a row with hidden "mode=new" and "parent_code=..."
        // But table submit usually expects array of same names.
        // Let's use ma_id[] = empty for new
        // ma_code[] needs to be generated on server OR we pass parent_code in a separate hidden input for NEW items.

        // Just simple visual row add
        var html = '';
        html += '<tr class="bg0 new_row">';
        html += '<td class="td_category" style="text-align:left; padding-left:10px;">';
        html += '<input type="hidden" name="ma_id[]" value="">'; // Empty ID = New
        html += '<input type="hidden" name="ma_code[]" value="">'; // Empty Code, Server will generate
        html += '<input type="hidden" name="ma_parent_code[]" value="' + parent_code + '">'; // Parent Code for generation

        // Indent visual (approximate, since we don't know depth purely from parent_code easily in JS without parsing)
        // Actually parent_code length / 2 = parent depth.
        var p_depth = (parent_code.length / 2);
        var indent = '';
        if (parent_code !== '') {
            indent += '<span style="display:inline-block; width:' + (p_depth * 20) + 'px;"></span>';
            indent += '<span class="sub_menu_ico">└</span> ';
        }
        html += indent;

        html += '<input type="text" name="ma_name[]" value="" class="frm_input full_input" style="width:200px;" required placeholder="새 메뉴">';
        if (parent_code) html += ' <span class="frm_info" style="font-size:0.8em; color:#888;">(상위: ' + parent_code + ')</span>';
        html += '</td>';

        html += '<td><input type="text" name="ma_link[]" value="" class="frm_input full_input" size="40"></td>';
        html += '<td class="td_mng"><select name="ma_target[]"><option value="">사용안함</option><option value="_blank">사용함</option></select></td>';
        html += '<td class="td_num"><input type="text" name="ma_order[]" value="0" class="frm_input" size="5"></td>';
        html += '<td class="td_mng"><select name="ma_use[]"><option value="1" selected>사용함</option><option value="0">사용안함</option></select></td>';
        html += '<td class="td_mng"><select name="ma_mobile_use[]"><option value="1" selected>사용함</option><option value="0">사용안함</option></select></td>';
        html += '<td class="td_mng"><select name="ma_menu_use[]"><option value="1">노출</option><option value="0" selected>숨김</option></select></td>';
        html += '<td class="td_mng"><button type="button" class="btn_del_menu btn_02" onclick="delete_menu_row(this)">삭제</button></td>';
        html += '</tr>';

        $("#empty_row").remove();

        // Insert after the parent or at bottom?
        // Ideally after parent and its children.
        // Finding the last child of parent is hard without tree traversal in DOM.
        // For now, simpler: append to table or try to find last row starting with parent code?

        var inserted = false;
        if (parent_code) {
            // Find rows whose ma_code starts with parent_code
            // We want to insert after the LAST row that starts with parent_code
            var last_match = null;
            $("input[name='ma_code[]']").each(function () {
                var val = $(this).val();
                if (val && val.indexOf(parent_code) === 0) {
                    last_match = $(this).closest("tr");
                }
            });

            if (last_match && last_match.length) {
                last_match.after(html);
                inserted = true;
            }
        }

        if (!inserted) {
            $tbody.append(html);
        }
    }

    function delete_menu_row(btn) {
        var $tr = $(btn).closest("tr");
        // visual delete
        $tr.remove();
    }
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>