<?php
include_once('../../../../common.php');
include_once(G5_LIB_PATH . '/latest.lib.php');

/* Real Data Loading: get_menu_db() is called inside menu.skin.php */
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