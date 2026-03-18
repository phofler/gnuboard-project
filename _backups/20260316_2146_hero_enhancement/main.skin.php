<?php
if (!defined('_GNUBOARD_'))
    exit;

// cinema skin - Immersive, high-contrast cinematic hero
$sd_img_url = get_sub_design_image_url($item);
$main_text = $item['sd_main_text'] ? $item['sd_main_text'] : $g5['title'];
$sub_text = $item['sd_sub_text'];
?>
<section class="sub-hero sub-hero-cinema">
    <div class="sub-hero-bg" style="background-image: url('<?php echo $sd_img_url; ?>');"></div>
    <div class="sub-hero-overlay"></div>
    <div class="sub-hero-content" data-aos="zoom-out" data-aos-duration="1500">
        <h1 class="sub-hero-title">
            <?php echo $main_text; ?>
        </h1>
        <?php if ($sub_text) { ?>
            <div class="sub-hero-sep"></div>
            <p class="sub-hero-subtitle">
                <?php echo $sub_text; ?>
            </p>
        <?php } ?>
    </div>
</section>

<style>
    .sub-hero-cinema {
        position: relative;
        height: 70vh;
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        overflow: hidden;
        background: #000;
    }

    .sub-hero-cinema .sub-hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
        filter: brightness(0.5) saturate(1.2);
    }

    .sub-hero-cinema .sub-hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at center, transparent 0%, rgba(0, 0, 0, 0.6) 100%);
        z-index: 1;
    }

    .sub-hero-cinema .sub-hero-content {
        position: relative;
        z-index: 2;
        padding: 0 40px;
    }

    .sub-hero-cinema .sub-hero-title {
        font-size: 6rem;
        font-weight: 900;
        margin: 0;
        letter-spacing: 0.1em;
        text-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        background: linear-gradient(to bottom, #fff, #ccc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .sub-hero-cinema .sub-hero-sep {
        width: 60px;
        height: 2px;
        background: #fff;
        margin: 30px auto;
    }

    .sub-hero-cinema .sub-hero-subtitle {
        font-size: 1.2rem;
        font-weight: 300;
        letter-spacing: 0.4em;
        opacity: 0.8;
    }

    @media (max-width: 1024px) {
        .sub-hero-cinema .sub-hero-title {
            font-size: 4rem;
        }
    }

    @media (max-width: 768px) {
        .sub-hero-cinema .sub-hero-title {
            font-size: 2.5rem;
        }

        .sub-hero-cinema .sub-hero-subtitle {
            font-size: 0.9rem;
            letter-spacing: 0.2em;
        }
    }
</style>