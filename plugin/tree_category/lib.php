<?php
if (!defined('_GNUBOARD_'))
    exit;

// Fetch all categories
function get_tree_categories($table = 'g5_tree_category_add')
{
    global $g5;
    $sql = " SELECT * FROM {$table} WHERE tc_use = 1 ORDER BY tc_order ASC, tc_code ASC ";
    $result = sql_query($sql);
    $list = array();
    while ($row = sql_fetch_array($result)) {
        $list[] = $row;
    }
    return $list;
}

// Recursive Helper for Frontend
function build_frontend_tree($cats, $parent_code = '')
{
    $html = '';
    $step = strlen($parent_code) + 2;

    foreach ($cats as $cat) {
        if (strlen($cat['tc_code']) == $step && substr($cat['tc_code'], 0, strlen($parent_code)) == $parent_code) {

            // Check Children
            $children_html = build_frontend_tree($cats, $cat['tc_code']);
            $has_child = !empty($children_html);

            // Link Logic
            if ($cat['tc_link']) {
                $href = $cat['tc_link'];
            } else {
                $href = "?cate=" . $cat['tc_code'];
            }

            // Target
            $target_attr = ($cat['tc_target'] === '_blank') ? ' target="_blank"' : '';

            // Classes
            $cls = $has_child ? 'has-sub' : '';

            $html .= '<li class="' . $cls . '">';
            $html .= '<a href="' . $href . '"' . $target_attr . '>' . $cat['tc_name'] . '</a>';

            if ($has_child) {
                $html .= '<ul class="sub-menu">' . $children_html . '</ul>';
            }
            $html .= '</li>';
        }
    }
    return $html;
}

// Display as HTML Tree (Frontend Use)
function display_tree_category_nav($table = 'g5_tree_category_add')
{
    $cats = get_tree_categories($table);
    if (!$cats)
        return;

    echo '<ul class="tree-nav">';
    echo build_frontend_tree($cats, '');
    echo '</ul>';
}
?>