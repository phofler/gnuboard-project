<?php
include_once('../../../../common.php');
include_once(G5_LIB_PATH . '/latest.lib.php');

/* Real Data Loading: Inject data for preview */
if (defined('G5_PLUGIN_PATH') && file_exists(G5_PLUGIN_PATH . '/pro_menu_manager/lib.php')) {
    include_once(G5_PLUGIN_PATH . '/pro_menu_manager/lib.php');
    $raw_menus = get_pro_menu_list();
    $menu_tree = build_pro_menu_tree($raw_menus);
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
                // Depth 3
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
} else {
    $menu_datas = array();
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <title>Centered Skin Preview</title>
    <link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL ?>/default.css">
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            background: #333;
            height: 100vh;
            overflow: hidden;
        }

        .preview-container {
            background: #fff;
            height: 100%;
            position: relative;
        }

        /* Override for preview context */
        .centered-header {
            position: relative;
        }
    </style>
</head>

<body>
    <div class="preview-container">
        <!-- Load the actual skin file -->
        <?php include('./menu.skin.php'); ?>

        <div style="text-align:center; padding: 50px; opacity: 0.5;">
            <h2>Content Area</h2>
            <p>This is how the header looks with content below.</p>
        </div>
    </div>
</body>

</html>