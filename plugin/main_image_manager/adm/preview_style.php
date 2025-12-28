<?php
include_once('./_common.php');
include_once(G5_PLUGIN_PATH . '/main_image_manager/lib/main.lib.php');

$style = isset($_GET['style']) ? $_GET['style'] : 'A';
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <title>Preview Style <?php echo $style; ?></title>
    <link rel="stylesheet" href="<?php echo G5_THEME_URL; ?>/css/default.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background: #000;
        }

        .hero-section {
            width: 100%;
            height: 100vh;
            position: relative;
        }
    </style>
</head>

<body>
    <?php display_main_visual($style); ?>
</body>

</html>