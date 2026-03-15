<?php
if (!defined('_GNUBOARD_'))
    exit;

// 1. Get current hierarchy details (Calculated in head.php)
// $current_me_code is available
// $nav_1st_name, $nav_2nd_name are available

// 2. Fetch full menu tree to find siblings/children
if (function_exists('get_pro_menu_list')) {
    $raw_menus = get_pro_menu_list();
    $menu_tree = build_pro_menu_tree($raw_menus);
} else {
    return; // Safety
}

// 3. Find the current root item
$root_item = null;
$code_1st = substr($current_me_code, 0, 2);
foreach ($menu_tree as $code => $m) {
    if ($code == $code_1st) {
        $root_item = $m;
        break;
    }
}

if (!$root_item)
    return;
?>

<div class="sidebar-header">
    <h2>
        <?php echo $root_item['ma_name']; ?>
    </h2>
    <span>Sub Categories</span>
</div>

<ul class="sidebar-menu">
    <?php
    if (!empty($root_item['sub'])) {
        foreach ($root_item['sub'] as $code => $m) {
            $is_active = (substr($current_me_code, 0, 4) === $code);
            $active_cls = $is_active ? 'active' : '';

            // Check for depth 3 children
            $has_sub = !empty($m['sub']);
            ?>
            <li class="menu-item depth-2 <?php echo $active_cls; ?> <?php echo $has_sub ? 'has-sub' : ''; ?>">
                <a href="<?php echo $m['ma_link']; ?>" class="<?php echo ($has_sub && $is_active) ? 'toggle-active' : ''; ?>">
                    <?php echo $m['ma_name']; ?>
                    <?php if ($has_sub) { ?>
                        <i class="fa fa-chevron-right arrow-icon"></i>
                    <?php } ?>
                </a>

                <?php if ($has_sub) { ?>
                    <ul class="sub-menu" style="<?php echo $is_active ? 'display:block;' : 'display:none;'; ?>">
                        <?php foreach ($m['sub'] as $sub_code => $sub) {
                            $is_sub_active = ($current_me_code === $sub_code);
                            ?>
                            <li class="depth-3 <?php echo $is_sub_active ? 'active' : ''; ?>">
                                <a href="<?php echo $sub['ma_link']; ?>">-
                                    <?php echo $sub['ma_name']; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </li>
            <?php
        }
    }
    ?>
</ul>

<style>
    /* LNB Sidebar Styling */
    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu .menu-item {
        border-bottom: 1px solid var(--color-border);
    }

    .sidebar-menu .menu-item:last-child {
        border-bottom: none;
    }

    .sidebar-menu .menu-item a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 10px;
        color: var(--color-text-secondary);
        text-decoration: none;
        transition: all 0.2s;
        font-weight: 500;
    }

    .sidebar-menu .menu-item a:hover {
        color: var(--color-accent-gold);
        padding-left: 15px;
    }

    .sidebar-menu .menu-item.active>a {
        color: var(--color-accent-gold);
        font-weight: 700;
    }

    /* Sub Menu (Depth 3) */
    .sidebar-menu .sub-menu {
        list-style: none;
        padding: 5px 0 15px 0;
        background: rgba(0, 0, 0, 0.02);
    }

    .sidebar-menu .sub-menu li a {
        padding: 8px 20px;
        font-size: 0.9rem;
        font-weight: 400;
    }

    .sidebar-menu .sub-menu li.active a {
        color: var(--color-accent-gold);
        font-weight: 600;
    }

    .arrow-icon {
        font-size: 0.7rem;
        transition: transform 0.3s;
    }

    .menu-item.active .arrow-icon {
        transform: rotate(90deg);
    }
</style>

<script>
    $(document).ready(function () {
        $('.sidebar-menu .has-sub > a').on('click', function (e) {
            if ($(this).attr('href') === '#' || $(this).hasClass('toggle-active')) {
                e.preventDefault();
                $(this).next('.sub-menu').slideToggle(300);
                $(this).parent().toggleClass('open');
            }
        });
    });
</script>