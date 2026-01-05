<?php
if (!defined('_GNUBOARD_'))
    exit;

// Default values if not set
$hero_title = isset($hero_title) ? $hero_title : $g5['title'];
$hero_subtitle = isset($hero_subtitle) ? $hero_subtitle : '';
$hero_img = isset($hero_img) ? $hero_img : G5_THEME_URL . '/img/default_sub_visual.jpg';
?>
<div class="sub-hero-wrapper" style="background-image: url('<?php echo $hero_img; ?>');">
    <div class="sub-hero-overlay">
        <div class="sub-hero-content">
            <h1 class="sub-hero-title" data-aos="fade-up"><?php echo $hero_title; ?></h1>
            <?php if ($hero_subtitle) { ?>
                <p class="sub-hero-subtitle" data-aos="fade-up" data-aos-delay="200"><?php echo $hero_subtitle; ?></p>
            <?php } ?>
        </div>
    </div>
</div>

<style>
    /* Common Hero Styles */
    .sub-hero-wrapper {
        position: relative;
        width: 100%;
        height: 400px;
        /* Standard Height */
        background-size: cover;
        background-position: center;
        margin-bottom: 60px;
    }

    .sub-hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sub-hero-content {
        text-align: center;
        color: #fff;
    }

    .sub-hero-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 10px;
        letter-spacing: 2px;
    }

    .sub-hero-subtitle {
        font-size: 1.2rem;
        font-weight: 300;
        opacity: 0.9;
    }

    @media (max-width: 768px) {
        .sub-hero-wrapper {
            height: 250px;
        }

        .sub-hero-title {
            font-size: 2rem;
        }
    }
</style>