<?php
if (!defined('_GNUBOARD_'))
    exit;
// Style A: Basic (Split Layout)
?>
<div class="hero-section hero-style-a">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <?php foreach ($slides as $row) { ?>
                <div class="swiper-slide hero-split-item">
                    <div class="hero-bg" style="background-image: url('<?php echo $row['img_url']; ?>');"></div>
                    <div class="hero-overlay"></div>
                    <div class="hero-content">
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
                        <a href="<?php echo $row['mi_link'] ? $row['mi_link'] : '#'; ?>"
                            target="<?php echo $row['mi_target']; ?>" class="btn-luxury">VIEW MORE</a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <script>
        var swiperA = new Swiper(".mySwiper", {
            loop: true,
            slidesPerView: 1,
            slidesPerGroup: 1,
            centeredSlides: false,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            speed: 1000,
            breakpoints: {
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 0
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 0
                }
            }
        });
    </script>
</div>