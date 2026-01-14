<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
?>

<!-- 게시판 목록 시작 { -->
<div id="bo_gall" class="skin-container" style="width:<?php echo $width; ?>">
    <!-- [Category Filter: Hover Dropdown Tabs] -->
    <?php if ($is_category) {
        $add_query = '';
        if (isset($_GET['me_code'])) {
            $add_query = '&me_code=' . urlencode($_GET['me_code']);
        }
        $category_href = G5_BBS_URL . '/board.php?bo_table=' . $bo_table . $add_query;
        $raw_cats = explode('|', $board['bo_category_list']);
        $structure = array();

        // 1. Build Hierarchy
        foreach ($raw_cats as $cat) {
            $cat = trim($cat); // Each entry trim (Policy 30-B)
            $cat = preg_replace('/\s*>\s*/', ' > ', $cat); // Normalize spacing ' > '
            if (!$cat)
                continue;

            $parts = explode(' > ', $cat);
            $root = trim($parts[0]);

            if (!isset($structure[$root])) {
                $structure[$root] = array(
                    'path' => $root,
                    'children' => array()
                );
            }

            if (count($parts) == 2) {
                // Depth 2: Root > Sub
                $sub = trim($parts[1]);
                $structure[$root]['children'][$cat] = $sub;
            }
        }

        // Determine Active Root for styling
        $current_root = '';
        $current_stx = isset($_GET['stx']) ? $_GET['stx'] : '';
        if ($sca) {
            $sca_temp = explode('>', $sca);
            $current_root = trim($sca_temp[0]);
        } else if ($current_stx) {
            $stx_temp = explode('>', $current_stx);
            $current_root = trim($stx_temp[0]);
        }
        ?>
        <div id="bo_cate" class="category-ui-wrap">
            <ul class="cate-tabs">
                <!-- 'All' Tab -->
                <li class="cate-item">
                    <a href="<?php echo $category_href ?>#bo_cate"
                        class="cate-link <?php echo ($sca == '' && $current_stx == '') ? 'active' : ''; ?>">All</a>
                </li>

                <!-- Root Tabs -->
                <?php foreach ($structure as $root_name => $data) {
                    $is_active_root = ($current_root == $root_name);
                    $has_children = !empty($data['children']);
                    ?>
                    <li class="cate-item <?php echo $has_children ? 'has-sub' : ''; ?>">
                        <!-- Root (Search Policy 10-3) -->
                        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $bo_table . $add_query; ?>&amp;sfl=ca_name&amp;stx=<?php echo urlencode($root_name); ?>#bo_cate"
                            class="cate-link <?php echo ($current_root == $root_name || $current_stx == $root_name) ? 'active' : ''; ?>">
                            <?php echo $root_name; ?>
                        </a>

                        <?php if ($has_children) { ?>
                            <div class="cate-dropdown">
                                <?php foreach ($data['children'] as $full_path => $sub_name) {
                                    $is_active_sub = ($sca == $full_path || $current_stx == $full_path);
                                    ?>
                                    <!-- Sub (Search Mode for robustness) -->
                                    <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $bo_table . $add_query; ?>&amp;sfl=ca_name&amp;stx=<?php echo urlencode($full_path); ?>#bo_cate"
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

        <style>
            .category-ui-wrap {
                margin-bottom: 40px;
                border-bottom: 1px solid #e5e5e5;
                text-align: center;
                /* Center align tabs */
                scroll-margin-top: 130px;
                /* Offset for Fixed Header */
            }

            .cate-tabs {
                display: inline-flex;
                flex-wrap: wrap;
                gap: 30px;
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .cate-item {
                position: relative;
                padding-bottom: 15px;
            }

            /* Main Tab Link */
            .cate-link {
                font-size: 16px;
                font-weight: 500;
                color: #888;
                text-decoration: none;
                transition: color 0.2s;
                position: relative;
                /* Hover target area extension */
                padding: 10px 0;
            }

            .cate-link:hover,
            .cate-link.active {
                color: #000;
                font-weight: 700;
            }

            /* Active Underline */
            .cate-link.active::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 2px;
                background-color: #000;
            }

            /* Dropdown Menu */
            .cate-dropdown {
                display: none;
                /* Hidden by default */
                position: absolute;
                top: 100%;
                /* Show below parent */
                left: 50%;
                transform: translateX(-50%);
                min-width: 160px;
                background: #fff;
                border: 1px solid #eee;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                border-radius: 4px;
                padding: 10px 0;
                z-index: 100;
                text-align: left;
            }

            /* Show on Hover (Parent Item Hover) */
            .cate-item:hover .cate-dropdown {
                display: block;
                animation: fadeInUpdate 0.2s ease-out;
            }

            /* Dropdown Items */
            .sub-link {
                display: block;
                padding: 8px 20px;
                font-size: 14px;
                color: #666;
                text-decoration: none;
                transition: background 0.2s;
            }

            .sub-link:hover {
                background-color: #f5f5f5;
                color: #000;
            }

            .sub-link.active {
                color: #d94e28;
                /* Accent Color */
                font-weight: 600;
            }

            @keyframes fadeInUpdate {
                from {
                    opacity: 0;
                    transform: translate(-50%, -10px);
                }

                to {
                    opacity: 1;
                    transform: translate(-50%, 0);
                }
            }

            /* Pagination Margin Fix */
            .pg_wrap {
                margin-bottom: 60px;
                text-align: center;
            }

            #bo_fx {
                margin-bottom: 20px;
            }

            /* [MODAL ENHANCEMENT] Fullscreen & Thumbnails */
            .lightbox-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.95);
                /* Deeper dark background */
                z-index: 9999;
                /* Highest priority */
                display: none;
                justify-content: center;
                align-items: center;
                opacity: 0;
                transition: opacity 0.3s ease;
                backdrop-filter: blur(5px);
                /* Modern blur effect */
            }

            .lightbox-overlay.active {
                display: flex;
                opacity: 1;
            }

            .lightbox-content {
                position: relative;
                width: 100%;
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            /* Close Button */
            .lightbox-close {
                position: absolute;
                top: 20px;
                right: 30px;
                font-size: 40px;
                color: #fff;
                cursor: pointer;
                z-index: 10001;
                transition: transform 0.2s;
            }

            .lightbox-close:hover {
                transform: scale(1.1) rotate(90deg);
            }

            /* Main Image Area */
            .l-img-area {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
                overflow: hidden;
                padding: 0;
                /* Remove padding to full fill */
            }

            #l-img {
                max-width: 100%;
                max-height: 100vh;
                object-fit: contain;
                /* No shadow/border for clean look */
                transition: opacity 0.3s;
            }

            /* Thumbnail Strip - Center Bottom, Overlay */
            .l-thumb-wrap {
                position: absolute;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                display: flex;
                gap: 10px;
                padding: 10px;
                background: rgba(0, 0, 0, 0.5);
                /* Darker translucent bg */
                border-radius: 10px;
                overflow-x: auto;
                max-width: 80%;
                z-index: 10002;
                /* Higher than text */
            }

            .l-thumb-wrap::-webkit-scrollbar {
                display: none;
                /* Chrome/Safari */
            }

            .l-thumb {
                width: 60px;
                height: 60px;
                object-fit: cover;
                border-radius: 8px;
                cursor: pointer;
                opacity: 0.5;
                transition: all 0.2s;
                border: 2px solid transparent;
            }

            .l-thumb:hover {
                opacity: 0.8;
                transform: translateY(-2px);
            }

            .l-thumb.active {
                opacity: 1;
                border-color: #d94e28;
                /* Point Color */
                box-shadow: 0 0 10px rgba(217, 78, 40, 0.5);
            }

            /* Text Area - Bottom Left Overlay with Gradient */
            .l-text-area {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                padding: 15vh 40px 140px 40px;
                /* Gradient height */
                background: linear-gradient(to top, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0) 100%);
                color: #fff;
                pointer-events: none;
                /* Let clicks pass */
                z-index: 10001;
            }

            .l-cate {
                color: #d94e28;
                font-weight: bold;
                font-size: 13px;
                margin-bottom: 5px;
                text-transform: uppercase;
            }

            .l-title {
                font-size: 28px;
                font-weight: 700;
                margin: 0;
                line-height: 1.2;
            }

            .l-desc {
                display: none;
            }
        </style>
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
                                class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li><?php } ?>
                <?php if ($rss_href) { ?>
                    <li><a href="<?php echo $rss_href ?>" class="btn_b01 btn" title="RSS"><i class="fa fa-rss"
                                aria-hidden="true"></i><span class="sound_only">RSS</span></a></li><?php } ?>
                <?php if ($write_href) {
                    // [Add me_code to write button (TOP)]
                    if (isset($_GET['me_code'])) {
                        $write_href .= '&me_code=' . urlencode($_GET['me_code']);
                    }
                    ?>
                    <li><a href="<?php echo $write_href ?>#bo_w" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil"
                                aria-hidden="true"></i><span class="sound_only">글쓰기</span></a></li><?php } ?>
            </ul>
        </div>
        <!-- } 게시판 페이지 정보 및 버튼 끝 -->

        <?php if ($is_checkbox) { ?>
            <div id="gall_allchk" class="all_chk chk_box">
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"
                    class="selec_chk">
                <label for="chkall">
                    <span></span>
                    <b class="sound_only">현재 페이지 게시물 </b> 전체선택
                </label>
            </div>
        <?php } ?>

        <!-- [GALLERY EDITORIAL GRID] -->
        <div class="gallery-editorial-grid">
            <?php
            for ($i = 0; $i < count($list); $i++) {

                $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);

                if ($thumb['src']) {
                    $img_content = $thumb['src'];
                } else {
                    $img_content = G5_IMG_URL . '/no_img.png'; // Fallback
                }

                // Extract Description (Content)
                $description = strip_tags($list[$i]['wr_content']);
                // If manual summary exists, use it? Or just raw content cut.
                //$description = utf8_strcut($description, 200, '..');
            
                // [GALLERY ENHANCEMENT] Extract All Images (Attached + Editor)
                $img_files = array();

                // 1. Attached Files
                $files = get_file($board['bo_table'], $list[$i]['wr_id']);
                if ($files) {
                    foreach ($files as $file) {
                        $is_image = false;
                        $ext_regex = "/\.(jpg|jpeg|png|gif|webp|bmp)$/i";

                        // Check 'file' (disk name) AND 'source' (original name)
                        if (
                            (isset($file['file']) && preg_match($ext_regex, $file['file'])) ||
                            (isset($file['source']) && preg_match($ext_regex, $file['source']))
                        ) {
                            $is_image = true;
                        }

                        if ($is_image && isset($file['path']) && isset($file['file'])) {
                            $img_files[] = $file['path'] . '/' . $file['file'];
                        }
                    }
                }

                // 2. Editor Images (Regex extract from wr_content)
                // Use non-greedy match for src
                if (preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $list[$i]['wr_content'], $matches)) {
                    foreach ($matches[1] as $editor_img_url) {
                        // Filter out emoticons or obviously non-content images if needed
                        // For now, accept all content images.
                        // Convert relative URL to absolute if needed, but get_editor_image returns full paths usually if configured right.
                        // Assuming the src is usable as is.
                        $img_files[] = $editor_img_url;
                    }
                }

                // 3. Fallback (Thumbnail) - Only if NOTHING found
                if (empty($img_files) && $thumb['src']) {
                    $img_files[] = $thumb['src'];
                }

                // 4. De-duplicate (Editor might have included attached image if user inserted it)
                $img_files = array_unique($img_files);
                $img_files = array_values($img_files); // Re-index
            
                // Convert to JSON for data attribute
                $data_images_json = htmlspecialchars(json_encode($img_files, JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8');
                ?>

                <!-- ITEM -->
                <article class="gallery-card" onclick="openLightbox(this)" data-images="<?php echo $data_images_json; ?>"
                    data-debug-count="<?php echo count($img_files); ?>">

                    <?php if ($is_checkbox) { ?>
                        <div class="chk_box" onclick="event.stopPropagation();">
                            <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>"
                                id="chk_wr_id_<?php echo $i ?>" class="selec_chk">
                            <label for="chk_wr_id_<?php echo $i ?>"><span></span><b
                                    class="sound_only"><?php echo $list[$i]['subject'] ?></b></label>
                        </div>
                    <?php } ?>

                    <div class="gallery-img-box">
                        <img src="<?php echo $img_content; ?>" alt="<?php echo $thumb['alt']; ?>">
                    </div>
                    <div class="gallery-meta">
                        <span class="gallery-cate">
                            <?php echo $list[$i]['ca_name'] ? $list[$i]['ca_name'] : 'PROJECT'; ?>
                        </span>
                        <h3 class="gallery-title">
                            <?php
                            // [Admin Edit Link]
                            if ($is_admin == 'super' || $is_auth) {
                                $edit_href = G5_BBS_URL . '/write.php?w=u&bo_table=' . $bo_table . '&wr_id=' . $list[$i]['wr_id'];
                                if (isset($_GET['me_code']))
                                    $edit_href .= '&me_code=' . urlencode($_GET['me_code']);
                                $edit_href .= '&page=' . $page;
                                $edit_href .= '#bo_w'; // [Admin Anchor]
                                echo '<a href="' . $edit_href . '" onclick="event.stopPropagation();" class="btn_mini_edit" title="수정"><i class="fa fa-pencil"></i></a> ';
                            }
                            ?>
                            <?php echo $list[$i]['subject'] ?>
                            <?php if ($list[$i]['icon_secret'])
                                echo "<img src='" . $board_skin_url . "/img/icon_secret.gif' alt='secret'>"; ?>
                        </h3>
                        <div class="gallery-desc">
                            <?php echo $description; ?>
                        </div>
                    </div>

                    <!-- Hidden Link for SEO/Fallback -->
                    <a href="<?php echo $list[$i]['href'] ?>" style="display:none;">View Detail</a>
                </article>

            <?php } ?>

            <?php if (count($list) == 0) {
                echo "<div class=\"empty_list\">게시물이 없습니다.</div>";
            } ?>
        </div>
        <!-- [END GRID] -->

        <style>
            /* Mini Edit Button Style */
            .btn_mini_edit {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 24px;
                height: 24px;
                background: #f1f3f5;
                color: #495057;
                border-radius: 4px;
                font-size: 13px;
                margin-right: 6px;
                vertical-align: middle;
                transition: all 0.2s;
                opacity: 0.5;
                /* Subtle by default */
            }

            .btn_mini_edit:hover {
                background: #d94e28;
                color: #fff;
                opacity: 1;
            }
        </style>

        <!-- 페이지 -->
        <?php
        // [Inject me_code and Anchor into pagination for UX]
        $me_code_str = isset($_GET['me_code']) ? "&me_code=" . urlencode($_GET['me_code']) : "";

        // 1. Add me_code if missing
        if ($me_code_str && strpos($write_pages, 'me_code=') === false) {
            $write_pages = preg_replace('/(href="[^"]+board\.php\?[^"]+)(")/i', '$1' . $me_code_str . '$2', $write_pages);
        }

        // 2. Unconditionally add #bo_cate anchor
        $write_pages = preg_replace('/(href="[^"]+board\.php[^"]*)(")/i', '$1#bo_cate$2', $write_pages);

        echo $write_pages;
        ?>
        <!-- 페이지 -->

        <?php if ($is_checkbox) { ?>
            <!-- Admin Checkbox Logic might need buttons here, but currently unused in this skin -->
        <?php } ?>
    </form>

    <!-- 게시판 검색, 기타 옵션 생략 가능하지만 유지 -->
</div>

<!-- [LIGHTBOX UI] -->
<div id="lightbox" class="lightbox-overlay">
    <div class="lightbox-content">
        <div class="lightbox-close" onclick="closeLightbox()">&times;</div>

        <!-- Left: Image Area (Flex 1) -->
        <div class="l-img-area">
            <img id="l-img" src="" alt="">
            <!-- Thumbnails: Absolute Bottom Center of Image Area -->
            <div id="l-thumb-wrap" class="l-thumb-wrap"></div>
        </div>

        <!-- Right: Text Info Area (Fixed Width) -->
        <div class="l-text-area">
            <div id="l-cate" class="l-cate">CATEGORY</div>
            <h3 id="l-title" class="l-title">Project Title</h3>
            <div class="l-divider"></div>
            <div id="l-desc" class="l-desc">Description goes here...</div>
        </div>
    </div>
</div>

<style>
    /* [MODAL V3] Split Layout (Image Left - Text Right) */
    .lightbox-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #000;
        z-index: 9999;
        display: none;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .lightbox-overlay.active {
        display: flex;
        opacity: 1;
    }

    .lightbox-content {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: row;
        /* Split Row */
        overflow: hidden;
    }

    /* --- Left: Image Area --- */
    .l-img-area {
        flex: 1;
        /* Take remaining space */
        height: 100%;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #000;
        padding-bottom: 80px;
        /* Space for thumbs */
    }

    #l-img {
        max-width: 90%;
        max-height: 80%;
        /* Fit within area */
        object-fit: contain;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
    }

    /* Thumbnails (Bottom Center of Image Area) */
    .l-thumb-wrap {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        padding: 8px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        backdrop-filter: blur(5px);
        z-index: 10;
    }

    .l-thumb {
        width: 60px !important;
        height: 60px !important;
        object-fit: cover;
        border-radius: 4px;
        opacity: 0.5;
        transition: 0.2s;
        cursor: pointer;
        border: 2px solid transparent;
        max-width: none !important;
        /* Prevent responsiveness from shrinking or expanding unexpectedly */
    }

    .l-thumb:hover,
    .l-thumb.active {
        opacity: 1;
        border-color: #d94e28;
        transform: scale(1.1);
    }

    /* --- Right: Text Area --- */
    .l-text-area {
        width: 400px;
        /* Fixed Width Sidebar */
        height: 100%;
        position: relative !important;
        /* Force Reset from Absolute */
        bottom: auto !important;
        left: auto !important;
        background: #111 !important;
        /* Force Dark Grey */
        border-left: 1px solid #222;
        padding: 60px 40px !important;
        /* Reset Padding */
        display: flex;
        flex-direction: column;
        justify-content: center;
        /* Center Vertically */
        color: #fff;
        z-index: 20;
        overflow-y: auto;
        pointer-events: auto !important;
        /* Re-enable clicks */
    }

    .l-cate {
        color: #d94e28;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .l-title {
        font-size: 32px;
        font-weight: 700;
        line-height: 1.3;
        margin: 0 0 20px 0;
        color: #fff;
    }

    .l-divider {
        width: 40px;
        height: 2px;
        background: #333;
        margin-bottom: 20px;
    }

    .l-desc {
        font-size: 15px;
        line-height: 1.7;
        color: #aaa;
        word-break: keep-all;
        display: block !important;
        /* Force reveal from legacy hidden state */
    }

    /* Close Button */
    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        font-size: 40px;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 100;
        cursor: pointer;
        transition: 0.2s;
    }

    .lightbox-close:hover {
        transform: rotate(90deg);
        color: #d94e28;
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
        .lightbox-content {
            flex-direction: column;
        }

        .l-img-area {
            flex: none;
            height: 60%;
            padding-bottom: 0;
        }

        #l-img {
            max-height: 90%;
        }

        .l-thumb-wrap {
            bottom: 10px;
            max-width: 90%;
            overflow-x: auto;
        }

        .l-text-area {
            width: 100%;
            height: 40%;
            /* Stack bottom */
            padding: 30px;
            border-left: none;
            border-top: 1px solid #222;
            justify-content: flex-start;
        }

        .l-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .l-desc {
            font-size: 14px;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            display: -webkit-box;
            overflow: hidden;
        }

        .lightbox-close {
            top: 10px;
            right: 10px;
        }
    }
</style>

<script>
    // Rich Modal Logic
    function openLightbox(element) {
        // 1. Get List Image (Fallback)
        const imgSrc = element.querySelector('.gallery-img-box img').src;

        // 2. Get Data JSON
        let images = [];
        try {
            const dataImages = element.getAttribute('data-images');
            if (dataImages) {
                images = JSON.parse(dataImages);
            }
        } catch (e) {
            console.error("JSON Parse Error", e);
        }

        // If no JSON or empty, use single image
        if (images.length === 0) {
            images = [imgSrc];
        }

        // 3. Text Data
        const cateObj = element.querySelector('.gallery-cate');
        const cate = cateObj ? cateObj.innerText : '';
        const titleObj = element.querySelector('.gallery-title');

        // Remove edit button text if present
        let title = '';
        if (titleObj) {
            // Clone to avoid removing from DOM
            let clone = titleObj.cloneNode(true);
            let btn = clone.querySelector('.btn_mini_edit');
            if (btn) btn.remove();
            let img = clone.querySelector('img'); // secret icon
            if (img) img.remove();
            title = clone.innerText.trim();
        }

        const descObj = element.querySelector('.gallery-desc');
        const desc = descObj ? descObj.innerHTML : '';

        // 4. Set Initial Data
        const mainImg = document.getElementById('l-img');
        const overlay = document.getElementById('lightbox');
        const thumbWrap = document.getElementById('l-thumb-wrap');

        // Start with first image
        mainImg.src = images[0];
        mainImg.style.opacity = '0'; // Fade init
        setTimeout(() => mainImg.style.opacity = '1', 50);

        document.getElementById('l-cate').innerText = cate;
        document.getElementById('l-title').innerText = title;
        document.getElementById('l-desc').innerHTML = desc;

        // 5. Generate Thumbnails
        thumbWrap.innerHTML = ''; // Clear prev
        if (images.length > 1) {
            images.forEach((src, idx) => {
                const thumb = document.createElement('img');
                thumb.src = src;
                thumb.className = 'l-thumb' + (idx === 0 ? ' active' : '');
                thumb.onclick = function (e) {
                    e.stopPropagation(); // Prevent modal close
                    // Switch Image
                    mainImg.style.opacity = '0.5';
                    setTimeout(() => {
                        mainImg.src = src;
                        mainImg.style.opacity = '1';
                    }, 100);

                    // Update Active Class
                    document.querySelectorAll('.l-thumb').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                };
                thumbWrap.appendChild(thumb);
            });
            thumbWrap.style.display = 'flex';
        } else {
            thumbWrap.style.display = 'none'; // Hide if single image
        }

        // 6. Show Modal (Full Screen)
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Lock scroll
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.remove('active');
        document.body.style.overflow = '';

        // Clear src to stop memory leak or fast swap
        setTimeout(() => {
            document.getElementById('l-img').src = '';
        }, 300);
    }

    // Close on background click
    document.getElementById('lightbox').addEventListener('click', function (e) {
        if (e.target === this || e.target.classList.contains('l-img-area')) {
            closeLightbox();
        }
    });

    // [MODAL FIX] Move Lightbox to Body to ensure it's above Header (#hd z-index: 1000)
    document.addEventListener("DOMContentLoaded", function () {
        const lb = document.getElementById('lightbox');
        if (lb) {
            document.body.appendChild(lb);
        }
    });

    <?php if ($is_checkbox) { ?>
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
            if (document.pressed == "선택삭제") {
                if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
                    return false;
                f.removeAttribute("target");
                f.action = "./board_list_update.php";
            }
            return true;
        }
    <?php } ?>
</script>