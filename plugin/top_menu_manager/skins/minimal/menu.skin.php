<?php
if (!defined('_GNUBOARD_'))
    exit;

// Menu Data Load
$menu_datas = get_menu_db(0, true);

// [FIX] Load Skin CSS (Required for Live Site)
$menu_skin_url = str_replace(G5_PATH, G5_URL, dirname(__FILE__));
add_stylesheet('<link rel="stylesheet" href="' . $menu_skin_url . '/style.css?v=' . time() . '">', 0);
?>

<div class="minimal-header">
    <!-- Logo -->
    <div id="logo">
        <a href="<?php echo G5_URL ?>">
            <?php
            $logo_path = G5_DATA_PATH . '/common/top_logo_dark.png'; // Minimal prefers dark/clean logo
            if (file_exists($logo_path)) {
                echo '<img src="' . G5_DATA_URL . '/common/top_logo_dark.png?v=' . time() . '" alt="' . $config['cf_title'] . '">';
            } else {
                echo '<img src="' . G5_IMG_URL . '/logo.png" alt="' . $config['cf_title'] . '">';
            }
            ?>
        </a>
    </div>

    <!-- Hamburger Trigger -->
    <button class="menu-toggle" onclick="toggleMinimalMenu()">
        Menu <i class="fa fa-bars"></i>
    </button>
</div>

<!-- Fullscreen Overlay -->
<div class="overlay-menu" id="minimalOverlay">
    <button class="overlay-close" onclick="toggleMinimalMenu()">&times;</button>

    <ul class="menu-list">
        <?php foreach ($menu_datas as $row) {
            if (empty($row))
                continue;
            $has_sub = (isset($row['sub']) && is_array($row['sub']) && count($row['sub']) > 0);
            ?>
            <li>
                <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>">
                    <?php echo $row['me_name'] ?>
                </a>

                <?php if ($has_sub) { ?>
                    <ul class="submenu">
                        <?php foreach ($row['sub'] as $row2) { ?>
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

<script>
    function toggleMinimalMenu() {
        var overlay = document.getElementById('minimalOverlay');
        overlay.classList.toggle('active');

        if (overlay.classList.contains('active')) {
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        } else {
            document.body.style.overflow = '';
        }
    }

    // Add Accordion Logic
    $(document).ready(function () {
        $(".menu-list > li > a").click(function (e) {
            // Check if this item has a submenu
            var $submenu = $(this).next(".submenu");
            if ($submenu.length > 0) {
                e.preventDefault(); // Stop link navigation
                $(this).parent("li").toggleClass("active"); // Toggle visibility
            }
        });
    });
</script>