<?php
if (!defined('_GNUBOARD_')) exit;

// Menu Data Load
include_once(G5_PLUGIN_PATH . '/top_menu_manager/skin.head.php');
$menu_skin_url = G5_PLUGIN_URL . '/top_menu_manager/skins/transparent';

// CSS is currently residing in the main theme, but if we need to load skin CSS, we would echo it here.
// echo '<link rel="stylesheet" href="' . $menu_skin_url . '/style.css?v=' . time() . '">';
?>

<header id="mainHeader" class="header">
    <div class="gnbWrapBg">
        <div class="container gnbArea">
            <a href="#" class="btnAllmenu"><i class="fas fa-bars"></i></a>
            <h1 class="logo"><a href="<?php echo G5_URL ?>"><img src="<?php echo $logo_src ?>" alt="로고"></a></h1>
            <nav>
                <ul class="gnb" id="gnb">
                    <?php
                    if (!empty($menu_datas)) {
                        $i = 1;
                        foreach ($menu_datas as $root) {
                    ?>
                        <li class="menu<?php echo $i ?>"><a href="<?php echo $root['me_link'] ?>"><?php echo $root['me_name'] ?></a>
                            <?php if (!empty($root['sub'])) { ?>
                                <div class="dep2Wrap">
                                    <div class="dep2Wrap2">
                                        <div class="dep2Img">
                                            <i class="fa-solid fa-layer-group menu-icon-bg"></i>
                                            <h2><i class="fa-solid fa-circle-info"></i><?php echo $root['me_name'] ?></h2>
                                            <p class="txt">성우첨단패널은 끊임없는 기술 혁신으로 <br>건축의 새로운 가치를 창출합니다.</p>
                                        </div>
                                        <div class="dep2">
                                            <ul>
                                                <?php foreach ($root['sub'] as $child) { ?>
                                                    <li><a href="<?php echo $child['me_link'] ?>"><?php echo $child['me_name'] ?></a></li>
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
                <a href="<?php echo G5_DATA_URL ?>/about/catalog.pdf" class="btn-lang desktop-only" target="_blank">카다로그 다운로드</a>
                <a href="tel:1551-9123" class="btn-phone mobile-only"><i class="fas fa-phone"></i></a>
            </div>
        </div>
    </div>
</header>

<!-- 모바일 메뉴 -->
<div class="m-menu-overlay"></div>
<div class="m-menu-wrap">
    <div class="m-menu-header">
        <div class="m-logo-area">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo $logo_src ?>" alt="로고"></a>
        </div>
        <div class="m-contact-area">
            <a href="tel:1551-9123" class="m-icon-btn"><i class="fas fa-phone"></i></a>
            <a href="/contact_us/online.php" class="m-icon-btn"><i class="fas fa-envelope"></i></a>
        </div>
    </div>
    <button class="btn-m-close"><i class="fas fa-times"></i></button>
    <ul class="m-gnb">
        <?php
        if (isset($menu_datas) && is_array($menu_datas)) {
            foreach ($menu_datas as $root) {
        ?>
            <li><a href="javascript:void(0)"><?php echo $root['me_name'] ?></a>
                <?php if (!empty($root['sub'])) { ?>
                    <ul class="m-dep2">
                        <?php foreach ($root['sub'] as $child) { ?>
                            <li><a href="<?php echo $child['me_link'] ?>"><?php echo $child['me_name'] ?></a></li>
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

<script>
$(function() {
    // Open Mobile Menu
    $('.btnAllmenu').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('.m-menu-wrap').addClass('active');
        $('.m-menu-overlay').fadeIn(300);
        $('body').addClass('m-menu-open');
    });

    // Close Mobile Menu
    $('.btn-m-close, .m-menu-overlay').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('.m-menu-wrap').removeClass('active');
        $('.m-menu-overlay').fadeOut(300);
        $('body').removeClass('m-menu-open');
    });

    // Mobile Menu Accordion - Stabilized and Simplified
    $('.m-gnb > li > a').off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var $li = $(this).closest('li');
        var $sub = $li.find('.m-dep2');
        
        console.log('Mobile menu link clicked:', $li.find('> a').text().trim());

        if ($sub.length > 0) {
            if ($sub.is(':animated')) return false;

            if ($li.hasClass('on')) {
                $li.removeClass('on');
                $sub.slideUp(300);
            } else {
                // Close other items
                $('.m-gnb > li').not($li).removeClass('on').find('.m-dep2').slideUp(300);
                $li.addClass('on');
                $sub.slideDown(300);
            }
        } else {
             var link = $(this).attr('href');
             if (link && link !== 'javascript:void(0)' && link !== '#') {
                 window.location.href = link;
             }
        }
        return false;
    });

    // Header Background Change on Scroll
    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 50) {
            $('#mainHeader').addClass('is-scrolled');
        } else {
            $('#mainHeader').removeClass('is-scrolled');
        }
    });
});
</script>