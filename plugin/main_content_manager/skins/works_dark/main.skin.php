<?php
if (!defined('_GNUBOARD_'))
    exit;

include(G5_PLUGIN_PATH . '/main_content_manager/skins/skin.head.php');
?>
<style>
    .sec-works-dark {
        padding: 12vh 0;
        background:
            <?php echo $mc_bg_var; ?>
        ;
        overflow: hidden;
    }

    .works-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 60px;
    }

    .works-swiper-container {
        padding: 0 50px;
        position: relative;
    }

    .works-item {
        display: block;
        height: 600px;
        position: relative;
        overflow: hidden;
        transition: 0.6s cubic-bezier(0.19, 1, 0.22, 1);
        text-decoration: none;
    }

    .works-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.8s;
        filter: grayscale(100%) brightness(0.7);
    }

    .works-item:hover .works-image {
        transform: scale(1.1);
        filter: grayscale(0%) brightness(1);
    }

    .works-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 40px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
        transform: translateY(20px);
        opacity: 0;
        transition: 0.6s;
    }

    .works-item:hover .works-overlay {
        transform: translateY(0);
        opacity: 1;
    }

    .works-item-title {
        font-family: var(--mc-font-heading);
        font-size: 2rem;
        color: #fff;
        margin-bottom: 10px;
    }

    .works-item-desc {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 25px;
        word-break: keep-all;
    }

    .mc-btn-more {
        display: inline-block;
        color: var(--mc-accent);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 13px;
    }
</style>

<section class="sec-works-dark">
    <div class="container-fluid">
        <div class="works-header container">
            <h2 class="section-title" data-aos="fade-left"><?php echo $section_title; ?></h2>
        </div>

        <div class="works-swiper-container">
            <div class="swiper worksSwiper">
                <div class="swiper-wrapper">
                    <?php foreach ($items as $row) { ?>
                        <div class="swiper-slide">
                            <a href="<?php echo $row['mc_link']; ?>" target="<?php echo $row['mc_target']; ?>"
                                class="works-item">
                                <img src="<?php echo $row['img_url']; ?>" alt="<?php echo get_text($row['title']); ?>"
                                    class="works-image">
                                <div class="works-overlay">
                                    <h3 class="works-item-title"><?php echo $row['title']; ?></h3>
                                    <p class="works-item-desc"><?php echo $row['desc']; ?></p>
                                    <span class="mc-btn-more"><?php echo $row['btn_text']; ?> →</span>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var worksSwiper = new Swiper(".worksSwiper", {
        slidesPerView: 1.2,
        spaceBetween: 30,
        centeredSlides: true,
        loop: true,
        speed: 1000,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        breakpoints: {
            768: { slidesPerView: 2.5 },
            1200: { slidesPerView: 3.5 },
            1600: { slidesPerView: 4.5 }
        }
    });
</script>