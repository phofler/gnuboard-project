<?php
if (!defined('_GNUBOARD_'))
    exit;
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css?v=' . time() . '">', 0);
add_stylesheet('<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Nanum+Myeongjo:wght@400;700&family=Nanum+Gothic:wght@400;700&display=swap" rel="stylesheet">', 0);
add_stylesheet('<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">', 0);
?>

<div class="skin-container wz-container" id="bo_list">
    <!-- Category Filter (Type B: Strategic Dropdown) -->
    <?php if ($is_category) {
        $add_query = '';
        if (isset($_GET['me_code'])) {
            $add_query = '&me_code=' . urlencode($_GET['me_code']);
        }
        $category_href = G5_BBS_URL . '/board.php?bo_table=' . $bo_table . $add_query;
        $raw_cats = explode('|', $board['bo_category_list']);
        $structure = array();

        foreach ($raw_cats as $cat) {
            $cat = trim($cat);
            $cat = preg_replace('/\s*>\s*/', ' > ', $cat);
            if (!$cat)
                continue;

            $parts = explode(' > ', $cat);
            $root = trim($parts[0]);

            if (!isset($structure[$root])) {
                $structure[$root] = array('path' => $root, 'children' => array());
            }
            if (count($parts) == 2) {
                $sub = trim($parts[1]);
                $structure[$root]['children'][$cat] = $sub;
            }
        }

        // Determine Active Root
        $current_root = '';
        $current_stx = isset($_GET['stx']) ? $_GET['stx'] : '';
        if ($sca) {
            $sca_temp = explode('>', $sca);
            $current_root = trim($sca_temp[0]);
        } else if ($current_stx && strpos($current_stx, 'me_code') === false) {
            $stx_temp = explode('>', $current_stx);
            $current_root = trim($stx_temp[0]);
        }
        ?>
        <div id="bo_cate" class="category-ui-wrap" data-aos="fade-up">
            <ul class="cate-tabs">
                <li class="cate-item">
                    <a href="<?php echo $category_href ?>#bo_list"
                        class="cat-btn <?php echo ($sca == '' && $current_stx == '') ? 'active' : ''; ?>">All</a>
                </li>
                <?php foreach ($structure as $root_name => $data) {
                    $has_children = !empty($data['children']);
                    $is_active_root = ($current_root == $root_name);
                    ?>
                    <li class="cate-item <?php echo $has_children ? 'has-sub' : ''; ?>">
                        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $bo_table . $add_query; ?>&amp;sfl=ca_name&amp;stx=<?php echo urlencode($root_name); ?>#bo_list"
                            class="cat-btn <?php echo ($is_active_root || $current_stx == $root_name) ? 'active' : ''; ?>">
                            <?php echo $root_name; ?>
                        </a>
                        <?php if ($has_children) { ?>
                            <div class="cate-dropdown">
                                <?php foreach ($data['children'] as $full_path => $sub_name) {
                                    $is_active_sub = ($sca == $full_path || $current_stx == $full_path);
                                    ?>
                                    <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $bo_table . $add_query; ?>&amp;sfl=ca_name&amp;stx=<?php echo urlencode($full_path); ?>#bo_list"
                                        class="sub-link <?php echo $is_active_sub ? 'active' : ''; ?>">
                                        <?php echo $sub_name; ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <div class="webzine-list">
        <?php
        for ($i = 0; $i < count($list); $i++) {
            // 썸네일 생성
            $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], 800, 600, false, true);
            // Webzine skin uses larger thumbnails, proportional scaling
        
            $img_url = ($thumb['src']) ? $thumb['src'] : '';
            $has_img = !empty($img_url);

            // Alternating Logic
            $is_even = ($i % 2 == 0);
            $row_class = $is_even ? 'is-even' : 'is-odd';
            if (!$has_img)
                $row_class .= ' no-image';

            // edit link
            $edit_href = '';
            if ($is_admin == 'super' || $is_auth) {
                $edit_href = G5_BBS_URL . '/write.php?w=u&bo_table=' . $bo_table . '&wr_id=' . $list[$i]['wr_id'];
                if (isset($_GET['me_code']))
                    $edit_href .= '&me_code=' . urlencode($_GET['me_code']);
                $edit_href .= '#bo_w';
            }

            // Detail view link
            $view_url = $list[$i]['href'];
            if (isset($_GET['me_code']))
                $view_url .= '&me_code=' . urlencode($_GET['me_code']);
            $view_url .= '#bo_view'; // Anchor to View Top
            ?>
            <article class="webzine-item <?php echo $row_class; ?>" data-aos="fade-up">
                <?php if ($has_img) { ?>
                    <div class="webzine-thumb-wrap">
                        <a href="<?php echo $view_url; ?>">
                            <img src="<?php echo $img_url; ?>" class="webzine-thumb" alt="<?php echo $list[$i]['subject']; ?>">
                        </a>
                    </div>
                <?php } ?>

                <div class="webzine-content">
                    <div class="webzine-meta-top">
                        <?php if ($list[$i]['ca_name']) { ?>
                            <span class="webzine-cat"><?php echo $list[$i]['ca_name']; ?></span>
                        <?php } ?>
                        <span class="webzine-date"><?php echo $list[$i]['datetime2']; ?></span>
                    </div>

                    <h3 class="webzine-title">
                        <a href="<?php echo $view_url; ?>">
                            <?php echo $list[$i]['subject']; ?>
                        </a>
                        <?php if ($edit_href) { ?>
                            <a href="<?php echo $edit_href; ?>" class="btn-edit-list" title="Edit"
                                onclick="event.stopPropagation()">✎</a>
                        <?php } ?>
                    </h3>

                    <p class="webzine-desc">
                        <a href="<?php echo $view_url; ?>">
                            <?php echo cut_str(strip_tags($list[$i]['wr_content']), 200); ?>
                        </a>
                    </p>

                    <div class="webzine-meta-bottom">
                        <span class="webzine-author">By <?php echo $list[$i]['name']; ?></span>
                    </div>
                </div>
            </article>
        <?php } ?>

        <?php if (count($list) == 0) {
            echo '<p class="text-center" style="color:var(--color-text-secondary); padding:100px 0;">게시물이 없습니다.</p>';
        } ?>
    </div>

    <!-- Pagination -->
    <div style="margin-top:80px; text-align:center;">
        <?php
        if (isset($_GET['me_code'])) {
            $write_pages = preg_replace('/href="([^"]+)"/', 'href="$1&me_code=' . urlencode($_GET['me_code']) . '"', $write_pages);
        }
        echo $write_pages;
        ?>
    </div>
</div>

<?php if ($write_href) {
    $write_url = $write_href;
    if (isset($_GET['me_code']))
        $write_url .= '&me_code=' . urlencode($_GET['me_code']);
    $write_url .= '#bo_w';
    ?>
    <a href="<?php echo $write_url; ?>" class="btn-write-fab" title="Write Post">+</a>
<?php } ?>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script> AOS.init(); </script>