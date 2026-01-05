<?php
if (!defined('_GNUBOARD_'))
    exit;

// standard skin - Universal full-width visual with centered text
$sd_img_url = $item['sd_visual_url'] ? $item['sd_visual_url'] : G5_DATA_URL . '/sub_visual/' . $item['sd_visual_img'];
$main_text = $item['sd_main_text'] ? $item['sd_main_text'] : $g5['title'];
$sub_text = $item['sd_sub_text'];
?>
<section class="sub-hero sub-hero-standard">
    <div class="sub-hero-bg" style="background-image: url('<?php echo $sd_img_url; ?>');"></div>
    <div class="sub-hero-content" data-aos="fade-up" data-aos-duration="1000">
        <?php if ($sub_text) { ?>
            <p class="sub-hero-subtitle">
                <?php echo $sub_text; ?>
            </p>
        <?php } ?>
        <h1 class="sub-hero-title">
            <?php echo $main_text; ?>
        </h1>
    </div>
</section>

<style>
    .sub-hero-standard {
        position: relative;
        height: 50vh;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        overflow: hidden;
        background: #111;
    }

    .sub-hero-standard .sub-hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
        filter: brightness(0.6);
        transition: transform 0.8s ease;
    }

    .sub-hero-standard:hover .sub-hero-bg {
        transform: scale(1.05);
    }

    .sub-hero-standard .sub-hero-content {
        position: relative;
        z-index: 2;
        padding: 20px;
    }

    .sub-hero-standard .sub-hero-title {
        font-size: 4rem;
        font-weight: 800;
        margin: 10px 0 0;
        letter-spacing: -0.02em;
        text-transform: uppercase;
    }

    .sub-hero-standard .sub-hero-subtitle {
        font-size: 1rem;
        font-weight: 500;
        color: var(--color-primary, #c8a27c);
        text-transform: uppercase;
        letter-spacing: 0.2em;
        margin-bottom: 5px;
    }

    @media (max-width: 768px) {
        .sub-hero-standard .sub-hero-title {
            font-size: 2.5rem;
        }
    }
</style>