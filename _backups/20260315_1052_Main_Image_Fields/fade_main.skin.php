<?php
if (!defined("_GNUBOARD_")) exit; 
global $hero_config;

$effect = isset($hero_config['effect']) ? $hero_config['effect'] : 'zoom';
$overlay_opacity = isset($hero_config['overlay']) ? $hero_config['overlay'] : 0.4;
$height = isset($hero_config['height']) ? $hero_config['height'] : '100vh';

add_stylesheet('<link rel="stylesheet" href="'.G5_PLUGIN_URL.'/main_image_manager/skins/fade/style.css">', 10);
?>

<div class="hero-section hero-style-vertical" style="height: <?php echo $height; ?>;">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <?php
            $slides = get_main_slides($mi_id);
            foreach ($slides as $slide) {
                $img_src = preg_match("/^(http|https):/i", $slide['mi_image']) ? $slide['mi_image'] : G5_DATA_URL . "/main_visual/" . $slide['mi_image'];
            ?>
                <div class="swiper-slide vertical-slide">
                    <div class="hero-bg effect-<?php echo $effect; ?>" style="background-image: url('<?php echo $img_src; ?>');"></div>
                    <div class="hero-overlay" style="background: rgba(0,0,0,<?php echo $overlay_opacity; ?>);"></div>
                    <div class="hero-content">
                        <div class="hero-content-inner">
                            <?php if($slide['mi_title']) { ?>
                                <h2 class="title-animation"><?php echo stripslashes($slide['mi_title']); ?></h2>
                            <?php } ?>
                            <?php if($slide['mi_desc']) { ?>
                                <p class="desc-animation"><?php echo nl2br(stripslashes($slide['mi_desc'])); ?></p>
                            <?php } ?>
                            <?php if($slide['mi_link']) { ?>
                                <a href="<?php echo $slide['mi_link']; ?>" class="hero-btn btn-animation">DISCOVER NOW</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<script>
$(function() {
    if (typeof Swiper !== 'undefined') {
        new Swiper(".mySwiper", {
            direction: "vertical",
            loop: true,
            speed: 1200,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: ".swiper-pagination", clickable: true },
            mousewheel: true,
        });
    }
});
</script>