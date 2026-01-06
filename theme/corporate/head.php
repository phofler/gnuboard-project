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
<!-- 상단 시작 { -->
<div id="hd" style="width:100%; padding:0; background:var(--color-bg-dark, #121212);">
    <!-- Top Menu Plugin (Handles Logo, Menu, Login via Skin) -->
    <?php
    if (defined('G5_PLUGIN_PATH') && file_exists(G5_PLUGIN_PATH . '/pro_menu_manager/lib.php')) {
        include_once(G5_PLUGIN_PATH . '/pro_menu_manager/lib.php');
        if (function_exists('display_pro_menu')) {
            // [Dynamic Skin Loading]
            display_pro_menu();
        }
    }
    ?>
</div>
<!-- } 상단 끝 -->
<!-- } ?곷떒 ??-->

<?php
// Sub Design Logic
include_once(G5_PLUGIN_PATH . '/sub_design/lib/design.lib.php');

// 1. Detect ME_CODE
$current_me_code = '';

// Determine Menu Table (Pro Menu Manager support)
$sd_lang = (defined('G5_LANG')) ? G5_LANG : 'kr';
$menu_table = ($sd_lang == 'kr') ? "g5_write_menu_pdc" : "g5_write_menu_pdc_" . $sd_lang;
$check = sql_fetch(" SHOW TABLES LIKE '$menu_table' ");
$col_prefix = 'ma';
if (!$check) {
    $menu_table = $g5['menu_table']; // Fallback to default
    $col_prefix = 'me';
}
$code_col = $col_prefix . '_code';
$link_col = $col_prefix . '_link';
$name_col = $col_prefix . '_name';

// Priority 1: Tree Category Page (cate match) - Most Specific
if (!$current_me_code && isset($_GET['cate']) && $_GET['cate']) {
    $current_me_code = 'TC' . clean_xss_tags($_GET['cate']);
}

// Priority 2: Content Page (co_id match)
if (!$current_me_code && isset($co_id) && $co_id) {
    // Find menu by link
    $sql = " SELECT $code_col as me_code FROM $menu_table WHERE $link_col LIKE '%co_id={$co_id}%' ORDER BY length($code_col) DESC LIMIT 1 ";
    $row = sql_fetch($sql);
    if ($row)
        $current_me_code = $row['me_code'];
}

// Priority 3: Board Page (bo_table match)
if (!$current_me_code && isset($bo_table) && $bo_table) {
    $sql = " SELECT $code_col as me_code FROM $menu_table WHERE $link_col LIKE '%bo_table={$bo_table}%' ORDER BY length($code_col) DESC LIMIT 1 ";
    $row = sql_fetch($sql);
    if ($row)
        $current_me_code = $row['me_code'];
}

// 2. Fetch Design Data
$sub_design = array();
if ($current_me_code) {
    // Construct sd_id (Theme + Lang)
    $sd_id = $config['cf_theme'];
    $sd_lang = (defined('G5_LANG')) ? G5_LANG : 'kr';
    if ($sd_lang != 'kr') {
        $sd_id .= '_' . $sd_lang;
    }

    $sub_design = get_sub_design($sd_id, $current_me_code);
    if (!is_array($sub_design))
        $sub_design = array();
}

// 3. Fallback/Defaults
if (empty($sub_design['sd_visual_img']) && empty($sub_design['sd_visual_url'])) {
    $sub_design['sd_visual_url'] = 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1920&auto=format&fit=crop';
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
    $nav_3rd_name = '';

    if (isset($current_me_code) && $current_me_code) {
        $code_1st = substr($current_me_code, 0, 2);
        // Fetch 1st depth name
        $row_1st = sql_fetch(" SELECT $name_col as me_name FROM $menu_table WHERE $code_col = '{$code_1st}' ");
        if ($row_1st['me_name'])
            $nav_1st_name = $row_1st['me_name'];

        // Fetch 2nd depth name
        if (strlen($current_me_code) >= 4) {
            $code_2nd = substr($current_me_code, 0, 4);
            $row_2nd = sql_fetch(" SELECT $name_col as me_name FROM $menu_table WHERE $code_col = '{$code_2nd}' ");
            if ($row_2nd['me_name'])
                $nav_2nd_name = $row_2nd['me_name'];
        }

        // Fetch 3rd depth name if applicable
        if (strlen($current_me_code) >= 6) {
            $row_3rd = sql_fetch(" SELECT $name_col as me_name FROM $menu_table WHERE $code_col = '{$current_me_code}' ");
            if ($row_3rd['me_name'])
                $nav_3rd_name = $row_3rd['me_name']; // Optional: Handle 3-depth breadcrumb later
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

    // Render Sub Design with Skin System
    $sd_skin = isset($sub_design['sd_skin']) ? $sub_design['sd_skin'] : 'standard';
    $skin_path = G5_PLUGIN_PATH . '/sub_design/skins/' . $sd_skin . '/main.skin.php';

    // Mock item for skin (compatibility with existing skin vars)
    $item = $sub_design;
    $item['sd_main_text'] = $hero_title; // Use calculated hero title

    if (file_exists($skin_path)) {
        include($skin_path);
    } else {
        // Fallback to internal rendering if skin missing
        $sd_img_url = $sub_design['sd_visual_url'] ? $sub_design['sd_visual_url'] : G5_DATA_URL . '/sub_visual/' . $sub_design['sd_visual_img'];
        if (!$sd_img_url)
            $sd_img_url = 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1920&auto=format&fit=crop';
        ?>
        <section class="sub-hero">
            <div class="sub-hero-bg" style="background-image: url('<?php echo $sd_img_url; ?>');"></div>
            <div class="sub-hero-content" data-aos="fade-up" data-aos-duration="1000">
                <?php if (isset($sub_design['sd_sub_text']) && $sub_design['sd_sub_text']) { ?>
                    <p class="sub-hero-subtitle"><?php echo $sub_design['sd_sub_text']; ?></p>
                <?php } ?>
                <h1 class="sub-hero-title"><?php echo $hero_title; ?></h1>
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
                $class = (!$nav_2nd_name && !$nav_3rd_name) ? 'class="current"' : '';
                echo ' &gt; <span ' . $class . '>' . $nav_1st_name . '</span>';
            }
            if ($nav_2nd_name) {
                $class = (!$nav_3rd_name) ? 'class="current"' : '';
                echo ' &gt; <span ' . $class . '>' . $nav_2nd_name . '</span>';
            }
            if (isset($nav_3rd_name) && $nav_3rd_name) {
                echo ' &gt; <span class="current">' . $nav_3rd_name . '</span>';
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