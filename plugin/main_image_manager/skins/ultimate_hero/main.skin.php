<?php
if (!defined('_GNUBOARD_'))
    exit;
// Ultimate Hero Skin (Light Theme Specialized)
// Features: Full screen video/image, Elegant Typography, Scroll Interaction
?>

<div class="mi_ultimate_hero">
    <div class="swiper myHeroSwiper">
        <div class="swiper-wrapper">
            <?php foreach ($slides as $row) { ?>
                <div class="swiper-slide hero_slide">
                    <div class="hero_bg_wrap">
                        <?php if ($row['mi_video']) { ?>
                            <div class="hero_video">
                                <video src="<?php echo $row['mi_video']; ?>" autoplay loop muted playsinline></video>
                            </div>
                        <?php } else { ?>
                            <div class="hero_bg" style="background-image: url('<?php echo $row['img_url']; ?>');"></div>
                        <?php } ?>
                        <div class="video_overlay"></div>
                    </div>
                    <div class="hero_content">
                        <?php if ($row['mi_title']) { ?>
                            <h2>
                                <?php echo nl2br($row['mi_title']); ?>
                            </h2>
                        <?php } ?>
                        <?php if ($row['mi_desc']) { ?>
                            <p>
                                <?php echo nl2br($row['mi_desc']); ?>
                            </p>
                        <?php } ?>
                        <?php if ($row['mi_link']) { ?>
                            <a href="<?php echo $row['mi_link']; ?>"
                                target="<?php echo $row['mi_target'] ? $row['mi_target'] : '_self'; ?>"
                                class="btn_hero">Discover More</a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- Pagination/Nav could be added here if needed, keeping it clean for now -->
    </div>
    <div class="scroll_down" onclick="window.scrollTo({top: window.innerHeight, behavior: 'smooth'});">
        <i class="fa fa-angle-down"></i>
    </div>
</div>

<script>
    var heroSwiper = new Swiper(".myHeroSwiper", {
        loop: true,
        speed: 1500,
        autoplay: {
            delay: 7000,
            disableOnInteraction: false,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        }
    });
</script>