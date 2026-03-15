<?php
include_once('../../../../common.php');

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
    <title>Transparent Skin Preview</title>
    <link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL ?>/default.css">
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .hero-preview {
            height: 100vh;
            background: linear-gradient(45deg, #2c3e50, #3498db);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
    </style>
</head>

<body>
    <!-- Skin Includes -->
    <?php include('./menu.skin.php'); ?>

    <div class="hero-preview">
        <div>
            <h1>Hero Image Area</h1>
            <p>Header overlays this section.</p>
        </div>
    </div>
</body>

</html>