<?php
if (!defined('_GNUBOARD_'))
    exit;
// Style C: Fade (Vertical)
?>
<div class="hero-section hero-style-c">
    <div class="swiper mySwiperC">
        <div class="swiper-wrapper">
            <?php foreach ($slides as $row) { ?>
                <div class="swiper-slide">
                    <div class="hero-full">
                        <div class="hero-bg-inner" style="background-image:url('<?php echo $row['img_url']; ?>');"></div>
                        <div class="hero-overlay"></div>
                        <div class="hero-content">
                            <div class="text-wrap">
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
                                <?php
                                $mi_link = trim($row['mi_link']);
                                if ($mi_link) { ?>
                                    <a href="<?php echo $mi_link; ?>"
                                        target="<?php echo $row['mi_target'] ? $row['mi_target'] : '_self'; ?>"
                                        class="btn-luxury">VIEW
                                        MORE</a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="time-bar-container">
                            <div class="time-bar"></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <a href="javascript:void(0);" class="scroll-arrow"
        onclick="window.scrollTo({top: window.innerHeight, behavior: 'smooth'});">
        <span>Scroll</span>
        <i>↓</i>
    </a>
</div>
<script>
    var swiperC = new Swiper(".mySwiperC", {
        direction: "vertical",
        loop: true,
        mousewheel: true,
        speed: 1200,
        autoplay: { delay: 6000, disableOnInteraction: false },
        pagination: { el: ".swiper-pagination", clickable: true },
    });
</script>