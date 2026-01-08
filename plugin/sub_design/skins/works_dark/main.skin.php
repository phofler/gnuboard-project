<?php
if (!defined('_GNUBOARD_'))
    exit;

// works_dark skin - Left-aligned, dark-themed editorial style
$sd_img_url = $item['sd_visual_url'] ? $item['sd_visual_url'] : G5_DATA_URL . '/sub_visual/' . $item['sd_visual_img'];
$main_text = $item['sd_main_text'] ? $item['sd_main_text'] : $g5['title'];
$sub_text = $item['sd_sub_text'];
?>
<section class="sub-hero sub-hero-works-dark">
    <div class="sub-hero-bg" style="background-image: url('<?php echo $sd_img_url; ?>');"></div>
    <div class="sub-hero-overlay"></div>
    <div class="sub-hero-content-wrapper sub-layout-width-height">
        <div class="sub-hero-content" data-aos="fade-right" data-aos-duration="1200">
            <?php if ($sub_text) { ?>
                <p class="sub-hero-subtitle">
                    <?php echo $sub_text; ?>
                </p>
            <?php } ?>
            <h1 class="sub-hero-title">
                <?php echo $main_text; ?>
            </h1>
            <div class="sub-hero-line"></div>
        </div>
    </div>
</section>

<style>
    .sub-hero-works-dark {
        position: relative;
        height: 65vh;
        min-height: 500px;
        background: #000;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    .sub-hero-works-dark .sub-hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
        transform: scale(1.1);
    }

    .sub-hero-works-dark .sub-hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(75deg, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.7) 40%, rgba(0, 0, 0, 0) 100%);
    }

    .sub-hero-works-dark .sub-hero-content-wrapper {
        position: relative;
        z-index: 2;
        width: 100%;
    }

    .sub-hero-works-dark .sub-hero-content {
        max-width: 900px;
    }

    .sub-hero-works-dark .sub-hero-title {
        font-size: 6rem;
        font-weight: 900;
        margin: 10px 0;
        color: #fff;
        line-height: 1;
        letter-spacing: -0.04em;
        text-transform: uppercase;
    }

    .sub-hero-works-dark .sub-hero-subtitle {
        font-size: 11px;
        color: var(--color-accent-gold, #d4af37);
        /* Sub-hero accent detail */
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6em;
        margin-bottom: 5px;
    }

    .sub-hero-works-dark .sub-hero-line {
        width: 120px;
        height: 1px;
        background: var(--color-accent-gold, #d4af37);
        margin-top: 40px;
    }

    @media (max-width: 1024px) {
        .sub-hero-works-dark .sub-hero-title {
            font-size: 4rem;
        }
    }

    @media (max-width: 768px) {
        .sub-hero-works-dark .sub-hero-title {
            font-size: 3rem;
        }
    }
</style>