<?php
if (!defined('_GNUBOARD_'))
    exit;
// Style B: Full Screen Smooth Fade

include_once(G5_PLUGIN_PATH . '/main_image_manager/skins/skin.head.php');
?>
<div class="hero-section hero-style-b">
    <div class="swiper mySwiperB">
        <div class="swiper-wrapper">
            <?php foreach ($slides as $row) { ?>
                <div class="swiper-slide">
                    <div class="hero-full">
                        <div class="hero-bg" style="background-image: url('<?php echo $row['img_url']; ?>');"></div>
                        <div class="hero-overlay"></div>
                        <div class="hero-content">
                            <?php if ($row['title']) { ?>
                                <h2>
                                    <?php echo $row['title']; ?>
                                </h2>
                            <?php } ?>
                            <?php if ($row['desc']) { ?>
                                <p>
                                    <?php echo $row['desc']; ?>
                                </p>
                            <?php } ?>
                            <?php if ($row['mi_link']) { ?>
                                <a href="<?php echo $row['mi_link']; ?>" target="<?php echo $row['mi_target']; ?>"
                                    class="btn-luxury"><?php echo $row['btn_text']; ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
    <a href="javascript:void(0);" class="scroll-arrow"
        onclick="window.scrollTo({top: window.innerHeight, behavior: 'smooth'});">
        <span>Scroll</span>
        <i>↓</i>
    </a>
</div>
<script>
    var swiperB = new Swiper(".mySwiperB", {
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
        effect: "fade",
    });
</script>