<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// Unique ID for Swiper
$uniqid = uniqid('works_');

// Load shared skin header
include_once(dirname(__FILE__) . '/../skin.head.php');
?>

<section class="sec-works-dark">
    <style>
        .sec-works-dark {
            padding: var(--mc-section-padding, 100px) 0;
            background-color: var(--color-bg-invert, #000) !important;
            color: var(--color-text-invert, #fff);
            overflow: hidden;
            position: relative;
        }

        .sec-works-dark .works-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 40px;
            width: 100%;
            padding: 0 30px;
            box-sizing: border-box;
        }

        /* Standardized via skin.head.php, local overrides for layout */
        .sec-works-dark .section-title {
            text-align: left;
            margin: 0;
            line-height: 1;
        }

        .sec-works-dark .view-detail-link {
            font-size: 14px;
            /* Synchronized with original snippet */
            color: #fff;
            text-decoration: none;
            opacity: 0.6;
            /* Synchronized with original snippet */
            transition: opacity 0.3s ease;
            padding-bottom: 5px;
            /* Align visually with title baseline */
        }

        .sec-works-dark .view-detail-link:hover {
            opacity: 1;
        }

        /* Marquee Track */
        .marquee-track {
            display: flex;
            gap: 2vw;
            /* Space between cards */
            width: max-content;
            animation: slide 60s linear infinite;
            /* Slower for elegance */
        }

        /* Pause on Hover */
        .marquee-track:hover {
            animation-play-state: paused;
        }

        @keyframes slide {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }

            /* Move exactly half (the width of one set) */
        }

        /* Work Card */
        .work-card {
            width: 30vw;
            /* Responsive width */
            max-width: 500px;
            /* Max width constraint */
            flex-shrink: 0;
            aspect-ratio: 3/4;
            /* Maintains 600x800 ratio */
            position: relative;
            overflow: hidden;
        }

        .work-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease, filter 0.6s ease;
            filter: grayscale(100%);
        }

        .work-card:hover img {
            transform: scale(1.1);
            filter: grayscale(0%);
        }

        /* Work Meta (Overlay) */
        .work-meta {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 30px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.4s ease;
            box-sizing: border-box;
        }

        .work-card:hover .work-meta {
            transform: translateY(0);
            opacity: 1;
        }

        .work-meta h3 {
            font-family: var(--font-serif);
            /* Synchronized with theme primary serif */
            font-size: 1.8rem;
            color: #fff;
            margin: 0 0 10px 0;
        }

        .work-meta p {
            color: var(--color-text-secondary, #ccc);
            font-size: 0.95rem;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <div class="works-header">
        <h2 class="section-title">
            Selected Works
        </h2>
        <a href="<?php echo get_pretty_url($bo_table); ?>" class="view-detail-link">
            VIEW DETAIL ->
        </a>
    </div>

    <!-- Marquee Track -->
    <div class="marquee-track">
        <?php
        // Double the list for seamless loop
        $display_list = array_merge($list, $list);
        if (count($list) < 5) { // If too few items, triple them to ensure track fills screen
            $display_list = array_merge($display_list, $list);
        }

        foreach ($display_list as $row) {
            $thumb = get_list_thumbnail($bo_table, $row['wr_id'], 600, 800);
            $img_url = $thumb['src'] ? $thumb['src'] : 'https://dummyimage.com/600x800/333/fff&text=No+Image';
            $subject = get_text($row['wr_subject']);
            $desc = cut_str(strip_tags($row['wr_content']), 100);
            $href = $row['href'];
            ?>
            <div class="work-card">
                <a href="<?php echo $href; ?>" style="display:block; width:100%; height:100%;">
                    <img src="<?php echo $img_url; ?>" alt="<?php echo $subject; ?>">
                    <div class="work-meta">
                        <h3><?php echo $subject; ?></h3>
                        <p><?php echo $desc; ?></p>
                    </div>
                </a>
            </div>
        <?php } ?>

        <?php if (count($list) == 0) { ?>
            <div class="work-card" style="display:flex; align-items:center; justify-content:center; background:#111;">
                <p style="color:#666;">게시물이 없습니다.</p>
            </div>
            <!-- Duplicate for loop stability -->
            <div class="work-card" style="display:flex; align-items:center; justify-content:center; background:#111;">
                <p style="color:#666;">게시물이 없습니다.</p>
            </div>
        <?php } ?>
    </div>
</section>