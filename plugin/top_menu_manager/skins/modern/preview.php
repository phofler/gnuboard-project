<?php
include_once('../../../../common.php');
if (!defined('_GNUBOARD_'))
    exit; // Safety check
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

// Define skin path and url for standalone preview
$menu_skin_path = G5_PLUGIN_PATH . '/top_menu_manager/skins/modern';
$menu_skin_url = G5_PLUGIN_URL . '/top_menu_manager/skins/modern';
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <title>Modern Skin Preview</title>
    <link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL ?>/default.css">
    <link rel="stylesheet" href="<?php echo $menu_skin_url ?>/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Modern Skin is Dark, so Preview body must be dark */
        body {
            background-color: #121212;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        /* Force CSS Variables if Theme doesn't load them */
        :root {
            --color-bg-dark: #0f0f14;
            --color-text-primary: #ffffff;
            --color-text-secondary: #8892b0;
            --color-accent-gold: #c5a47e;
        }

        /* Mock Header Container */
        #hd {
            width: 100%;
            /* Height is handled by style.css */
            position: relative;
            z-index: 1000;
        }
    </style>
</head>

<body>

    <div id="hd">
        <?php include($menu_skin_path . '/menu.skin.php'); ?>
    </div>

    <div style="padding: 100px; text-align: center; color: #888;">
        <h2>Modern Skin Preview</h2>
        <p>This is where the page content lives.</p>
    </div>

</body>

</html>