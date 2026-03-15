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
// ?ㅽ궓??basic ?닿굅???놁쓣 寃쎌슦?먮쭔 湲곗〈 ?뚮쭏 ?섎뱶肄붾뵫 ?붿옄??異쒕젰
if (!$tm_skin || $tm_skin == 'basic') {
?>
<header id="mainHeader" class="header">
    <div class="gnbWrapBg">
        <div class="container gnbArea">
            <a href="#" class="btnAllmenu"><i class="fas fa-bars"></i></a>
            <h1 class="logo"><a href="<?php echo G5_URL ?>"><img src="<?php echo $logo_url ?>" alt="濡쒓퀬"></a></h1>
            <nav>
                <ul class="gnb" id="gnb">
                    <?php
                    if (function_exists('get_pro_menu_list')) {
                        $raw_menus = get_pro_menu_list();
                        $menu_tree = build_pro_menu_tree($raw_menus);
                        $i = 1;
                        foreach ($menu_tree as $root) {
                    ?>
                        <li class="menu<?php echo $i ?>"><a href="<?php echo $root['ma_link'] ?>"><?php echo $root['ma_name'] ?></a>
                            <?php if (!empty($root['sub'])) { ?>
                                <div class="dep2Wrap">
                                    <div class="dep2Wrap2">
                                        <div class="dep2Img">
                                            <i class="fa-solid fa-layer-group menu-icon-bg"></i>
                                            <h2><i class="fa-solid fa-circle-info"></i><?php echo $root['ma_name'] ?></h2>
                                            <p class="txt">?깆슦泥⑤떒?⑤꼸? ?딆엫?녿뒗 湲곗닠 ?곸떊?쇰줈 <br>嫄댁텞???덈줈??媛移섎? 李쎌텧?⑸땲??</p>
                                        </div>
                                        <div class="dep2">
                                            <ul>
                                                <?php foreach ($root['sub'] as $child) { ?>
                                                    <li><a href="<?php echo $child['ma_link'] ?>"><?php echo $child['ma_name'] ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </li>
                    <?php
                            $i++;
                        }
                    }
                    ?>
                </ul>
            </nav>
            <div class="rightBtn">
                <a href="/contact_us/online.php" class="btn-lang desktop-only">CONTACT</a>
                <a href="tel:1551-9123" class="btn-phone mobile-only"><i class="fas fa-phone"></i></a>
            </div>
        </div>
    </div>
</header>

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

<!-- 紐⑤컮??硫붾돱 ?쒕줈??(湲곕낯?? -->
<div class="m-menu-overlay"></div>
<div class="m-menu-wrap">
    <div class="m-menu-header">
        <div class="m-logo-area">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo $logo_url ?>" alt="濡쒓퀬"></a>
        </div>
        <div class="m-contact-area">
            <a href="tel:1551-9123" class="m-icon-btn"><i class="fas fa-phone"></i></a>
            <a href="/contact_us/online.php" class="m-icon-btn"><i class="fas fa-envelope"></i></a>
        </div>
    </div>
    <button class="btn-m-close"><i class="fas fa-times"></i></button>
    <ul class="m-gnb">
        <?php
        if (isset($menu_tree) && is_array($menu_tree)) {
            foreach ($menu_tree as $root) {
        ?>
            <li><a href="javascript:void(0)"><?php echo $root['ma_name'] ?></a>
                <?php if (!empty($root['sub'])) { ?>
                    <ul class="m-dep2">
                        <?php foreach ($root['sub'] as $child) { ?>
                            <li><a href="<?php echo $child['ma_link'] ?>"><?php echo $child['ma_name'] ?></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </li>
        <?php
            }
        }
        ?>
    </ul>
</div>
<?php
} else {
    // centered, modern, transparent ???ㅻⅨ ?ㅽ궓??寃쎌슦 ?뚮윭洹몄씤 ?⑥닔 ?몄텧
    if (function_exists('display_top_menu')) {
        display_top_menu();
    }
}
?>

<div id="wrapper"<?php echo (defined("_INDEX_")) ? " class='is-main'" : ""; ?>>
    <div id="container_wr">
        <div id="container">