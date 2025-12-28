<?php
if (!defined('_GNUBOARD_'))
    exit;

// Menu Data Load
$menu_datas = get_menu_db(0, true);

// [FIX] Load Skin CSS (Required for Live Site)
$menu_skin_url = str_replace(G5_PATH, G5_URL, dirname(__FILE__));
add_stylesheet('<link rel="stylesheet" href="' . $menu_skin_url . '/style.css?v=' . time() . '">', 0);
?>

<div class="centered-header">
    <div class="header-inner">
        <!-- Logo (Top) -->
        <div id="logo">
            <a href="<?php echo G5_URL ?>">
                <?php
                // Centered skin has a dark background, so we need the 'Dark Mode' logo (White text).
                // Admin 'logo_pc_dark' saves to top_logo_dark.png.
                $logo_path = G5_DATA_PATH . '/common/top_logo_dark.png';
                if (file_exists($logo_path)) {
                    echo '<img src="' . G5_DATA_URL . '/common/top_logo_dark.png?v=' . time() . '" alt="' . $config['cf_title'] . '">';
                } else {
                    echo '<img src="' . G5_IMG_URL . '/logo.png" alt="' . $config['cf_title'] . '">';
                }
                ?>
            </a>
        </div>

        <!-- Navigation (Bottom) -->
        <nav id="gnb">
            <ul id="gnb_1dul">
                <?php foreach ($menu_datas as $row) {
                    if (empty($row))
                        continue;
                    $has_sub = (isset($row['sub']) && is_array($row['sub']) && count($row['sub']) > 0);
                    $is_wide = ($has_sub && count($row['sub']) >= 10);
                    ?>
                    <li class="gnb_1dli">
                        <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da">
                            <?php echo $row['me_name'] ?>
                        </a>

                        <?php if ($has_sub) { ?>
                            <ul class="gnb_2dul <?php echo $is_wide ? 'wide-dropdown' : ''; ?>">
                                <?php foreach ($row['sub'] as $row2) { ?>
                                    <li>
                                        <a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"
                                            class="gnb_2da">
                                            <?php echo $row2['me_name'] ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>

<!-- Mobile Hamburger Button (Visible only on Mobile via CSS) -->
<button type="button" class="gnb_menu_btn" id="gnb_menu_btn"
    style="position:absolute; top:20px; right:20px; z-index:9999; display:none;">
    <i class="fa fa-bars" aria-hidden="true" style="color:#fff; font-size:24px;"></i>
</button>

<!-- Full Screen Mobile Overlay Menu (Initially Hidden) -->
<div id="gnb_all">
    <div class="gnb_all_wr">
        <div class="gnb_all_header"
            style="position: relative; height: 60px; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid rgba(255,255,255,0.05);">

            <!-- Centered Utility Links -->
            <div class="hd_login_mobile"
                style="display: flex; gap: 20px; font-size: 14px; color: #a0a0a0; font-weight: 500;">
                <?php if ($is_member) { ?>
                    <a href="<?php echo G5_BBS_URL ?>/logout.php" style="color:inherit;">LOGOUT</a>
                    <?php if ($is_admin) { ?>
                        <a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>" style="color:inherit;">ADMIN</a>
                    <?php } ?>
                <?php } else { ?>
                    <a href="<?php echo G5_BBS_URL ?>/login.php" style="color:inherit;">LOGIN</a>
                <?php } ?>
                <a href="mailto:<?php echo $config['cf_admin_email']; ?>" style="color:inherit;">CONTACTUS</a>
            </div>

            <!-- Absolute Positioned Close Button (Right) -->
            <button type="button" class="gnb_close_btn"
                style="position: absolute; right: 20px; top: 0; width: 60px; height: 60px; background: none; border: none; color: #fff; font-size: 24px; cursor: pointer;">
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>
        </div>
        <ul class="gnb_al_ul">
            <?php foreach ($menu_datas as $row) {
                if (empty($row))
                    continue;
                ?>
                <li class="gnb_al_li">
                    <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_al_a">
                        <?php echo $row['me_name'] ?>
                    </a>
                    <?php if (isset($row['sub']) && $row['sub']) { ?>
                        <ul>
                            <?php foreach ((array) $row['sub'] as $row2) {
                                if (empty($row2))
                                    continue;
                                ?>
                                <li>
                                    <a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>">
                                        <?php echo $row2['me_name'] ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<script>
    $(function () {
        // [IMPORTANT] Move the mobile menu to the body tag to avoid Z-index/Transform issues
        // caused by the header or wrapper layout. This fixes the transparency/cut-off bug.
        $("#gnb_all").appendTo("body");

        // Toggle Mobile Menu
        $(".gnb_menu_btn").click(function () {
            $("#gnb_all").fadeIn(300);
            $("body").css("overflow", "hidden"); // Prevent background scrolling
        });

        $(".gnb_close_btn").click(function () {
            $("#gnb_all").fadeOut(300);
            $("body").css("overflow", "");
        });
    });
</script>