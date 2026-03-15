<?php
if (!defined('_GNUBOARD_')) exit;

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

// [Dynamic Menu] top_menu_manager & pro_menu_manager 연동
$logo_url = G5_THEME_URL . '/m_logo.png'; // 기본 로고

if (defined('G5_PLUGIN_PATH')) {
    $top_menu_lib = G5_PLUGIN_PATH . '/top_menu_manager/lib.php';
    if (file_exists($top_menu_lib)) {
        include_once($top_menu_lib);
        
        // 상단 메뉴 설정 가져오기 (식별코드: kukdong_panel)
        $tm_id = 'kukdong_panel';
        $tm = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '$tm_id' ");
        
        if ($tm) {
            // 로고 설정 적용
            if ($tm['tm_logo_pc']) {
                $logo_url = G5_DATA_URL . '/common/' . $tm['tm_logo_pc'];
            }
            
            // 메뉴 테이블 설정 적용
            if ($tm['tm_menu_table'] && !defined('G5_PRO_MENU_TABLE')) {
                define('G5_PRO_MENU_TABLE', 'g5_write_menu_pdc_' . $tm['tm_menu_table']);
            }
        }
    }
    
    $pro_menu_lib = G5_PLUGIN_PATH . '/pro_menu_manager/lib.php';
    if (file_exists($pro_menu_lib)) {
        include_once($pro_menu_lib);
    }
}
?>

<header id="mainHeader" class="header">
    <div class="gnbWrapBg">
        <div class="container gnbArea">
            <a href="#" class="btnAllmenu"><i class="fas fa-bars"></i></a>
            <h1 class="logo"><a href="<?php echo G5_URL ?>"><img src="<?php echo $logo_url ?>" alt="성우첨단패널 로고"></a></h1>
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

<!-- 모바일 메뉴 드로어 -->
<div class="m-menu-overlay"></div>
<div class="m-menu-wrap">
    <div class="m-menu-header">
        <div class="m-logo-area">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo $logo_url ?>" alt="성우첨단패널 로고"></a>
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

<div id="wrapper">
    <div id="container_wr">
        <div id="container">