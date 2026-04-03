<?php
if (!defined('_GNUBOARD_')) exit;
$g5_debug['php']['begin_time'] = $begin_time = get_microtime();
if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
} else {
    $g5_head_title = implode(' | ', array_filter(array($g5['title'], $config['cf_title'])));
}
$g5['title'] = strip_tags($g5['title']);
$g5_head_title = strip_tags($g5_head_title);
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location']) $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

// [New] Apply Apple-style (Pretendard) Font via Modular Library
if (function_exists('g5_apply_font')) {
    g5_apply_font('pretendard');
}
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php
if (G5_IS_MOBILE) {
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
} else {
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
}
if($config['cf_add_meta']) echo $config['cf_add_meta'].PHP_EOL;
?>
<title><?php echo $g5_head_title; ?></title>
<link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL ?>/<?php echo G5_IS_MOBILE ? 'mobile' : 'default'; ?>.css?ver=<?php echo G5_CSS_VER ?>">
<link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL ?>/style.css?ver=<?php echo time() ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
<?php 
// Standard font loading (Keep as fallback or specific usage)
echo '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700;800;900&family=Noto+Sans+KR:wght@300;400;700;900&display=swap" rel="stylesheet">'.PHP_EOL;

// [New] Print Injected Font CSS Variables
if (isset($g5['style_font_vars'])) echo $g5['style_font_vars'];
?>

<style>
/* [GLOBAL DESIGN TOKENS] Spacing Optimization */
:root {
    --spacing-section-y: clamp(20px, 5vh, 60px); /* Narrower vertical spacing */
    --spacing-hero-height: 85vh; /* Flexible hero height */
}
</style>

<!-- Swiper Library (Dynamic Slider Support) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
</script>
<script src="<?php echo G5_JS_URL ?>/jquery-1.12.4.min.js"></script>
<script src="<?php echo G5_JS_URL ?>/jquery-migrate-1.4.1.min.js"></script>
<script src="<?php echo G5_JS_URL ?>/common.js?ver=<?php echo G5_JS_VER ?>"></script>
<script src="<?php echo G5_JS_URL ?>/wrest.js?ver=<?php echo G5_JS_VER ?>"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<?php
if(!defined('G5_IS_ADMIN')) echo $config['cf_add_script'];
?>
</head>
<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>