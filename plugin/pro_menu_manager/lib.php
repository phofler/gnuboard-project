<?php
if (!defined('_GNUBOARD_'))
    exit;

// Fetch all custom menus sorted by order
// Fetch all custom menus sorted by order
function get_pro_menu_list($table = '')
{
    global $g5;

    // [NEW] Dynamic Table Support via Global Constant
    if (!$table) {
        $table = defined('G5_PRO_MENU_TABLE') ? G5_PRO_MENU_TABLE : 'g5_write_menu_pdc';
    }

    // Check table existence first to avoid errors during install
    $check = sql_fetch(" SHOW TABLES LIKE '{$table}' ");
    if (!$check)
        return array();

    $sql = " SELECT * FROM {$table} ORDER BY ma_order ASC, ma_id ASC ";
    $result = sql_query($sql);

    $list = array();
    while ($row = sql_fetch_array($result)) {
        $list[] = $row;
    }
    return $list;
}

// Build hierarchical tree from flat list
function build_pro_menu_tree($menus, $inject = true)
{
    if (empty($menus))
        return array();

    $tree = array();
    $ref = array();

    // Pass 1: Initialize
    foreach ($menus as $m) {
        $code = $m['ma_code'];
        $m['sub'] = array();
        $ref[$code] = $m;
    }

    // Pass 2: Build Tree
    foreach ($ref as $code => $node) {
        $len = strlen($code);
        if ($len == 2) {
            // Root
            $tree[$code] = &$ref[$code];
        } else {
            // Child
            $parent_code = substr($code, 0, $len - 2);
            if (isset($ref[$parent_code])) {
                $ref[$parent_code]['sub'][$code] = &$ref[$code];
            } else {
                // Orphan
                $tree[$code] = &$ref[$code];
            }
        }
    }

    // [NEW] Dynamic Category Injection for 'Name Matching'
    if ($inject && file_exists(G5_PLUGIN_PATH . '/tree_category/lib.php')) {
        include_once(G5_PLUGIN_PATH . '/tree_category/lib.php');
        $tree_cats = get_tree_categories(); // Already filters tc_use=1, tc_menu_use=1

        foreach ($tree as &$root) {
            $root_name = trim($root['ma_name']);

            // Find a matching category in the tree
            $matched_cat_root = null;
            foreach ($tree_cats as $tc) {
                // Check if name matches AND it's a root category (len=2)
                // Filtered by get_tree_categories already (tc_use=1, tc_menu_use=1)
                if ($tc['tc_name'] === $root_name && strlen($tc['tc_code']) == 2) {
                    $matched_cat_root = $tc;
                    break;
                }
            }

            if ($matched_cat_root) {
                // If found, fetch all its descendants
                $sub_cats = array();
                foreach ($tree_cats as $tc) {
                    // Start with matching code but exclude itself
                    if (strpos($tc['tc_code'], $matched_cat_root['tc_code']) === 0 && $tc['tc_code'] !== $matched_cat_root['tc_code']) {
                        $sub_cats[] = $tc;
                    }
                }

                // Inject children (Maintain hierarchy)
                if (!empty($sub_cats)) {
                    $root['sub'] = array_merge($root['sub'], build_tree_from_cats($sub_cats, $matched_cat_root['tc_code']));
                }
            }
        }
    }

    return $tree;
}

// Helper for dynamic injection
function build_tree_from_cats($cats, $parent_code = '')
{
    $t = array();
    $r = array();
    $p_len = strlen($parent_code);

    foreach ($cats as $c) {
        $code = $c['tc_code'];
        $r[$code] = array(
            'ma_name' => $c['tc_name'],
            'ma_link' => $c['tc_link'] ?: G5_BBS_URL . '/board.php?bo_table=product&cate=' . $c['tc_code'],
            'ma_target' => $c['tc_target'],
            'ma_use' => 1,
            'ma_menu_use' => 1,
            'ma_mobile_use' => 1,
            'ma_code' => 'TC' . $code,
            'sub' => array()
        );
    }
    foreach ($r as $code => $node) {
        $len = strlen($code);
        // Direct child of matching root
        if ($len == $p_len + 2 && substr($code, 0, $p_len) == $parent_code) {
            $t[$code] = &$r[$code];
        } else {
            // Deeper child
            $p = substr($code, 0, $len - 2);
            if (isset($r[$p])) {
                $r[$p]['sub'][$code] = &$r[$code];
            }
        }
    }
    return $t;
}

// Recursive function to render Tree UI for Admin
function render_pro_menu_admin_tree($menus, $parent_code = '')
{
    $html = '';

    foreach ($menus as $menu) {
        $use_badge = $mobile_badge = $menu_use_badge = '';
        // We only want direct children of parent_code
        $is_child = false;

        if ($parent_code === '') {
            if (strlen($menu['ma_code']) == 2)
                $is_child = true;
        } else {
            if (strlen($menu['ma_code']) == strlen($parent_code) + 2 && substr($menu['ma_code'], 0, strlen($parent_code)) == $parent_code) {
                $is_child = true;
            }
        }

        if ($is_child) {
            $use_badge = (($menu['ma_use'] ?? 1) == 0) ? ' <span class="badge_hidden" style="color:#d9534f;">[미사용]</span>' : '';
            $mobile_badge = (($menu['ma_mobile_use'] ?? 1) == 0) ? ' <span class="badge_mobile_hidden" style="color:#f0ad4e;">[M숨김]</span>' : '';
            $menu_use_badge = (($menu['ma_menu_use'] ?? 1) == 0) ? ' <span class="badge_menu_hidden" style="color:#5bc0de;">[숨김]</span>' : '';

            // Data attributes for JS form loading
            $data_attr = " data-code='{$menu['ma_code']}' ";
            $data_attr .= " data-name='{$menu['ma_name']}' ";
            $data_attr .= " data-link='{$menu['ma_link']}' ";
            $data_attr .= " data-target='{$menu['ma_target']}' ";
            $data_attr .= " data-order='{$menu['ma_order']}' ";
            $data_attr .= " data-use='" . ($menu['ma_use'] ?? 1) . "' ";
            $data_attr .= " data-mobile-use='" . ($menu['ma_mobile_use'] ?? 1) . "' ";
            $data_attr .= " data-menu-use='" . ($menu['ma_menu_use'] ?? 1) . "' ";
            $data_attr .= " data-icon='{$menu['ma_icon']}' ";

            $html .= '<li class="tree-item" id="node_' . $menu['ma_code'] . '">';
            $html .= '<div class="tree-handle ' . $data_attr . '" onclick="load_menu_form(this)">';
            $html .= '<span class="fa fa-folder-o"></span> <span class="menu-name">' . $menu['ma_name'] . '</span>';
            $html .= '<span class="badges">' . $use_badge . $mobile_badge . $menu_use_badge . '</span>';
            $html .= '<span class="menu-code text-muted" style="font-size:0.8em; margin-left:5px;">(' . $menu['ma_code'] . ')</span>';
            $html .= '</div>';

            // Recursion
            $children = render_pro_menu_admin_tree($menus, $menu['ma_code']);
            if ($children) {
                $html .= '<ul class="tree-group">' . $children . '</ul>';
            }

            $html .= '</li>';
        }
    }

    return $html;
}

// Frontend Display Function (Refactored for Theme Control)
function display_pro_menu($skin_name = 'basic')
{
    global $g5, $config, $is_member, $is_admin;

    // 1. Get New Data (with 3-depth and Category Injection)
    $raw_menus = get_pro_menu_list();
    $menu_tree = build_pro_menu_tree($raw_menus);

    // 2. Map New Data (ma_...) to Old Data (me_...) for Skin Compatibility
    $menu_datas = array();
    foreach ($menu_tree as $root_code => $root) {
        $root_mapped = array(
            'me_name' => $root['ma_name'],
            'me_link' => $root['ma_link'],
            'me_target' => $root['ma_target'],
            'me_code' => $root['ma_code'],
            'sub' => array()
        );

        if (!empty($root['sub'])) {
            foreach ($root['sub'] as $child_code => $child) {
                $child_mapped = array(
                    'me_name' => $child['ma_name'],
                    'me_link' => $child['ma_link'],
                    'me_target' => $child['ma_target'],
                    'me_code' => $child['ma_code'],
                    'sub' => array()
                );

                // Depth 3 Handling
                if (!empty($child['sub'])) {
                    foreach ($child['sub'] as $grand_code => $grand) {
                        $child_mapped['sub'][] = array(
                            'me_name' => $grand['ma_name'],
                            'me_link' => $grand['ma_link'],
                            'me_target' => $grand['ma_target'],
                            'me_code' => $grand['ma_code']
                        );
                    }
                }
                $root_mapped['sub'][] = $child_mapped;
            }
        }
        $menu_datas[] = $root_mapped;
    }

    // 3. Set Active Skin (Method B: Admin-First Priority)
    $top_menu_skin = '';

    // Priority 1: Check Database Configuration (Most Dynamic)
    // Needs to match current theme ID (e.g., 'corporate' or 'corporate_en')
    $tm_id = $config['cf_theme'];
    if (defined('G5_LANG') && G5_LANG != 'kr') {
        $tm_id .= '_' . G5_LANG;
    }

    $sql_tm = " SELECT tm_skin FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ";
    $row_tm = sql_fetch($sql_tm);
    if ($row_tm && $row_tm['tm_skin']) {
        $top_menu_skin = $row_tm['tm_skin'];
    }

    // Priority 2: Use Passed Argument (Theme/DB Config - fallback if DB check fails)
    if (!$top_menu_skin && $skin_name) {
        $top_menu_skin = $skin_name;
    }

    // Priority 3: Check Static Setting (Fallback)
    if (!$top_menu_skin) {
        $setting_file = G5_PLUGIN_PATH . '/top_menu_manager/setting.php';
        if (file_exists($setting_file)) {
            include($setting_file);
        }
    }

    // Priority 4: Global Fallback
    if (!$top_menu_skin) {
        $top_menu_skin = 'basic';
    }

    $base_plugin_path = G5_PLUGIN_PATH . '/top_menu_manager';
    $base_plugin_url = G5_PLUGIN_URL . '/top_menu_manager';

    $skin_path = $base_plugin_path . '/skins/' . $top_menu_skin;
    $skin_url = $base_plugin_url . '/skins/' . $top_menu_skin;

    if (!file_exists($skin_path . '/menu.skin.php')) {
        echo '<!-- Skin "' . $top_menu_skin . '" not found in ' . $skin_path . ' -->';
        return;
    }

    // 4. Include the Skin File (This uses $menu_datas and $skin_url)
    include($skin_path . '/menu.skin.php');
}
