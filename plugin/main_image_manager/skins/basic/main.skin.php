<?php
if (!defined("_GNUBOARD_")) exit; 
global $hero_config;

// 湲곕낯媛?蹂댁젙 (怨듯넻 ?⑥닔瑜??듯븯吏 ?딄퀬 ?몄텧??寃쎌슦 ?鍮?
$effect = isset($hero_config['effect']) ? $hero_config['effect'] : 'none';
$overlay_opacity = isset($hero_config['overlay']) ? $hero_config['overlay'] : 0.4;
$height = isset($hero_config['height']) ? $hero_config['height'] : '600px';

add_stylesheet('<link rel="stylesheet" href="'.G5_PLUGIN_URL.'/main_image_manager/skins/basic/style.css">', 10);
?>

<div class="hero-section hero-style-basic" style="height: <?php echo $height; ?>;">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <?php
            $slides = get_main_slides($mi_id);
            if (count($slides) > 0) {
                foreach ($slides as $slide) {
            ?>
                <div class="swiper-slide hero-split-item">
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
                        <?php if(!empty($slide['mi_tag'])) { ?>
                            <span class="hero-tag"><?php echo stripslashes($slide['mi_tag']); ?></span>
                        <?php } ?>
                        <?php if($slide['mi_title']) { ?>
                            <h2><?php echo stripslashes($slide['mi_title']); ?></h2>
                        <?php } ?>
                        <?php if(!empty($slide['mi_subtitle'])) { ?>
                            <h3 class="hero-subtitle"><?php echo stripslashes($slide['mi_subtitle']); ?></h3>
                        <?php } ?>
                        <?php if($slide['mi_desc']) { ?>
                            <p><?php echo nl2br(stripslashes($slide['mi_desc'])); ?></p>
                        <?php } ?>
                        <?php if($slide['mi_link']) { ?>
                            <a href="<?php echo $slide['mi_link']; ?>" target="<?php echo isset($slide['mi_target']) ? $slide['mi_target'] : '_self'; ?>" class="hero-btn"><?php echo !empty($slide['mi_btn_text']) ? stripslashes($slide['mi_btn_text']) : 'VIEW MORE'; ?></a>
                        <?php } ?>
                    </div>
                </div>
            <?php
                }
            } else {
                echo '<div class="swiper-slide no-slide">?대?吏 ?먮뒗 ?곗씠?곕? ?깅줉?댁＜?몄슂.</div>';
            }
            ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<script>
$(function() {
    if (typeof Swiper !== 'undefined') {
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            on: {
                slideChangeTransitionStart: function () {
                    $('.hero-content').removeClass('aos-animate');
                },
                slideChangeTransitionEnd: function () {
                    $('.hero-content').addClass('aos-animate');
                }
            }
        });
    }
});
</script>
