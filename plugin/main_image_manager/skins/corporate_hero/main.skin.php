<?php
if (!defined("_GNUBOARD_")) exit; 
global $hero_config;

$effect = isset($hero_config['effect']) ? $hero_config['effect'] : 'zoom';
$overlay_opacity = isset($hero_config['overlay']) ? $hero_config['overlay'] : 0.4;
$height = isset($hero_config['height']) ? $hero_config['height'] : '100vh';

add_stylesheet('<link rel="stylesheet" href="'.G5_PLUGIN_URL.'/main_image_manager/skins/corporate_hero/style.css">', 10);
?>

<div class="hero-section hero-style-corporate" style="height: <?php echo $height; ?>;">
    <div class="swiper mySwiper">
            <?php
            $slides = get_main_slides($mi_id);
            foreach ($slides as $slide) {
            ?>
                <div class="swiper-slide premium-slide">
                    <div class="hero-bg effect-<?php echo $effect; ?>">
                        <picture>
                            <?php if (!empty($slide['img_mobile_url'])) { ?>
                                <source media="(max-width: 768px)" srcset="<?php echo $slide['img_mobile_url']; ?>">
                            <?php } ?>
                            <img src="<?php echo $slide['img_url']; ?>" alt="<?php echo stripslashes($slide['mi_title']); ?>">
                        </picture>
                    </div>
                    <div class="hero-overlay" style="background: rgba(0,0,0,<?php echo $overlay_opacity; ?>);"></div>
                    <div class="hero-content">
                        <div class="hero-content-inner">
                            <?php if(!empty($slide['mi_tag'])) { ?>
                                <span class="hero-tag tag-animation"><?php echo stripslashes($slide['mi_tag']); ?></span>
                            <?php } ?>
                            <?php if($slide['mi_title']) { ?>
                                <h2 class="title-animation"><?php echo stripslashes($slide['mi_title']); ?></h2>
                            <?php } ?>
                            <?php if(!empty($slide['mi_subtitle'])) { ?>
                                <h3 class="hero-subtitle subtitle-animation"><?php echo stripslashes($slide['mi_subtitle']); ?></h3>
                            <?php } ?>
                            <?php if($slide['mi_desc']) { ?>
                                <p class="desc-animation"><?php echo nl2br(stripslashes($slide['mi_desc'])); ?></p>
                            <?php } ?>
                            <?php if($slide['mi_link']) { ?>
                                <a href="<?php echo $slide['mi_link']; ?>" target="<?php echo $slide['mi_target']; ?>" class="hero-btn btn-animation"><?php echo !empty($slide['mi_btn_text']) ? stripslashes($slide['mi_btn_text']) : 'VIEW COLLECTION'; ?></a>
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
            loop: true,
            effect: "fade",
            fadeEffect: { crossFade: true },
            speed: 1500,
            autoplay: { delay: 6000, disableOnInteraction: false },
            pagination: { el: ".swiper-pagination", clickable: true }
        });
    }
});
</script>
