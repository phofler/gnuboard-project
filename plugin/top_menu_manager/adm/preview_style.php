<?php
include_once('../../../common.php');

$skin = isset($_REQUEST['skin']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['skin']) : 'basic';
$skin_path = G5_PLUGIN_PATH . '/top_menu_manager/skins/' . $skin;
$skin_url = G5_PLUGIN_URL . '/top_menu_manager/skins/' . $skin;
$menu_table = isset($_REQUEST['menu_table']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['menu_table']) : '';

// [NEW] Dynamic Logo Support from Form (Base64 or URL)
// Since file inputs can't be passed via GET cleanly, we assume for preview 
// we either use existing logos or just show placeholders if new file selected (handled via JS FileReader in write.php ideally, 
// but for simple PHP preview we might just use existing or default)
$logo_pc_url = isset($_REQUEST['logo_pc']) ? $_REQUEST['logo_pc'] : '';

// Load Real Data (Pro Menu Manager Integration)
if (defined('G5_PLUGIN_PATH') && file_exists(G5_PLUGIN_PATH . '/pro_menu_manager/lib.php')) {
    include_once(G5_PLUGIN_PATH . '/pro_menu_manager/lib.php');

    // Handle Menu Table Switch
    if ($menu_table) {
        // Temporarily define global for the library function
        // But get_pro_menu_list uses global constant G5_PRO_MENU_TABLE or defaults.
        // We need to bypass the constant or force it?
        // Actually we can pass table name to get_pro_menu_list if we modified it?
        // Checked lib.php -> get_pro_menu_list($table='') accepts argument.
        $target_table = 'g5_write_menu_pdc_' . $menu_table;
        if ($menu_table == 'default' || $menu_table == '')
            $target_table = 'g5_write_menu_pdc';

        $raw_menus = get_pro_menu_list($target_table);
    } else {
        $raw_menus = get_pro_menu_list(); // Default
    }

    $menu_tree = build_pro_menu_tree($raw_menus);

    // Map Data
    $menu_datas = array();
    foreach ($menu_tree as $root) {
        $root_mapped = array(
            'me_name' => $root['ma_name'],
            'me_link' => $root['ma_link'],
            'me_target' => $root['ma_target'],
            'me_code' => $root['ma_code'],
            'sub' => array()
        );
        if (!empty($root['sub'])) {
            foreach ($root['sub'] as $child) {
                $child_mapped = array(
                    'me_name' => $child['ma_name'],
                    'me_link' => $child['ma_link'],
                    'me_target' => $child['ma_target'],
                    'me_code' => $child['ma_code'],
                    'sub' => array()
                );
                if (!empty($child['sub'])) {
                    foreach ($child['sub'] as $grand) {
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
} else {
    $menu_datas = array();
}

// Logo Injection for Skin
if ($logo_pc_url) {
    $top_logo_pc = $logo_pc_url;
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <title>Preview:
        <?php echo $skin; ?>
    </title>
    <link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL ?>/default.css">

    <?php if (file_exists($skin_path . '/style.css')) { ?>
        <link rel="stylesheet" href="<?php echo $skin_url ?>/style.css?v=<?php echo time(); ?>">
    <?php } ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #333;
            /* Dark bg to see transparent menus */
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        #hd {
            width: 100%;
            position: relative;
            z-index: 1000;
        }

        .preview-notice {
            position: fixed;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 5px 10px;
            font-size: 11px;
            z-index: 9999;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <div class="preview-notice">PREVIEW MODE:
        <?php echo $skin; ?>
    </div>

    <div id="hd">
        <?php
        if (file_exists($skin_path . '/menu.skin.php')) {
            include($skin_path . '/menu.skin.php');
        } else {
            echo '<p style="color:#fff; padding:20px;">Skin not found.</p>';
        }
        ?>
    </div>

    <div
        style="height:500px; background:#444; margin-top:0px; display:flex; justify-content:center; align-items:center; color:#888;">
        (Content Body Area)
    </div>

</body>

</html>