<?php
include_once('../../../../common.php');
// Dummy Data
$menu_datas = array(
    array('me_name' => 'Home', 'me_link' => '#', 'me_target' => 'self', 'sub' => array()),
    array(
        'me_name' => 'Work',
        'me_link' => '#',
        'me_target' => 'self',
        'sub' => array(
            array('me_name' => 'Project A', 'me_link' => '#', 'me_target' => 'self'),
            array('me_name' => 'Project B', 'me_link' => '#', 'me_target' => 'self'),
        )
    ),
    array('me_name' => 'About', 'me_link' => '#', 'me_target' => 'self', 'sub' => array()),
);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <title>Minimal Skin Preview</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL ?>/default.css">
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <?php include('./menu.skin.php'); ?>

    <div
        style="height: 100vh; display:flex; align-items:center; justify-content:center; background:#f0f0f0; color:#333;">
        <h1>Minimal Content</h1>
    </div>
</body>

</html>