<?php
include_once('../../../../common.php');
$menu_skin_path = G5_PLUGIN_PATH . '/top_menu_manager/skins/basic';
$menu_skin_url = G5_PLUGIN_URL . '/top_menu_manager/skins/basic';

// [FIX] Load Real Data for Preview
if (defined('G5_PLUGIN_PATH') && file_exists(G5_PLUGIN_PATH . '/pro_menu_manager/lib.php')) {
    include_once(G5_PLUGIN_PATH . '/pro_menu_manager/lib.php');

    // 1. Fetch Data
    $raw_menus = get_pro_menu_list();
    $menu_tree = build_pro_menu_tree($raw_menus);

    // 2. Map Data for Skin (Compatible with display_pro_menu logic)
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
    // Fallback Dummy Data if lib not found
    $menu_datas = array();
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <title>Basic Skin Preview</title>
    <link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL ?>/default.css">
    <link rel="stylesheet" href="<?php echo $menu_skin_url ?>/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #333;
            margin: 0;
            padding: 0;
        }

        /* Simulate Header Container */
        #hd {
            width: 100%;
            height: 80px;
            background: rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1000;
        }

        .gnb_wrap {
            max-width: 1400px;
            margin: 0 auto;
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>

    <div id="hd">
        <?php include($menu_skin_path . '/menu.skin.php'); ?>
    </div>

    <div style="padding: 100px; text-align: center; color: #fff;">
        <h2>Content Area</h2>
        <p>This is where the page content lives.</p>
    </div>

</body>

</html>