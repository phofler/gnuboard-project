<?php
if (!defined('_GNUBOARD_')) exit;

// Menu Data Load
include_once(G5_PLUGIN_PATH . '/top_menu_manager/skin.head.php');
$menu_skin_url = G5_PLUGIN_URL . '/top_menu_manager/skins/centered';
?>

<header id="mainHeader" class="header centered">
    <div class="gnbWrapBg">
        <div class="container gnbArea">
            <h1 class="logoCentered"><a href="<?php echo G5_URL ?>"><img src="<?php echo $logo_src ?>" alt="로고"></a></h1>
            <nav style="flex:1;">
                <ul class="gnb" id="gnb" style="justify-content:center;">
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
                <a href="/contact_us/online.php" class="btn-lang desktop-only">CONTACT</a>
                <a href="tel:1551-9123" class="btnAllmenu mobile-only"><i class="fas fa-bars"></i></a>
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