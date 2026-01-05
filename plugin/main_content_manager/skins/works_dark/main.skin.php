<?php
if (!defined('_GNUBOARD_'))
    exit;
?>

<section class="sec-works-dark" id="works_dark_<?php echo $section_id; ?>">
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
            margin-bottom: 60px;
        }

        .sec-works-dark .works-title {
            font-family: var(--mc-font-heading, 'Playfair Display', serif);
            font-size: 3rem;
            color: #fff;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .sec-works-dark .works-subtitle {
            font-size: 1.1rem;
            color: var(--color-text-secondary, #888);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Swiper Customization */
        .sec-works-dark .swiper-container {
            width: 100%;
            padding-bottom: 50px;
            /* Space for pagination/scrollbar */
            overflow: visible;
            /* Allow slides to peek */
        }

        .sec-works-dark .swiper-slide {
            width: 400px;
            /* Fixed width cards */
            height: 500px;
            transition: transform 0.3s ease;
            opacity: 0.4;
            /* Fade out non-active */
        }

        .sec-works-dark .swiper-slide-active {
            opacity: 1;
            transform: scale(1.05);
            /* Highlight active */
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
        }

        /* Navigation Buttons (Custom) */
        .works-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            z-index: 10;
            pointer-events: none;
            /* Let clicks pass through center */
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
            /* Re-enable clicks */
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
                /* Touch swipe only on mobile */
            }
        }
    </style>

    <div class="container works-header">
        <?php if ($show_title) { ?>
            <h2 class="works-title" data-aos="fade-up">
                <?php echo get_text($section_title); ?>
            </h2>
        <?php } ?>
        <p class="works-subtitle" data-aos="fade-up" data-aos-delay="100">
            Selected projects that define our philosophy.
        </p>
    </div>

    <!-- Swiper -->
    <div class="swiper-container works-swiper-<?php echo $section_id; ?>">
        <div class="swiper-wrapper">
            <?php foreach ($items as $i => $row) { ?>
                <div class="swiper-slide">
                    <div class="work-card">
                        <img src="<?php echo $row['img_url']; ?>" alt="<?php echo get_text($row['mc_title']); ?>">
                        <div class="work-info">
                            <h3>
                                <?php echo get_text($row['mc_title']); ?>
                            </h3>
                            <p>
                                <?php echo get_text($row['mc_desc']); ?>
                            </p>
                            <?php if ($row['mc_link']) { ?>
                                <a href="<?php echo $row['mc_link']; ?>" class="mc-btn mc-btn-outline">VIEW PROJECT</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Navigation -->
        <div class="works-nav">
            <div class="works-prev works-prev-<?php echo $section_id; ?>"><i class="fa fa-angle-left"></i></div>
            <div class="works-next works-next-<?php echo $section_id; ?>"><i class="fa fa-angle-right"></i></div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            var worksSwiper = new Swiper('.works-swiper-<?php echo $section_id; ?>', {
                slidesPerView: 'auto',
                centeredSlides: true,
                spaceBetween: 30,
                loop: true,
                speed: 800,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.works-next-<?php echo $section_id; ?>',
                    prevEl: '.works-prev-<?php echo $section_id; ?>',
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