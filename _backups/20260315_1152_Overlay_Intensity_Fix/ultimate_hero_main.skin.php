<?php
if (!defined("_GNUBOARD_")) exit; 
global $hero_config;

// Platform Synchronized Options
$effect = isset($hero_config['effect']) ? $hero_config['effect'] : 'zoom';
$overlay_opacity = isset($hero_config['overlay']) ? $hero_config['overlay'] : 0.5;
$height = isset($hero_config['height']) ? $hero_config['height'] : '100vh';

// [Modularized] Generate standard style attributes using global helper
$container_attrs = function_exists('get_visual_style_attrs') 
    ? get_visual_style_attrs(array('height' => $height, 'overlay' => $overlay_opacity))
    : ' style="--hero-height: '. $height .';"';
?>

<div class="mi_ultimate_hero effect-<?php echo $effect; ?>"<?php echo $container_attrs; ?>>
    <div class="swiper mainSwiper">
        <div class="swiper-wrapper">
            <?php
            foreach ($slides as $slide) {
                $img_src = $slide['img_url'];
            ?>
                <div class="swiper-slide hero_slide">
                    <div class="hero_bg_wrap">
                        <div class="hero_bg" style="background-image: url('<?php echo $img_src; ?>');"></div>
                    </div>
                    <div class="video_overlay" style="background: rgba(0,0,0,var(--overlay-opacity, <?php echo $overlay_opacity; ?>)));"></div>
                    <div class="hero_content">
                        <?php if(!empty($slide['mi_tag'])) { ?>
                            <span class="hero_tag"><?php echo stripslashes($slide['mi_tag']); ?></span>
                        <?php } ?>
                        <?php if($slide['mi_title']) { ?>
                            <h2><?php echo stripslashes($slide['mi_title']); ?></h2>
                        <?php } ?>
                        <?php if(!empty($slide['mi_subtitle'])) { ?>
                            <h3 class="hero_subtitle"><?php echo stripslashes($slide['mi_subtitle']); ?></h3>
                        <?php } ?>
                        <?php if($slide['mi_desc']) { ?>
                            <p><?php echo nl2br(stripslashes($slide['mi_desc'])); ?></p>
                        <?php } ?>
                        <?php if($slide['mi_link']) { ?>
                            <a href="<?php echo $slide['mi_link']; ?>" target="<?php echo $slide['mi_target']; ?>" class="btn_hero"><?php echo !empty($slide['mi_btn_text']) ? stripslashes($slide['mi_btn_text']) : 'VIEW DETAILS'; ?></a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="scroll_down">
            <i class="fa fa-chevron-down"></i>
        </div>
    </div>
</div>

<script>
$(function() {
    if (typeof Swiper !== 'undefined') {
        new Swiper(".mainSwiper", {
            loop: true,
            effect: "fade",
            fadeEffect: { crossFade: true },
            speed: 2000,
            autoplay: { delay: 6000, disableOnInteraction: false },
            pagination: { el: ".swiper-pagination", clickable: true }
        });
    }
});
</script>
