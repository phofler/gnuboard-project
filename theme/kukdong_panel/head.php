<?php
if (!defined('_GNUBOARD_')) exit;

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

// ?꾩뿭 蹂???ъ슜 (extend/user_top_menu.extend.php ?먯꽌 ?ㅼ젙??
global $tm_skin, $logo_url;

// 硫붿씤 ?섏씠吏 ?щ? ?뺤씤
$is_main = (defined('_INDEX_')) ? true : false;
?>

<?php
// Render universal top menu (Header)
if (function_exists('display_top_menu')) {
    $visual_id = $config['cf_theme'];
    if (defined('G5_LANG') && G5_LANG != 'kr') $visual_id .= '_' . G5_LANG;
    display_top_menu($visual_id);
}
?>

<?php if (!$is_main) { ?>
<!-- ?쒕툕 ??댄? ?뱀뀡 -->
<section class="subTitleArea">
    <div class="subTitleBg" style="background-image: url('<?php echo G5_THEME_URL ?>/img/sub_bg_default.jpg');">
        <div class="container">
            <div class="subTitleTxt">
                <h2 class="title"><?php echo $g5['title'] ?></h2>
                <div class="breadcrumb">
                    <a href="<?php echo G5_URL ?>"><i class="fas fa-home"></i></a>
                    <span class="sep">></span>
                    <span class="current"><?php echo $g5['title'] ?></span>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>

<div id="wrapper"<?php echo (defined("_INDEX_")) ? " class='is-main'" : ""; ?>>
    <div id="container_wr">
        <div id="container">
