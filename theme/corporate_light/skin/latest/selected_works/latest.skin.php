<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// [Visual Authority] CSS from index_ko.html (Selected Works Section)
// In a real production environment, this should be moved to style.css
?>


<section class="sec-works">
    <div class="container sec-works-header">
        <h2 class="t-h2"
            style="color:#fff; margin:0; font-size: clamp(24px, 3vw, 48px); font-family: var(--f-display, serif);">
            <?php echo $bo_subject ? $bo_subject : "Selected Works"; ?>
        </h2>
        <div style="font-size:14px; opacity:0.6;">
            <a href="<?php echo $options['ls_more_link'] ? $options['ls_more_link'] : get_pretty_url($bo_table); ?>"
                style="color:inherit;">
                VIEW DETAIL &rarr;
            </a>
        </div>
    </div>

    <div class="marquee-track">
        <?php
        $list_count = count($list);
        if ($list_count > 0) {
            // Duplicate loop for seamless marquee if items are few
            $loop_count = ($list_count < 6) ? 2 : 1;

            for ($k = 0; $k < $loop_count; $k++) {
                for ($i = 0; $i < $list_count; $i++) {
                    // Thumbnail Logic
                    $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 800, 1000, false, true); // Tall Aspect Ratio
                    $img_src = $thumb['src'] ? $thumb['src'] : G5_THEME_URL . '/img/no_img.png';

                    // Link
                    $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
                    ?>
                    <div class="work-card">
                        <a href="<?php echo $wr_href; ?>">
                            <img src="<?php echo $img_src; ?>" alt="<?php echo strip_tags($list[$i]['subject']); ?>">
                        </a>
                        <div class="work-meta">
                            <h3>
                                <a href="<?php echo $wr_href; ?>" style="color:inherit;">
                                    <?php echo $list[$i]['subject']; ?>
                                </a>
                            </h3>
                            <p><?php echo cut_str(strip_tags($list[$i]['wr_content']), 30); ?></p>
                        </div>
                    </div>
                    <?php
                } // end for list
            } // end for loop_count
        } else {
            ?>
            <!-- Empty State (Placeholder) -->
            <div class="work-card">
                <div
                    style="width:100%; height:40vw; background:#333; display:flex; align-items:center; justify-content:center; color:#666;">
                    NO DATA
                </div>
            </div>
        <?php } ?>
    </div>
</section>