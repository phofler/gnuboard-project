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
    <?php
    // Check if real config exists
    $config_check = get_main_visual_config($style);

    // If config checks out and slides exist, use standard function
    $slides_check = array();
    if ($config_check) {
        $slides_check = get_main_slides($config_check['mi_id']);
    }

    // EXCEPTION: 
    // 1. If style is 'sample', force manual mode.
    // 2. If $_GET['skin'] is provided and differs from saved skin, force manual mode to preview the NEW selection.
    $requested_skin = isset($_GET['skin']) ? $_GET['skin'] : '';

    if ($style !== 'sample' && $config_check && count($slides_check) > 0 && (!$requested_skin || $requested_skin == $config_check['mi_skin'])) {
        display_main_visual($style);
    } else {
        // SAMPLE MODE (Add Page or No Data)
        $skin = (isset($_GET['skin']) && $_GET['skin']) ? $_GET['skin'] : 'basic';

        // Define Dummy Data
        $config = array(
            'mi_id' => 'sample',
            'mi_skin' => $skin,
            'mi_subject' => 'Sample Preview Mode'
        );

        $slides = array();

        // Slide 1: Office/Corporate
        $slides[] = array(
            'mi_title' => 'Sample Title',
            'mi_desc' => "This is a preview of the selected skin. \nExperience the premium design with high-quality images.",
            'img_url' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1920&q=80',
            'mi_link' => '#',
            'mi_target' => '_self',
            'mi_video' => ''
        );

        // Slide 2: Building/Modern
        $slides[] = array(
            'mi_title' => 'Dynamic Experience',
            'mi_desc' => "Supports video backgrounds and smooth transitions.\nMake your brand stand out.",
            'img_url' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80',
            'mi_link' => '#',
            'mi_target' => '_self',
            'mi_video' => ''
        );

        // Slide 3: Nature/Abstract
        $slides[] = array(
            'mi_title' => 'Creative Vision',
            'mi_desc' => "Customize every aspect of your main visual.\nFrom typography to layout.",
            'img_url' => 'https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?auto=format&fit=crop&w=1920&q=80',
            'mi_link' => '#',
            'mi_target' => '_self',
            'mi_video' => ''
        );

        // Render Skin Manually
        $skin_path = G5_PLUGIN_PATH . '/main_image_manager/skins/' . $skin;
        $skin_url = G5_PLUGIN_URL . '/main_image_manager/skins/' . $skin;
        $skin_file = $skin_path . '/main.skin.php';

        if (file_exists($skin_path . '/style.css')) {
            echo '<link rel="stylesheet" href="' . $skin_url . '/style.css?v=' . time() . '">';
        }

        if (file_exists($skin_file)) {
            // Skin files expect $config and $slides variables
            include($skin_file);
        } else {
            echo '<div style="color:#fff; text-align:center; padding:50px;">Skin not found: ' . $skin . '</div>';
        }
    }
    ?>
</body>

</html>