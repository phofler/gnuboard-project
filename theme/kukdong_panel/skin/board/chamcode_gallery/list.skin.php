<?php
if (!defined('_GNUBOARD_'))
    exit;
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);

// Admin Configuration
$cols = (int) $board['bo_gallery_cols'] > 0 ? (int) $board['bo_gallery_cols'] : 4;
$width = (int) $board['bo_gallery_width'] > 0 ? (int) $board['bo_gallery_width'] : 300;
$height = (int) $board['bo_gallery_height'] > 0 ? (int) $board['bo_gallery_height'] : 225;
$ratio = ($height / $width) * 100;
?>

<div class="chamcode-gallery-wrap sub-layout-width-height">

    <!-- Top: Total Count & Pagination Info -->
    <div id="bo_list_total">
        Total <?php echo number_format($total_count) ?>건 <?php echo $page ?> 페이지
    </div>

    <!-- Top: Write Button -->
    <?php if ($write_href) { ?>
        <div class="bo_fx" style="text-align:right; margin-bottom:15px;">
            <a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a>
        </div>
    <?php } ?>

    <!-- Gallery Grid -->
    <ul class="gallery-list-ul" style="grid-template-columns: repeat(<?php echo $cols; ?>, 1fr);">
        <?php
        for ($i = 0; $i < count($list); $i++) {
            $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $width, $height, false, true);
            $img_src = $thumb['src'] ? $thumb['src'] : '';
            ?>
            <li class="gallery-list-li">
                <a href="<?php echo $list[$i]['href'] ?>">
                    <div class="img-wrap" style="padding-bottom: <?php echo $ratio; ?>%;">
                        <?php if ($img_src) { ?>
                            <img src="<?php echo $img_src ?>" alt="<?php echo $thumb['alt'] ?>">
                        <?php } else { ?>
                            <span class="no_image"
                                style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); color:#999;">No
                                Image</span>
                        <?php } ?>
                    </div>
                </a>
                <div class="gallery-text">
                    <a href="<?php echo $list[$i]['href'] ?>">
                        <?php echo $list[$i]['subject'] ?>
                        <?php if ($list[$i]['comment_cnt'])
                            echo '<span class="cnt_cmt">(' . $list[$i]['comment_cnt'] . ')</span>'; ?>
                    </a>
                </div>
            </li>
        <?php } ?>

        <?php if (count($list) == 0) { ?>
            <li class="empty_list">
                게시물이 없습니다.</li>
        <?php } ?>
    </ul>

    <!-- Bottom: Pagination -->
    <div class="bo_page" style="margin-top:30px; text-align:center;">
        <?php echo $write_pages; ?>
    </div>

</div>