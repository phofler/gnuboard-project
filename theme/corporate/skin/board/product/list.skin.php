<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
?>

<!-- 게시판 목록 시작 { -->
<!-- Product Layout Wrapper -->
<style>
    .product-layout-container {
        display: flex;
        width: 100%;
        max-width: 1400px;
        /* Adjust based on theme max-width */
        margin: 0 auto;
        padding-top: 20px;
        gap: 50px;
        /* Separating Sidebar and Content */
        scroll-margin-top: 100px;
        /* Offset for scroll anchor */
    }

    .product-content-area {
        flex: 1;
        min-width: 0;
        /* Fix flex overflow issues */
    }
</style>

<div class="product-layout-container" id="page_start">
    <aside class="product-sidebar-area">
        <?php include_once(G5_THEME_PATH . '/skin/board/product/sidebar.product.php'); ?>
    </aside>

    <main class="product-content-area">
        <div id="bo_gall" style="width:100%;">

            <?php
            // [Custom Layout] Check for 'cate' parameter to show Featured Product
            // Logic updated to use the first item of the current list ($list[0]) if available
            $featured_shown = false;

            // Condition: 'cate' param exists AND list has items
            if (isset($_GET['cate']) && $_GET['cate']) {
                $row_prod = array();

                // [Logic] 1. Check if specific product is requested via 'highlight_wr_id'
                if (isset($_GET['highlight_wr_id']) && $_GET['highlight_wr_id']) {
                    $h_wr_id = preg_replace('/[^0-9]/', '', $_GET['highlight_wr_id']); // Sanitize
                    $row_prod = sql_fetch(" select * from {$write_table} where wr_id = '{$h_wr_id}' ");
                }

                // [Logic] 2. If no specific request (or fetch failed), fall back to First Item of the list
                if (!$row_prod && count($list) > 0) {
                    $row_prod = $list[0];
                }

                if ($row_prod) {
                    $featured_shown = true;
                    // Fetch files for the big image (get_file returns array of files)
                    $featured_files = get_file($board['bo_table'], $row_prod['wr_id']);

                    // Fetch full content for specs (wr_1) and full body (wr_content) just in case
                    $featured_view = get_write($write_table, $row_prod['wr_id']);

                    // Identify Category Name from the product itself
                    $cat_name = $row_prod['ca_name'];
                    ?>
                    <!-- Gallery Layout: Left Big Image + Right Thumbnails -->
                    <div class="featured-gallery-wrap">

                        <?php
                        // 1. Gather All Images (Attachments + Editor Images)
                        $gallery_imgs = array();

                        // A. Attachments
                        if (is_array($featured_files)) {
                            for ($k = 0; $k < count($featured_files); $k++) {
                                if (isset($featured_files[$k]['view']) && $featured_files[$k]['view']) {
                                    // Extract src from the view html
                                    preg_match('/src="([^"]+)"/', $featured_files[$k]['view'], $matches);
                                    if (isset($matches[1]))
                                        $gallery_imgs[] = $matches[1];
                                }
                            }
                        }

                        // B. Editor Content Images
                        $content_img_matches = get_editor_image($row_prod['wr_content'], false);
                        // get_editor_image returns array(0=>full tags, 1=>srcs) or false/null
                        if ($content_img_matches && is_array($content_img_matches) && isset($content_img_matches[1]) && is_array($content_img_matches[1])) {
                            foreach ($content_img_matches[1] as $c_img_src) {
                                if ($c_img_src)
                                    $gallery_imgs[] = $c_img_src;
                            }
                        }

                        // Ensure at least one image
                        if (empty($gallery_imgs)) {
                            $thumb = get_list_thumbnail($board['bo_table'], $row_prod['wr_id'], 800, 600, false, true);
                            if ($thumb['src'])
                                $gallery_imgs[] = $thumb['src'];
                        }

                        // Unique images only
                        $gallery_imgs = array_unique($gallery_imgs);
                        $gallery_imgs = array_values($gallery_imgs); // Re-index
                        ?>

                        <div class="featured-gallery-container">
                            <!-- Left: Main Image -->
                            <div class="fg-main-stage" style="position:relative;">
                                <?php if (isset($gallery_imgs[0])) { ?>
                                    <img id="fg_main_img" src="<?php echo $gallery_imgs[0]; ?>" alt="Main Image">
                                <?php } else { ?>
                                    <span class="no-img">No Image</span>
                                <?php } ?>

                                <?php
                                // [Admin/Author Only] Edit Button for Featured Product
                                $is_edit_authorized = false;
                                if ($is_admin == 'super' || $is_auth) {
                                    $is_edit_authorized = true;
                                } else if ($is_member && $row_prod['mb_id'] === $member['mb_id']) {
                                    $is_edit_authorized = true;
                                }

                                if ($is_edit_authorized) {
                                    $edit_url = G5_BBS_URL . '/write.php?w=u&bo_table=' . $bo_table . '&wr_id=' . $row_prod['wr_id'];
                                    if (isset($_GET['cate']) && $_GET['cate']) {
                                        $edit_url .= '&cate=' . urlencode($_GET['cate']);
                                    }
                                    ?>
                                    <div class="fg-edit-overlay">
                                        <a href="<?php echo $edit_url; ?>" class="btn_admin btn"><i class="fa fa-pencil"
                                                aria-hidden="true"></i> 수정하기</a>
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- Right: Thumbnails (Only if more than 1 image, or just show the one) -->
                            <div class="fg-thumbnails">
                                <?php
                                foreach ($gallery_imgs as $idx => $img_src) {
                                    $active_cls = ($idx == 0) ? 'active' : '';
                                    ?>
                                    <div class="fg-thumb-item <?php echo $active_cls; ?>"
                                        onclick="changeFeaturedImage(this, '<?php echo $img_src; ?>')">
                                        <img src="<?php echo $img_src; ?>" alt="thumb">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- [2] Product Title Bar (Below Gallery) -->
                        <div class="product-title-bar">
                            <h3><?php echo $row_prod['wr_subject']; ?></h3>
                        </div>

                        <!-- [3] Product Specs & Content -->
                        <div class="product-spec-table">
                            <?php echo nl2br($featured_view['wr_1']); ?>
                        </div>

                        <div id="bo_v_con" style="margin-bottom:30px; display:none;">
                            <!-- Hide original content since images are in gallery -->
                            <?php // Content hidden, images extracted ?>
                        </div>

                        <!-- Title for Grid Below -->
                        <div class="related-products-gallery" style="margin-top:0; border-top:none;">
                            <h3>RELATED PRODUCTS</h3>
                        </div>

                    </div>

                    <script>
                        function changeFeaturedImage(el, src) {
                            // Update Main Image
                            document.getElementById('fg_main_img').src = src;

                            // Update Active Class
                            var thumbs = document.querySelectorAll('.fg-thumb-item');
                            thumbs.forEach(function (t) { t.classList.remove('active'); });
                            el.classList.add('active');
                        }
                    </script>

                    <style>
                        /* Featured Gallery Container */
                        .featured-gallery-wrap {
                            margin-bottom: 60px;
                        }

                        .featured-gallery-container {
                            display: flex;
                            gap: 20px;
                            margin-bottom: 30px;
                            height: 500px;
                            /* Fixed height for consistency */
                        }

                        /* Left Stage */
                        .fg-main-stage {
                            flex: 0 0 80%;
                            height: 100%;
                            background: #222;
                            /* Dark bg */
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            border: 1px solid #444;
                            /* Dark border */
                            overflow: hidden;
                        }

                        .fg-main-stage img {
                            max-width: 100%;
                            max-height: 100%;
                            object-fit: contain;
                        }

                        /* Right Thumbnails */
                        .fg-edit-overlay {
                            position: absolute;
                            bottom: 20px;
                            right: 20px;
                            z-index: 10;
                        }

                        .fg-edit-overlay .btn_admin {
                            background-color: var(--color-accent-gold) !important;
                            color: #000 !important;
                            border: none !important;
                            font-weight: 700 !important;
                        }

                        .fg-thumbnails {
                            flex: 1;
                            height: 100%;
                            overflow-y: auto;
                            display: flex;
                            flex-direction: column;
                            gap: 15px;
                            padding-right: 5px;
                        }

                        .fg-thumb-item {
                            width: 100%;
                            height: 120px;
                            border: 2px solid var(--color-metal-dark);
                            /* Theme Dark Border */
                            cursor: pointer;
                            opacity: 0.6;
                            transition: all 0.3s;
                            flex-shrink: 0;
                            background: var(--color-bg-dark);
                            /* Theme Dark BG */
                        }

                        .fg-thumb-item img {
                            width: 100%;
                            height: 100%;
                            object-fit: cover;
                        }

                        .fg-thumb-item:hover,
                        .fg-thumb-item.active {
                            border-color: var(--color-accent-gold);
                            /* Theme Gold */
                            opacity: 1;
                        }

                        /* Title & Specs */
                        .product-title-bar {
                            background-color: var(--color-bg-panel);
                            /* Theme Panel BG */
                            border-left: 5px solid var(--color-accent-gold);
                            color: var(--color-text-primary);
                            padding: 20px;
                            margin-bottom: 20px;
                            border-radius: 0;
                        }

                        .product-title-bar h3 {
                            margin: 0;
                            font-size: 1.5rem;
                            font-weight: 700;
                            letter-spacing: 1px;
                            color: var(--color-accent-gold) !important;
                            text-transform: uppercase;
                        }

                        .product-spec-table {
                            background: var(--color-bg-panel);
                            padding: 20px;
                            border: 1px solid var(--color-metal-dark);
                            margin-bottom: 30px;
                            font-size: 0.95rem;
                            line-height: 1.6;
                            color: var(--color-text-primary);
                        }

                        .related-products-gallery h3 {
                            font-size: 1.2rem;
                            font-weight: 700;
                            margin-bottom: 20px;
                            text-transform: uppercase;
                            border-bottom: 2px solid var(--color-accent-gold);
                            padding-bottom: 15px;
                            color: var(--color-accent-gold);
                        }

                        /* Gold Text */

                        /* Takes 80% */
                        @media (max-width: 768px) {
                            .featured-gallery-container {
                                flex-direction: column;
                                height: auto;
                            }

                            .fg-main-stage {
                                width: 100%;
                                height: 300px;
                            }

                            .fg-thumbnails {
                                flex-direction: row;
                                height: auto;
                                overflow-x: auto;
                                overflow-y: hidden;
                            }

                            .fg-thumb-item {
                                width: 80px;
                                height: 80px;
                            }
                        }
                    </style>
                    <?php
                }
            }

            if (!$featured_shown) {
                ?>
                <!-- Theme Standardization: Product Header (Default) -->
                <div class="section-header" data-aos="fade-right">
                    <p style="color:var(--color-accent-gold); font-weight:bold; letter-spacing:1px; margin-bottom:10px;">
                        Product
                        Info</p>
                    <h2 style="font-size:3rem; margin-bottom:0; text-transform:uppercase;">
                        <?php echo $board['bo_subject'] ?>
                    </h2>
                    <p style="color:var(--color-text-secondary); margin-top:20px; font-weight:normal;">최고의 기술력으로 완성된 제품을
                        소개합니다.</p>
                </div>
            <?php } ?>


            <?php if ($is_category) { ?>
                <nav id="bo_cate">
                    <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
                    <ul id="bo_cate_ul">
                        <?php echo $category_option ?>
                    </ul>
                </nav>
            <?php } ?>

            <form name="fboardlist" id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php"
                onsubmit="return fboardlist_submit(this);" method="post">
                <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                <input type="hidden" name="stx" value="<?php echo $stx ?>">
                <input type="hidden" name="spt" value="<?php echo $spt ?>">
                <input type="hidden" name="sst" value="<?php echo $sst ?>">
                <input type="hidden" name="sod" value="<?php echo $sod ?>">
                <input type="hidden" name="page" value="<?php echo $page ?>">
                <input type="hidden" name="sw" value="">

                <!-- 게시판 페이지 정보 및 버튼 시작 { -->
                <div id="bo_btn_top">
                    <div id="bo_list_total">
                        <span>Total <?php echo number_format($total_count) ?>건</span>
                        <?php echo $page ?> 페이지
                    </div>

                    <ul class="btn_bo_user">
                        <?php if ($admin_href) { ?>
                            <li><a href="<?php echo $admin_href ?>" class="btn_admin btn" title="관리자"><i
                                        class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li>
                        <?php } ?>
                        <?php if ($rss_href) { ?>
                            <li><a href="<?php echo $rss_href ?>" class="btn_b01 btn" title="RSS"><i class="fa fa-rss"
                                        aria-hidden="true"></i><span class="sound_only">RSS</span></a></li><?php } ?>
                        <li>
                            <button type="button" class="btn_bo_sch btn_b01 btn" title="게시판 검색"><i class="fa fa-search"
                                    aria-hidden="true"></i><span class="sound_only">게시판 검색</span></button>
                        </li>
                        <?php if ($write_href) { ?>
                            <li><a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil"
                                        aria-hidden="true"></i><span class="sound_only">글쓰기</span></a></li><?php } ?>
                        <?php if ($is_admin == 'super' || $is_auth) { ?>
                            <li>
                                <button type="button" class="btn_more_opt is_list_btn btn_b01 btn" title="게시판 리스트 옵션"><i
                                        class="fa fa-ellipsis-v" aria-hidden="true"></i><span class="sound_only">게시판 리스트
                                        옵션</span></button>
                                <?php if ($is_checkbox) { ?>
                                    <ul class="more_opt is_list_btn">
                                        <li><button type="submit" name="btn_submit" value="선택삭제"
                                                onclick="document.pressed=this.value"><i class="fa fa-trash-o"
                                                    aria-hidden="true"></i>
                                                선택삭제</button></li>
                                        <li><button type="submit" name="btn_submit" value="선택복사"
                                                onclick="document.pressed=this.value"><i class="fa fa-files-o"
                                                    aria-hidden="true"></i>
                                                선택복사</button></li>
                                        <li><button type="submit" name="btn_submit" value="선택이동"
                                                onclick="document.pressed=this.value"><i class="fa fa-arrows"
                                                    aria-hidden="true"></i>
                                                선택이동</button></li>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <!-- } 게시판 페이지 정보 및 버튼 끝 -->

                <?php if ($is_checkbox) { ?>
                    <div id="gall_allchk" class="all_chk chk_box">
                        <input type="checkbox" id="chkall"
                            onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk">
                        <label for="chkall">
                            <span></span>
                            <b class="sound_only">현재 페이지 게시물 </b> 전체선택
                        </label>
                    </div>
                <?php } ?>

                <ul id="gall_ul" class="gall_row gallery-grid-view">
                    <?php for ($i = 0; $i < count($list); $i++) {
                        $classes = array();
                        if ($wr_id && $wr_id == $list[$i]['wr_id']) {
                            $classes[] = 'gall_now';
                        }

                        // Link to Self with highlight_wr_id param
                        // Keeps user on list page but updates the featured section
                        $highlight_href = G5_BBS_URL . '/board.php?bo_table=' . $bo_table;
                        if (isset($sca))
                            $highlight_href .= '&sca=' . urlencode($sca);
                        if (isset($_GET['cate']))
                            $highlight_href .= '&cate=' . urlencode($_GET['cate']);
                        $highlight_href .= '&highlight_wr_id=' . $list[$i]['wr_id'];
                        $highlight_href .= '#page_start';
                        ?>
                        <li class="gallery-item-view <?php echo implode(' ', $classes); ?>">
                            <a href="<?php echo $highlight_href; ?>">
                                <div class="thumb">
                                    <?php
                                    $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], 400, 300, false, true);
                                    if ($thumb['src']) {
                                        echo '<img src="' . $thumb['src'] . '" alt="' . $thumb['alt'] . '">';
                                    } else {
                                        echo '<span class="no_image">no image</span>';
                                    }
                                    ?>
                                </div>
                                <div class="gallery-info">
                                    <p class="title"><?php echo $list[$i]['subject'] ?></p>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (count($list) == 0) {
                        echo "<li class=\"empty_list\">게시물이 없습니다.</li>";
                    } ?>
                </ul>

                <style>
                    /* Gallery Grid Styling to match View Skin */
                    .gallery-grid-view {
                        display: grid;
                        grid-template-columns: repeat(4, 1fr);
                        gap: 20px;
                        list-style: none;
                        padding: 0;
                        margin: 0;
                    }

                    .gallery-item-view {
                        text-align: center;
                    }

                    .gallery-item-view .thumb {
                        width: 100%;
                        height: 180px;
                        overflow: hidden;
                        border: 1px solid var(--color-metal-dark);
                        margin-bottom: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        background: var(--color-bg-dark);
                    }

                    .gallery-item-view .thumb img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        transition: transform 0.3s;
                    }

                    .gallery-item-view:hover .thumb img {
                        transform: scale(1.05);
                    }

                    .gallery-item-view:hover .thumb {
                        border-color: var(--color-accent-gold);
                    }

                    .gallery-item-view .gallery-info .title {
                        font-size: 0.9rem;
                        color: var(--color-text-secondary);
                        font-weight: 500;
                        margin: 0;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    }

                    @media (max-width: 768px) {
                        .gallery-grid-view {
                            grid-template-columns: repeat(2, 1fr);
                        }
                    }
                </style>

                <!-- 페이지 -->
                <?php echo $write_pages; ?>
                <!-- 페이지 -->

                <?php if ($list_href || $is_checkbox || $write_href) { ?>
                    <div class="bo_fx">
                        <?php if ($list_href || $write_href) { ?>
                            <ul class="btn_bo_user">
                                <?php if ($admin_href) { ?>
                                    <li><a href="<?php echo $admin_href ?>" class="btn_admin btn" title="관리자"><i
                                                class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li>
                                <?php } ?>
                                <?php if ($rss_href) { ?>
                                    <li><a href="<?php echo $rss_href ?>" class="btn_b01 btn" title="RSS"><i class="fa fa-rss"
                                                aria-hidden="true"></i><span class="sound_only">RSS</span></a></li><?php } ?>
                                <?php if ($write_href) { ?>
                                    <li><a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil"
                                                aria-hidden="true"></i><span class="sound_only">글쓰기</span></a></li><?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                <?php } ?>
            </form>

            <!-- 게시판 검색 시작 { -->
            <div class="bo_sch_wrap">
                <fieldset class="bo_sch">
                    <h3>검색</h3>
                    <form name="fsearch" method="get">
                        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                        <input type="hidden" name="sca" value="<?php echo $sca ?>">
                        <input type="hidden" name="sop" value="and">
                        <label for="sfl" class="sound_only">검색대상</label>
                        <select name="sfl" id="sfl">
                            <?php echo get_board_sfl_select_options($sfl); ?>
                        </select>
                        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                        <div class="sch_bar">
                            <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx"
                                class="sch_input" size="25" maxlength="20" placeholder="검색어를 입력해주세요">
                            <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search"
                                    aria-hidden="true"></i><span class="sound_only">검색</span></button>
                        </div>
                        <button type="button" class="bo_sch_cls"><i class="fa fa-times" aria-hidden="true"></i><span
                                class="sound_only">닫기</span></button>
                    </form>
                </fieldset>
                <div class="bo_sch_bg"></div>
            </div>
            <script>
                // 게시판 검색
                $(".btn_bo_sch").on("click", function () {
                    $(".bo_sch_wrap").toggle();
                })
                $('.bo_sch_bg, .bo_sch_cls').click(function () {
                    $('.bo_sch_wrap').hide();
                });
            </script>
            <!-- } 게시판 검색 끝 -->
        </div>

        <?php if ($is_checkbox) { ?>
            <noscript>
                <p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
            </noscript>
        <?php } ?>

        <?php if ($is_checkbox) { ?>
            <script>
                function all_checked(sw) {
                    var f = document.fboardlist;

                    for (var i = 0; i < f.length; i++) {
                        if (f.elements[i].name == "chk_wr_id[]")
                            f.elements[i].checked = sw;
                    }
                }

                function fboardlist_submit(f) {
                    var chk_count = 0;

                    for (var i = 0; i < f.length; i++) {
                        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
                            chk_count++;
                    }

                    if (!chk_count) {
                        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
                        return false;
                    }

                    if (document.pressed == "선택복사") {
                        select_copy("copy");
                        return;
                    }

                    if (document.pressed == "선택이동") {
                        select_copy("move");
                        return;
                    }

                    if (document.pressed == "선택삭제") {
                        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
                            return false;

                        f.removeAttribute("target");
                        f.action = g5_bbs_url + "/board_list_update.php";
                    }

                    return true;
                }

                // 선택한 게시물 복사 및 이동
                function select_copy(sw) {
                    var f = document.fboardlist;

                    if (sw == 'copy')
                        str = "복사";
                    else
                        str = "이동";

                    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

                    f.sw.value = sw;
                    f.target = "move";
                    f.action = g5_bbs_url + "/move.php";
                    f.submit();
                }

                // 게시판 리스트 관리자 옵션
                jQuery(function ($) {
                    $(".btn_more_opt.is_list_btn").on("click", function (e) {
                        e.stopPropagation();
                        $(".more_opt.is_list_btn").toggle();
                    });
                    $(document).on("click", function (e) {
                        if (!$(e.target).closest('.is_list_btn').length) {
                            $(".more_opt.is_list_btn").hide();
                        }
                    });
                });
            </script>
        <?php } ?>
        <!-- } 게시판 목록 끝 -->
    </main>
</div>
<!-- Product Layout Wrapper End -->