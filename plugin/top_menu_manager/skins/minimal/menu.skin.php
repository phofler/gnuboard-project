<?php
if (!defined('_GNUBOARD_'))
    exit;

// Menu Data Load (Already supplied by display_pro_menu in lib.php)
// $menu_datas = get_menu_db(0, true);

// [FIX] Load Skin CSS (Handled by lib.php)
// $menu_skin_url = G5_PLUGIN_URL . '/top_menu_manager/skins/minimal';
// echo '<link rel="stylesheet" href="' . $menu_skin_url . '/style.css?v=' . time() . '">';
?>

<div class="minimal-header">
    <!-- Logo -->
    <div id="logo">
        <a href="<?php echo G5_URL ?>">
            <?php
            // Custom Logo Logic (Dynamic)
            $logo_src = G5_IMG_URL . '/logo.png';
            $custom_logo_path = G5_DATA_PATH . '/common/top_logo_dark.png'; // Minimal prefers dark/clean logo
            
            if (isset($top_logo_pc) && $top_logo_pc) {
                // Use Configured Logo
                $logo_src = $top_logo_pc . '?v=' . time();
            } else if (file_exists($custom_logo_path)) {
                $logo_src = G5_DATA_URL . '/common/top_logo_dark.png?v=' . time();
            } else {
                // Windows Path Fix (from Basic Skin)
                $custom_logo_path_win = str_replace('/', '\\', $custom_logo_path);
                if (file_exists($custom_logo_path_win)) {
                    $logo_src = G5_DATA_URL . '/common/top_logo_dark.png?v=' . time();
                }
            }
            ?>
            <img src="<?php echo $logo_src; ?>" alt="<?php echo $config['cf_title']; ?>">
        </a>
    </div>

    <!-- Minimal Menu Button (Hamburger) -->
    <button type="button" class="minimal-menu-btn" onclick="toggleMinimalMenu()">
        <i class="fa fa-bars"></i>
    </button>
</div>

<!-- Full Screen Overlay -->
<div class="overlay-menu">
    <button type="button" class="overlay-close" onclick="toggleMinimalMenu()">
        <i class="fa fa-times"></i>
    </button>
    <div class="menu-container">
        <ul class="menu-list">
            <?php foreach ($menu_datas as $row) {
                if (empty($row))
                    continue;
                ?>
                <li>
                    <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>">
                        <?php echo $row['me_name'] ?>
                    </a>
                    <!-- Submenu (Optional) -->
                    <?php if (isset($row['sub']) && $row['sub']) { ?>
                        <ul class="submenu">
                            <?php foreach ($row['sub'] as $row2) { ?>
                                <li>
                                    <a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>">
                                        - <?php echo $row2['me_name'] ?>
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
    // [FIX] Move Overlay to Body to escape Theme's default.css constraints (Backdrop/Overflow)
    // This is the critical fix for "Corporate Ultimate" Light Theme
    $(function () {
        $(".overlay-menu").appendTo("body");
    });

    function toggleMinimalMenu() {
        const overlay = document.querySelector('.overlay-menu');
        const btn = document.querySelector('.minimal-menu-btn i');

        overlay.classList.toggle('active');

        // Handle Button Icon & Scroll Lock
        if (overlay.classList.contains('active')) {
            btn.classList.remove('fa-bars');
            btn.classList.add('fa-times');
            document.body.style.overflow = 'hidden';
        } else {
            btn.classList.remove('fa-times');
            btn.classList.add('fa-bars');
            document.body.style.overflow = '';
        }
    }

    // Add Accordion Logic
    $(document).ready(function () {
        $(".menu-list > li > a").click(function (e) {
            // Check if this item has a submenu
            var $submenu = $(this).next(".submenu"); // Standardized class
            if ($submenu.length > 0) {
                e.preventDefault(); // Stop link navigation
                $(this).parent("li").toggleClass("active"); // Toggle visibility
            }
        });
    });
</script>