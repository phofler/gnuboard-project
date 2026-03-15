<?php
if (!defined('_GNUBOARD_')) exit;

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

// 전역 변수 사용 (extend/user_top_menu.extend.php 에서 설정됨)
global $tm_skin, $logo_url;

// 메인 페이지 여부 확인
$is_main = (defined('_INDEX_')) ? true : false;
?>

<?php
// 스킨이 basic 이거나 없을 경우에만 기존 테마 하드코딩 디자인 출력
if (!$tm_skin || $tm_skin == 'basic') {
?>
<header id="mainHeader" class="header">
    <div class="gnbWrapBg">
        <div class="container gnbArea">
            <a href="#" class="btnAllmenu"><i class="fas fa-bars"></i></a>
            <h1 class="logo"><a href="<?php echo G5_URL ?>"><img src="<?php echo $logo_url ?>" alt="로고"></a></h1>
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
                                            <p class="txt">성우첨단패널은 끊임없는 기술 혁신으로 <br>건축의 새로운 가치를 창출합니다.</p>
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
<!-- 서브 타이틀 섹션 -->
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

<!-- 모바일 메뉴 드로어 (기본형) -->
<div class="m-menu-overlay"></div>
<div class="m-menu-wrap">
    <div class="m-menu-header">
        <div class="m-logo-area">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo $logo_url ?>" alt="로고"></a>
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
    // centered, modern, transparent 등 다른 스킨일 경우 플러그인 함수 호출
    if (function_exists('display_top_menu')) {
        display_top_menu();
    }
}
?>

<div id="wrapper">
    <div id="container_wr">
        <div id="container">