<?php
if (!defined('_GNUBOARD_'))
    exit;

// Menu Data Load
// Menu Data Load
// Menu Data Load
// $menu_datas = get_menu_db(0, true);

// [FIX] Load Skin CSS (Required for Live Site)
// [FIX] Load Skin CSS (Required for Live Site)
$menu_skin_url = G5_PLUGIN_URL . '/top_menu_manager/skins/transparent';
add_stylesheet('<link rel="stylesheet" href="' . $menu_skin_url . '/style.css?v=' . time() . '">', 0);
?>

<div class="transparent-header">
    <div id="logo">
        <a href="<?php echo G5_URL ?>">
            <?php
            // [Unified] Use 'top_logo_dark.png' (Single PC Logo)
            $logo_path = G5_DATA_PATH . '/common/top_logo_dark.png';
            if (file_exists($logo_path)) {
                echo '<img src="' . G5_DATA_URL . '/common/top_logo_dark.png?v=' . time() . '" alt="' . $config['cf_title'] . '">';
            } else {
                echo '<img src="' . G5_IMG_URL . '/logo.png" alt="' . $config['cf_title'] . '">';
            }
            ?>
        </a>
    </div>

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

    <!-- Desktop Login/Utility Links -->
    <ul class="hd_login"
        style="display:flex; gap:20px; align-items:center; list-style:none; margin:0; padding:0; margin-right:20px;">
        <?php if ($is_member) { ?>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php"
                    style="color:#fff; text-decoration:none; font-size:14px; font-weight:500;">LOGOUT</a></li>
            <?php if ($is_admin) { ?>
                <li><a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>"
                        style="color:#fff; text-decoration:none; font-size:14px; font-weight:500;">ADMIN</a></li>
            <?php } ?>
        <?php } else { ?>
            <li><a href="<?php echo G5_BBS_URL ?>/login.php"
                    style="color:#fff; text-decoration:none; font-size:14px; font-weight:500;">LOGIN</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/register.php"
                    style="color:#fff; text-decoration:none; font-size:14px; font-weight:500;">JOIN</a></li>
        <?php } ?>
    </ul>

    <a href="mailto:<?php echo $config['cf_admin_email']; ?>" class="btn-inquiry">Contact Us</a>

    <!-- Mobile Hamburger Button -->
    <button type="button" class="gnb_menu_btn" id="gnb_menu_btn">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </button>
</div>

<!-- Full Screen Mobile Overlay Menu (Standard Responsive Structure) -->
<div id="gnb_all">
    <div class="gnb_all_wr">
        <div class="gnb_all_header"
            style="position: relative; height: 60px; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid rgba(255,255,255,0.05);">

            <!-- Mobile Utility Links -->
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

                                $has_sub_3rd = (isset($row2['sub']) && is_array($row2['sub']) && count($row2['sub']) > 0);
                                ?>
                                <li style="position:relative;">
                                    <a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>">
                                        <?php echo $row2['me_name'] ?>
                                    </a>
                                    <?php if ($has_sub_3rd) { ?>
                                        <button type="button" class="btn_3rd_toggle"
                                            style="position:absolute; right:0; top:0; width:50px; height:100%; border:none; background:none; color:#fff; cursor:pointer; z-index:10;">
                                            <i class="fa fa-chevron-down"></i>
                                        </button>
                                        <ul class="gnb_3rd_mobile"
                                            style="display:none; background:rgba(255,255,255,0.05); padding:10px 0;">
                                            <?php foreach ($row2['sub'] as $row3) {
                                                if (empty($row3))
                                                    continue;
                                                ?>
                                                <li>
                                                    <a href="<?php echo $row3['me_link']; ?>" target="<?php echo $row3['me_target']; ?>"
                                                        style="padding-left:30px; font-size:13px; color:#aaa;">
                                                        - <?php echo $row3['me_name'] ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
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
        // [IMPORTANT] Move the mobile menu to the body tag
        $("#gnb_all").appendTo("body");

        // Toggle Mobile Menu
        $(".gnb_menu_btn").click(function () {
            $("#gnb_all").fadeIn(300);
            $("body").css("overflow", "hidden");
        });

        $(".gnb_close_btn").click(function () {
            $("#gnb_all").fadeOut(300);
            $("body").css("overflow", "");
        });

        // [NEW] 3rd Depth Accordion
        $(".btn_3rd_toggle").click(function (e) {
            e.preventDefault();
            $(this).next(".gnb_3rd_mobile").slideToggle();
            $(this).find("i").toggleClass("fa-chevron-down fa-chevron-up");
        });

        // Current Scroll Logic
        window.addEventListener('scroll', function () {
            const header = document.querySelector('.transparent-header');
            if (header) {
                header.classList.toggle('scrolled', window.scrollY > 50);
            }
        });
    });
</script>