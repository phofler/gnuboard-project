<?php
if (!defined('_GNUBOARD_'))
    exit; // 媛쒕퀎 ?섏씠吏 ?묎렐 遺덇?

// if (G5_IS_MOBILE) {
//     include_once(G5_THEME_MOBILE_PATH . '/head.php');
//     return;
// }

if (G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once(G5_THEME_SHOP_PATH . '/shop.head.php');
    return;
}
include_once(G5_THEME_PATH . '/head.sub.php');
include_once(G5_LIB_PATH . '/latest.lib.php');
include_once(G5_LIB_PATH . '/outlogin.lib.php');
include_once(G5_LIB_PATH . '/poll.lib.php');
include_once(G5_LIB_PATH . '/visit.lib.php');
include_once(G5_LIB_PATH . '/connect.lib.php');
include_once(G5_LIB_PATH . '/popular.lib.php');
?>

<!-- ?곷떒 ?쒖옉 { -->
<div id="hd">
    <!-- <div id="hd_wrapper"> -->
    <!-- <div id="logo">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_IMG_URL ?>/logo.png?v=<?php echo date('YmdHis'); ?>"
                    alt="<?php echo $config['cf_title']; ?>"></a>
        </div> -->

    <!-- Top Menu Plugin -->
    <?php
    if (defined('G5_PLUGIN_PATH') && file_exists(G5_PLUGIN_PATH . '/top_menu_manager/lib.php')) {
        include_once(G5_PLUGIN_PATH . '/top_menu_manager/lib.php');
        display_top_menu();
    }
    ?>

    <!-- <ul class="hd_login">
            <?php
            if ($is_member) { //湲곗〈 硫ㅻ쾭?쇰㈃
                ?>
                <li><a href="<?php echo G5_BBS_URL ?>/logout.php">LOGOUT</a></li>
                <?php if ($is_admin) { ?>
                    <li class="tnb_admin"><a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">ADMIN</a></li>
                <?php } ?>
            <?php } else { ?>
                <li><a href="<?php echo G5_BBS_URL ?>/login.php">LOGIN</a></li>
            <?php } ?>
        </ul> -->
    <!-- </div> -->
</div>
<!-- } ?곷떒 ??-->

<?php
// Sub Design Logic
include_once(G5_PLUGIN_PATH . '/sub_design/lib/design.lib.php');

// 1. Detect ME_CODE
$current_me_code = '';

// Priority 0: Explicit URL Parameter (User Request)
if (isset($_GET['me_code']) && $_GET['me_code']) {
    $current_me_code = clean_xss_tags($_GET['me_code']);
}

// Priority 1: Content Page (co_id match)
if (!$current_me_code && isset($co_id) && $co_id) {
    // Find menu by link
    $sql = " SELECT me_code FROM {$g5['menu_table']} WHERE me_link LIKE '%co_id={$co_id}%' ORDER BY length(me_code) DESC LIMIT 1 ";
    $row = sql_fetch($sql);
    if ($row)
        $current_me_code = $row['me_code'];
}

// Priority 2: Board Page (bo_table match)
if (!$current_me_code && isset($bo_table) && $bo_table) {
    $sql = " SELECT me_code FROM {$g5['menu_table']} WHERE me_link LIKE '%bo_table={$bo_table}%' ORDER BY length(me_code) DESC LIMIT 1 ";
    $row = sql_fetch($sql);
    if ($row)
        $current_me_code = $row['me_code'];
}

// 2. Fetch Design Data
$sub_design = array();
if ($current_me_code) {
    $sub_design = get_sub_design($current_me_code);
    if (!is_array($sub_design))
        $sub_design = array();
}

// 3. Defaults if no data found (Optional: Set default image/text)
// 3. Defaults if no data found (Optional: Set default image/text)
// [FIX] Only apply fallback if BOTH image file and external URL are missing
if (empty($sub_design['sd_visual_img']) && empty($sub_design['sd_visual_url'])) {
    // Fallback for pages without explicit menu connection (like plugin pages)
    // Use an existing image from data/sub_visual/
    $sub_design['sd_visual_img'] = 'sub_visual_1020_1765854659.png';
    if (empty($sub_design['sd_main_text'])) {
        $sub_design['sd_main_text'] = $g5['title'];
    }
}

// Check if we are on a sub-page (not Main)
if (!defined('_INDEX_')) {

    // ------------------------------------------------------------------------
    // [MOVED] Dynamic Breadcrumb & Title Logic - Calculate BEFORE output
    // ------------------------------------------------------------------------
    $nav_1st_name = '';
    $nav_2nd_name = '';

    if (isset($current_me_code) && $current_me_code) {
        $code_1st = substr($current_me_code, 0, 2);
        // Fetch 1st depth name
        $row_1st = sql_fetch(" SELECT me_name FROM {$g5['menu_table']} WHERE me_code = '{$code_1st}' ");
        if ($row_1st['me_name'])
            $nav_1st_name = $row_1st['me_name'];

        // Fetch 2nd depth name if difference
        if (strlen($current_me_code) >= 4) {
            $row_2nd = sql_fetch(" SELECT me_name FROM {$g5['menu_table']} WHERE me_code = '{$current_me_code}' ");
            if ($row_2nd['me_name'])
                $nav_2nd_name = $row_2nd['me_name'];
        }
    } else {
        // Fallback for pages not in menu (e.g. Member pages, Search)
        $nav_2nd_name = $g5['title'];
    }

    // Determine Hero Title Priority: Custom > 2nd Menu > 1st Menu > Page Title
    $hero_title = $g5['title'];
    if (isset($sub_design['sd_main_text']) && $sub_design['sd_main_text']) {
        $hero_title = $sub_design['sd_main_text'];
    } elseif ($nav_2nd_name) {
        $hero_title = $nav_2nd_name;
    } elseif ($nav_1st_name) {
        $hero_title = $nav_1st_name;
    }

    $sd_img_url = '';

    // Validate image path
    if (isset($sub_design['sd_visual_img']) && $sub_design['sd_visual_img']) {
        $check_path = G5_DATA_PATH . '/sub_visual/' . $sub_design['sd_visual_img'];
        if (file_exists($check_path)) {
            $sd_img_url = G5_DATA_URL . '/sub_visual/' . $sub_design['sd_visual_img'];
        }
    }

    // [FIX] If no file image found, check for external URL
    if (!$sd_img_url && isset($sub_design['sd_visual_url']) && $sub_design['sd_visual_url']) {
        $sd_img_url = $sub_design['sd_visual_url'];
    }

    // Final Fallback if everything failed (should be caught by step 3 but double check)
    if (!$sd_img_url) {
        $sd_img_url = G5_DATA_URL . '/sub_visual/sub_visual_1020_1765854659.png';
    }

    if ($sd_img_url) {
        ?>
        <section class="sub-hero">
            <div class="sub-hero-bg" style="background-image: url('<?php echo $sd_img_url; ?>');"></div>
            <div class="sub-hero-content" data-aos="fade-up" data-aos-duration="1000">
                <?php if (isset($sub_design['sd_sub_text']) && $sub_design['sd_sub_text']) { ?>
                    <p class="sub-hero-subtitle">
                        <?php echo $sub_design['sd_sub_text']; ?>
                    </p>
                <?php } ?>
                <h1 class="sub-hero-title">
                    <?php echo $hero_title; ?>
                </h1>
            </div>
        </section>
        <?php
    }
    ?>

    <div class="breadcrumb">
        <div class="breadcrumb-inner">
            <span>Home</span>
            <?php
            if ($nav_1st_name) {
                echo ' &gt; <span>' . $nav_1st_name . '</span>';
            }
            if ($nav_2nd_name) {
                echo ' &gt; <span class="current">' . $nav_2nd_name . '</span>';
            }
            ?>
        </div>
    </div>

    <?php
}

?>

<!-- 肄섑뀗痢??쒖옉 { -->
<!-- 콘텐츠 시작 { -->
<div id="wrapper" <?php echo (defined('_INDEX_')) ? '' : ' class="sub-layout-light"'; ?>>
    <!-- container_wr removed/simplified for full width hero support in index -->
    <div id="container_wr">
        <div id="container">
            <?php if (!defined('_INDEX_')) { ?>
                <!-- [STANDARD] Sub Page Layout Wrapper (Padding: 60px, Width: 1400px) -->
                <!-- This wrapper handles all vertical spacing and alignment -->
                <!-- Do NOT use internal padding in skin files to avoid double padding -->
                <div class="sub-layout-width-height">
                <?php } ?>