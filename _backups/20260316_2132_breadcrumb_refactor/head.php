<?php
if (!defined('_GNUBOARD_')) exit;

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_PLUGIN_PATH.'/sub_design/lib/design.lib.php');

// 전역 변수 사용 (extend/user_top_menu.extend.php 에서 설정)
global $tm_skin, $logo_url;

// 메인 페이지 여부 확인
$is_main = (defined('_INDEX_')) ? true : false;
?>

<?php
// 유니버셜 상단 메뉴 출력 (Header)
if (function_exists('display_top_menu')) {
    $visual_id = $config['cf_theme'];
    if (defined('G5_LANG') && G5_LANG != 'kr') $visual_id .= '_' . G5_LANG;
    display_top_menu($visual_id);
}
?>

<?php if (!$is_main) { ?>
    <?php
    if (function_exists('display_sub_visual')) {
        display_sub_visual();
    } else {
    ?>
    <!-- 서브 타이틀 섹션 (Fallback) -->
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
<?php } ?>

<div id="wrapper"<?php echo (defined("_INDEX_")) ? " class='is-main'" : ""; ?>>
    <div id="container_wr">
        <div id="container">
<?php if (!$is_main) { ?>
    <h2 id="container_title" class="sound_only"><?php echo $g5['title'] ?></h2>
<?php } ?>
