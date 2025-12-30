<?php
include_once('./_common.php');

if (!$is_admin) {
    die('관리자만 접근 가능합니다.');
}

// Fetch Categories Logic (Moved from admin.php)
$table_name = "g5_tree_category_add";
$sql_common = " FROM {$table_name} ";
$sql_search = " WHERE tc_use = 1 ";

$root_code = isset($_GET['root_code']) ? $_GET['root_code'] : '';
if ($root_code) {
    $len = strlen($root_code);
    $sql_search .= " AND substring(tc_code, 1, {$len}) = '{$root_code}' ";
}

// Logic to fetch categories
// If root_code is present, we filter. BUT for the tree to look right, 
// we generally want to see the whole tree or at least the subtree.
// For admin view, usually we want to see everything to move things around easily, 
// but if tabs are used, we respect root_code.

if ($root_code) {
    // If filtering by root, we match prefix
    $sql = " SELECT * {$sql_common} WHERE substring(tc_code, 1, " . strlen($root_code) . ") = '{$root_code}' ORDER BY tc_order, tc_code ASC ";
} else {
    $sql = " SELECT * {$sql_common} ORDER BY tc_order, tc_code ASC ";
}

$result = sql_query($sql);
$categories = array();
while ($row = sql_fetch_array($result)) {
    $categories[] = $row;
}

// Tree Build Function (Frontend/Admin shared logic concept, but specific markup for Admin)
if (!function_exists('build_admin_tree')) {
    function build_admin_tree($cats, $parent_code = '')
    {
        $html = '';
        $step = strlen($parent_code) + 2;

        foreach ($cats as $cat) {
            if (strlen($cat['tc_code']) == $step && substr($cat['tc_code'], 0, strlen($parent_code)) == $parent_code) {

                $has_child = false;
                foreach ($cats as $c) {
                    if (strlen($c['tc_code']) > strlen($cat['tc_code']) && substr($c['tc_code'], 0, strlen($cat['tc_code'])) == $cat['tc_code']) {
                        $has_child = true;
                        break;
                    }
                }

                $icon = $has_child ? 'fa-folder' : 'fa-file-o';

                // Active Class Logic if needed (maybe storing last active in session?)
                // For now, simple render.

                $use_status = ($cat['tc_use'] == '0') ? ' <span style="color:#e52727; font-size:0.9em;">[미사용]</span>' : '';
                $menu_status = ($cat['tc_menu_use'] == '0') ? ' <span style="color:#999; font-size:0.9em;">[숨김]</span>' : '';

                $html .= '<li class="tree-item" data-code="' . $cat['tc_code'] . '" data-name="' . $cat['tc_name'] . '" data-link="' . $cat['tc_link'] . '" data-target="' . $cat['tc_target'] . '" data-order="' . $cat['tc_order'] . '" data-use="' . $cat['tc_use'] . '" data-menu-use="' . $cat['tc_menu_use'] . '">';
                $html .= '<div class="tree-content" onclick="load_category(this)">';
                $html .= '<span class="tree-icon"><i class="fa ' . $icon . '"></i></span> ';
                $html .= '<span class="tree-text">' . $cat['tc_name'] . $use_status . $menu_status . ' <small class="text-muted">(' . $cat['tc_code'] . ')</small></span>';
                $html .= '</div>';

                $children_html = build_admin_tree($cats, $cat['tc_code']);
                if ($children_html) {
                    $html .= '<ul class="tree-group">' . $children_html . '</ul>';
                }
                $html .= '</li>';
            }
        }
        return $html;
    }
}
?>

<ul class="tree-root">
    <?php echo build_admin_tree($categories, ''); ?>
</ul>

<?php if (empty($categories))
    echo '<p class="empty_msg">등록된 카테고리가 없습니다.</p>'; ?>