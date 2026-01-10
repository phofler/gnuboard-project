<?php
if (!defined('_GNUBOARD_'))
    exit;

// minimal skin - Clean, light background with centered typography
$sd_img_url = get_sub_design_image_url($item);
$main_text = $item['sd_main_text'] ? $item['sd_main_text'] : $g5['title'];
$sub_text = $item['sd_sub_text'];
?>
<section class="sub-hero sub-hero-minimal">
    <div class="sub-hero-content" data-aos="fade-up" data-aos-duration="1000">
        <?php if ($sub_text) { ?>
            <p class="sub-hero-subtitle">
                <?php echo $sub_text; ?>
            </p>
        <?php } ?>
        <h1 class="sub-hero-title">
            <?php echo $main_text; ?>
        </h1>
        <?php if ($sd_img_url) { ?>
            <div class="sub-hero-img-box">
                <img src="<?php echo $sd_img_url; ?>" alt="hero image">
            </div>
        <?php } ?>
    </div>
</section>

<style>
    .sub-hero-minimal {
        position: relative;
        padding: 160px 0 100px;
        background: #fff;
        text-align: center;
        color: #111;
    }

    .sub-hero-minimal .sub-hero-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 40px;
    }

    .sub-hero-minimal .sub-hero-title {
        font-size: 5rem;
        font-weight: 200;
        margin: 30px 0;
        letter-spacing: -0.01em;
        line-height: 1.1;
        color: #000;
    }

    .sub-hero-minimal .sub-hero-subtitle {
        font-size: 11px;
        font-weight: 700;
        color: var(--color-primary, #c8a27c);
        text-transform: uppercase;
        letter-spacing: 0.8em;
        margin-bottom: 20px;
    }

    .sub-hero-minimal .sub-hero-img-box {
        margin: 80px auto 0;
        width: 100%;
        max-width: 1100px;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        border-radius: 2px;
        box-shadow: 0 50px 100px rgba(0, 0, 0, 0.08);
    }

    .sub-hero-minimal .sub-hero-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sub-hero-minimal {
        padding: 80px 0 40px;
    }

    .sub-hero-minimal .sub-hero-title {
        font-size: 2.5rem;
    }
    }
</style>