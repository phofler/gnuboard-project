<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// Unique ID for Swiper
$uniqid = uniqid('works_');

// Load shared skin header
include_once(dirname(__FILE__) . '/../skin.head.php');
?>

<section class="sec-works-dark" id="<?php echo $uniqid; ?>">
    <style>
        .sec-works-dark {
            padding: 100px 0;
            background-color: var(--color-bg-dark, #121212);
            color: #fff;
            overflow: hidden;
            position: relative;
        }

        .sec-works-dark .works-header {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Standardized via skin.head.php, local overrides for layout */
        .sec-works-dark .section-title {
            margin-bottom: 15px;
        }

        .sec-works-dark .section-subtitle {
            margin-bottom: 60px;
        }

        /* Swiper Customization */
        .sec-works-dark .swiper-container {
            width: 100%;
            padding-bottom: 50px;
            overflow: visible;
        }

        .sec-works-dark .swiper-slide {
            width: 400px;
            height: 500px;
            transition: transform 0.3s ease;
            opacity: 0.4;
        }

        .sec-works-dark .swiper-slide-active {
            opacity: 1;
            transform: scale(1.05);
            z-index: 2;
        }

        /* Work Card */
        .work-card {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background: #000;
        }

        .work-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
            filter: grayscale(100%);
        }

        .sec-works-dark .swiper-slide-active .work-card img {
            filter: grayscale(0%);
        }

        .work-card:hover img {
            transform: scale(1.1);
        }

        .work-info {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 30px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.4s ease;
        }

        .sec-works-dark .swiper-slide-active .work-info {
            transform: translateY(0);
            opacity: 1;
        }

        .work-info h3 {
            font-family: var(--mc-font-heading, serif);
            font-size: 1.8rem;
            color: #fff;
            margin-bottom: 10px;
        }

        .work-info p {
            color: var(--color-text-secondary, #ccc);
            font-size: 0.95rem;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Navigation Buttons */
        .works-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            z-index: 10;
            pointer-events: none;
        }

        .works-prev,
        .works-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 60px;
            height: 60px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            cursor: pointer;
            pointer-events: auto;
            transition: all 0.3s ease;
            background: rgba(0, 0, 0, 0.5);
        }

        .works-prev:hover,
        .works-next:hover {
            background: #fff;
            color: #000;
            border-color: #fff;
        }

        .works-prev {
            left: 5%;
        }

        .works-next {
            right: 5%;
        }

        @media (max-width: 768px) {
            .sec-works-dark .swiper-slide {
                width: 80vw;
                height: 400px;
            }

            .works-prev,
            .works-next {
                display: none;
            }
        }
    </style>

    <div class="container works-header">
        <h2 class="section-title" data-aos="fade-up">
            <?php echo $bo_subject; ?>
        </h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
            Selected projects that define our philosophy.
        </p>
    </div>

    <!-- Swiper -->
    <div class="swiper-container works-swiper-<?php echo $uniqid; ?>">
        <div class="swiper-wrapper">
            <?php
            for ($i = 0; $i < count($list); $i++) {
                $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 600, 800);
                $img_url = $thumb['src'] ? $thumb['src'] : 'https://dummyimage.com/600x800/333/fff&text=No+Image';
                $description = cut_str(strip_tags($list[$i]['wr_content']), 100);
                ?>
                <div class="swiper-slide">
                    <div class="work-card">
                        <img src="<?php echo $img_url; ?>" alt="<?php echo get_text($list[$i]['wr_subject']); ?>">
                        <div class="work-info">
                            <h3>
                                <?php echo get_text($list[$i]['wr_subject']); ?>
                            </h3>
                            <p>
                                <?php echo $description; ?>
                            </p>
                            <a href="<?php echo $list[$i]['href']; ?>" class="mc-btn mc-btn-outline">VIEW PROJECT</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (count($list) == 0) { ?>
                <div class="swiper-slide">
                    <div class="work-card">
                        <div style="display:flex; align-items:center; justify-content:center; height:100%; color:#fff;">게시물이
                            없습니다.</div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Navigation -->
        <div class="works-nav">
            <div class="works-prev works-prev-<?php echo $uniqid; ?>"><i class="fa fa-angle-left"></i></div>
            <div class="works-next works-next-<?php echo $uniqid; ?>"><i class="fa fa-angle-right"></i></div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            var worksSwiper = new Swiper('.works-swiper-<?php echo $uniqid; ?>', {
                slidesPerView: 'auto',
                centeredSlides: true,
                spaceBetween: 30,
                loop: <?php echo count($list) > 1 ? 'true' : 'false'; ?>,
                speed: 800,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.works-next-<?php echo $uniqid; ?>',
                    prevEl: '.works-prev-<?php echo $uniqid; ?>',
                },
                breakpoints: {
                    768: {
                        spaceBetween: 50,
                    }
                }
            });
        });
    </script>
</section>