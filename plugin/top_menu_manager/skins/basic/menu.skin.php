<?php
if (!defined('_GNUBOARD_'))
    exit;

// Menu Data Load (Fallback if not provided by controller)
if (!isset($menu_datas) || empty($menu_datas)) {
    $menu_datas = get_menu_db(0, true);
}

// [FIX] Load Skin CSS (Direct Echo required because head is already closed)
$menu_skin_url = G5_PLUGIN_URL . '/top_menu_manager/skins/basic';
echo '<link rel="stylesheet" href="' . $menu_skin_url . '/style.css?v=' . time() . '">';
?>

<!-- Mega Menu Skin (Basic Dark - Strict Match to menu_mega.html) -->
<!-- Root is .gnb_wrap directly inside #hd -->
<div class="gnb_wrap">

    <!-- Logo (Dynamic) -->
    <div id="logo">
        <a href="<?php echo G5_URL ?>">
            <?php
            // Custom Logo Logic (Dynamic)
            $logo_src = G5_IMG_URL . '/logo.png';
            $custom_logo_path = G5_DATA_PATH . '/common/top_logo_dark.png';

            if (isset($top_logo_pc) && $top_logo_pc) {
                // Use Configured Logo
                $logo_src = $top_logo_pc . '?v=' . time();
            } else if (file_exists($custom_logo_path)) {
                $logo_src = G5_DATA_URL . '/common/top_logo_dark.png?v=' . time();
            } else {
                // Fallback debug: check alternative slash consistency just in case
                $custom_logo_path_win = str_replace('/', '\\', $custom_logo_path);
                if (file_exists($custom_logo_path_win)) {
                    $logo_src = G5_DATA_URL . '/common/top_logo_dark.png?v=' . time();
                }
            }
            ?>
            <img src="<?php echo $logo_src; ?>" alt="<?php echo $config['cf_title']; ?>">
        </a>
    </div>

    <!-- Nav containing the list -->
    <nav id="gnb" style="height: 100%;">
        <ul id="gnb_1dul">
            <?php foreach ($menu_datas as $row) {
                if (empty($row))
                    continue;
                ?>
                <li class="gnb_1dli">
                    <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da">
                        <?php echo $row['me_name'] ?>
                    </a>
                </li>
            <?php } ?>
        </ul>

        <!-- The Mega Panel (Sibling inside Nav or Wrap? In sample it was sibling to UL inside NAV, or sibling to NAV inside Wrap?) -->
        <!-- Reviewing menu_mega.html Step 68: 
             <nav id="gnb"> <ul id="gnb_1dul">...</ul> <div id="gnb_mega_panel">...</div> </nav> 
             The Panel IS inside the NAV in the sample file. So this structure is correct.
        -->
        <div id="gnb_mega_panel">
            <div class="mega_inner">
                <?php foreach ($menu_datas as $row) {
                    if (empty($row))
                        continue;
                    ?>
                    <div class="mega_col">
                        <h3>
                            <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>">
                                <?php echo $row['me_name'] ?>
                            </a>
                        </h3>

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
                                        <!-- [FIX] 3rd Depth Display (Indented with Dot) -->
                                        <?php
                                        if (isset($row2['sub']) && is_array($row2['sub']) && count($row2['sub']) > 0) {
                                            echo '<ul class="gnb_3dul" style="padding-left: 15px; margin-top: 5px; list-style: none;">';
                                            foreach ($row2['sub'] as $row3) {
                                                if (empty($row3))
                                                    continue;
                                                ?>
                                            <li style="margin-bottom: 3px;">
                                                <a href="<?php echo $row3['me_link']; ?>" target="<?php echo $row3['me_target']; ?>"
                                                    style="font-size: 13px; color: #888; display: flex; align-items: center;">
                                                    <span
                                                        style="font-size: 6px; margin-right: 8px; color: var(--color-accent-gold);">●</span>
                                                    <?php echo $row3['me_name'] ?>
                                                </a>
                                            </li>
                                            <?php
                                            }
                                            echo '</ul>';
                                        }
                                        ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </nav>

    <!-- Mobile Hamburger Button (Visible only on Mobile via CSS) -->
    <button type="button" class="gnb_menu_btn" id="gnb_menu_btn">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </button>

    <!-- Right Side Icons (Login/Admin) -->
    <div class="hd_login">
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

</div>

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

                                $has_sub_3rd = (isset($row2['sub']) && is_array($row2['sub']) && count($row2['sub']) > 0);
                                ?>
                                <li style="position:relative;">
                                    <a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"
                                        style="display:inline-block; width: <?php echo $has_sub_3rd ? '85%' : '100%'; ?>;">
                                        <?php echo $row2['me_name'] ?>
                                    </a>
                                    <?php if ($has_sub_3rd) { ?>
                                        <button type="button" class="btn_3rd_toggle"
                                            style="position:absolute; right:0; top:0; width:15%; height:100%; border:none; background:none; color:#fff; cursor:pointer;">
                                            <i class="fa fa-chevron-down"></i>
                                        </button>
                                        <ul class="gnb_3rd_mobile" style="display:none; background:rgba(0,0,0,0.3); padding:10px 0;">
                                            <?php foreach ($row2['sub'] as $row3) {
                                                if (empty($row3))
                                                    continue;
                                                ?>
                                                <li>
                                                    <a href="<?php echo $row3['me_link']; ?>" target="<?php echo $row3['me_target']; ?>"
                                                        style="padding-left:30px; font-size:13px; color:#ccc;">
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
    });
</script>