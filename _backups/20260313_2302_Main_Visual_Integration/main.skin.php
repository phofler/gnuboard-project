<?php
if (!defined('_GNUBOARD_'))
    exit;
// Ultimate Hero Skin (Light Theme Specialized)
// Features: Full screen video/image, Elegant Typography, Scroll Interaction

include_once(G5_PLUGIN_PATH . '/main_image_manager/skins/skin.head.php');
?>

<div class="mi_ultimate_hero">
    <div class="swiper myHeroSwiper">
        <div class="swiper-wrapper">
            <?php foreach ($slides as $row) { ?>
                <div class="swiper-slide hero_slide">
                    <div class="hero_bg_wrap">
                        <?php if (isset($row['mi_video']) && $row['mi_video']) { ?>
                            <div class="hero_video">
                                <video src="<?php echo $row['mi_video']; ?>" autoplay loop muted playsinline></video>
                            </div>
                        <?php } else { ?>
                            <div class="hero_bg" style="background-image: url('<?php echo $row['img_url']; ?>');"></div>
                        <?php } ?>
                        <div class="video_overlay"></div>
                    </div>
                    <div class="hero_content">
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
                                class="btn_hero"><?php echo $row['btn_text']; ?></a>
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