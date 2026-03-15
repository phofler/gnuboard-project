<?php
if (!defined("_GNUBOARD_")) exit; 
global $hero_config;

// 기본값 보정 (공통 함수를 통하지 않고 호출될 경우 대비)
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
                    $img_src = preg_match("/^(http|https):/i", $slide['mi_image']) ? $slide['mi_image'] : G5_DATA_URL . "/main_visual/" . $slide['mi_image'];
            ?>
                <div class="swiper-slide hero-split-item">
                    <div class="hero-bg effect-<?php echo $effect; ?>" style="background-image: url('<?php echo $img_src; ?>');"></div>
                    <div class="hero-overlay" style="background: rgba(0,0,0,<?php echo $overlay_opacity; ?>);"></div>
                    
                    <div class="hero-content">
                        <?php if($slide['mi_title']) { ?>
                            <h2><?php echo stripslashes($slide['mi_title']); ?></h2>
                        <?php } ?>
                        <?php if($slide['mi_desc']) { ?>
                            <p><?php echo nl2br(stripslashes($slide['mi_desc'])); ?></p>
                        <?php } ?>
                        <?php if($slide['mi_link']) { ?>
                            <a href="<?php echo $slide['mi_link']; ?>" class="hero-btn">VIEW MORE</a>
                        <?php } ?>
                    </div>
                </div>
            <?php
                }
            } else {
                echo '<div class="swiper-slide no-slide">이미지 또는 데이터를 등록해주세요.</div>';
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