<?php
include_once('../../../../common.php');

// [Sync] Load Real Menu Data like other skins
$menu_datas = get_menu_db(0, true);
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