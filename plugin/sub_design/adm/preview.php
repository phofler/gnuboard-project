<?php
include_once(dirname(__FILE__) . '/../../../common.php');

$skin = isset($_REQUEST['skin']) ? clean_xss_tags($_REQUEST['skin']) : 'standard';
$main_text = isset($_REQUEST['main_text']) ? clean_xss_tags($_REQUEST['main_text']) : '';
$sub_text = isset($_REQUEST['sub_text']) ? clean_xss_tags($_REQUEST['sub_text']) : '';
$visual_url = isset($_REQUEST['visual_url']) ? clean_xss_tags($_REQUEST['visual_url']) : '';
$visual_img = isset($_REQUEST['visual_img']) ? clean_xss_tags($_REQUEST['visual_img']) : '';

// Construct Mock Item for Skin
$item = array(
    'sd_main_text' => $main_text,
    'sd_sub_text' => $sub_text,
    'sd_visual_url' => $visual_url,
    'sd_visual_img' => $visual_img
);

if (!$item['sd_visual_url'] && !$item['sd_visual_img']) {
    $item['sd_visual_url'] = 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1920&auto=format&fit=crop';
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>Sub Design Preview</title>
    <link rel="stylesheet" href="<?php echo G5_THEME_URL ?>/css/default.css">
    <script src="<?php echo G5_JS_URL ?>/jquery-1.12.4.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --spacing-container: 1400px;
            --spacing-section: 60px;
            --color-primary: #c8a27c;
        }

        body {
            padding: 0;
            margin: 0;
            background: #fff;
            font-family: 'Inter', 'Noto Sans KR', sans-serif;
        }

        .preview-bar {
            background: #1a1a1a;
            color: #fff;
            padding: 12px 25px;
            font-size: 11px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Inter', sans-serif;
            position: sticky;
            top: 0;
            z-index: 1001;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            letter-spacing: 0.05em;
        }

        .preview-content-sim {
            max-width: var(--spacing-container);
            margin: 0 auto;
            padding: 80px 20px;
            color: #ccc;
            text-align: center;
            font-size: 14px;
            border-top: 1px dashed #eee;
        }

        .sub-layout-width-height {
            width: 100%;
            max-width: var(--spacing-container);
            margin: 0 auto;
            padding: 0 20px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="preview-bar">
        <div><strong>SUB DESIGN PREVIEW</strong> - Real-time Visualization</div>
        <div
            style="text-transform:uppercase; font-weight:bold; background:#e67e22; padding:2px 10px; border-radius:15px; font-size:10px;">
            Skin:
            <?php echo $skin; ?>
        </div>
    </div>

    <div id="sub_hero_preview">
        <?php
        $skin_path = G5_PLUGIN_PATH . '/sub_design/skins/' . $skin . '/main.skin.php';
        if (file_exists($skin_path)) {
            include($skin_path);
        } else {
            echo '<div style="padding:100px; text-align:center;">Skin file not found: ' . $skin . '</div>';
        }
        ?>
    </div>

    <div class="preview-content-sim">
        <p>PAGE CONTENT STARTS HERE</p>
        <div style="width:100px; height:2px; background:#eee; margin:20px auto;"></div>
        <p style="opacity:0.5; font-size:12px;">This area represents where your page content (Board, Content, etc.) will
            be displayed on the actual site.</p>
    </div>

    <script>
        $(function () { AOS.init(); });
    </script>
</body>

</html>