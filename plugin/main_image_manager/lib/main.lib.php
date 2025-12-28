<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * 활성화된 메인 스타일을 반환
 */
function get_active_main_style()
{
    $config_file = G5_PLUGIN_PATH . '/main_image_manager/active_style.php';
    $active_style = 'A'; // Default
    if (file_exists($config_file)) {
        include($config_file);
    }
    return $active_style;
}

/**
 * 해당 스타일의 이미지 리스트 반환
 */
function get_main_slides($style)
{
    $list = array();
    $sql = " select * from g5_plugin_main_image_add where mi_style = '{$style}' and mi_image != '' order by mi_sort asc ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result)) {
        if (preg_match("/^(http|https):/i", $row['mi_image'])) {
            $row['img_url'] = $row['mi_image'];
        } else {
            $row['img_url'] = G5_DATA_URL . '/main_visual/' . $row['mi_image'];
        }
        $list[] = $row;
    }
    return $list;
}

/**
 * 메인 비주얼 출력 (HTML)
 */
function display_main_visual($style = '')
{
    global $g5;

    if (!$style) {
        $style = get_active_main_style();
    }
    $slides = get_main_slides($style);

    // 데이터가 하나도 없으면 출력하지 않음 (또는 기본 이미지 출력)
    if (count($slides) == 0)
        return;

    // Style A: Split Layout (Carousel sliding one by one)
    if ($style == 'A') {
        ?>
        <style>
            .hero-style-a .swiper-button-next,
            .hero-style-a .swiper-button-prev {
                color: #fff !important;
                opacity: 0.7;
                transition: all 0.3s ease;
                background: rgba(0,0,0,0.2);
                width: 50px; 
                height: 50px;
                border-radius: 50%;
                top: 50%;
                transform: translateY(-50%);
                margin-top: 0;
                z-index: 10;
            }
            .hero-style-a .swiper-button-next:after,
            .hero-style-a .swiper-button-prev:after { font-size: 1.5rem; font-weight: bold; }
            .hero-style-a .swiper-button-next:hover,
            .hero-style-a .swiper-button-prev:hover {
                background: rgba(0,0,0,0.6);
                opacity: 1;
            }
        </style>
        <div class="hero-section hero-style-a">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php foreach ($slides as $row) { ?>
                        <div class="swiper-slide hero-split-item">
                            <div class="hero-bg" style="background-image: url('<?php echo $row['img_url']; ?>');"></div>
                            <div class="hero-overlay"></div>
                            <div class="hero-content">
                                <?php if ($row['mi_title']) { ?>
                                    <h2><?php echo nl2br($row['mi_title']); ?></h2><?php } ?>
                                <?php if ($row['mi_desc']) { ?>
                                    <p><?php echo nl2br($row['mi_desc']); ?></p><?php } ?>
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
        <?php
    }

    // Style B: Full Screen Slider
    else if ($style == 'B') {
        ?>
            <style>
                .hero-section.hero-style-b { display: block; position: relative; width: 100%; height: 100vh; overflow: hidden; background: #000; }
                .hero-style-b .swiper { width: 100%; height: 100%; }
                .hero-style-b .hero-full { position: relative; width: 100%; height: 100vh; overflow: hidden; }
                .hero-style-b .hero-bg-inner { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-size: cover; background-position: center; z-index: 1; }
                .hero-style-b .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 2; }
                
                @keyframes kenburnsZoomB { 0% { transform: scale(1); } 100% { transform: scale(1.15); } }
                .hero-style-b .swiper-slide-active .hero-bg-inner { animation: kenburnsZoomB 12s ease-out forwards; }
                .hero-style-b .hero-content-center { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: #fff; z-index: 3; width: 90%; max-width: 800px; pointer-events: none; }
                .hero-style-b .hero-content-center > * { pointer-events: auto; }
                .hero-style-b .swiper-slide { opacity: 0 !important; visibility: hidden; transition: opacity 0.6s ease, visibility 0.6s ease; }
                .hero-style-b .swiper-slide-active { opacity: 1 !important; visibility: visible; }

                .btn-luxury { display: inline-block; transition: all 0.3s ease; position: relative; z-index: 5; }
                .btn-luxury:hover { background: #fff !important; color: #000 !important; transform: translateY(-3px); }

                /* Scroll Arrow for Style B */
                .hero-style-b .scroll-arrow { position: absolute; bottom: 40px; right: 40px; color: #fff; font-size: 2rem; cursor: pointer; z-index: 10; text-align: center; text-decoration: none; }
                .hero-style-b .scroll-arrow span { display: block; font-size: 0.7rem; letter-spacing: 2px; margin-bottom: 5px; opacity: 0.8; text-transform: uppercase; }
                @keyframes bounce { 0%, 20%, 50%, 80%, 100% { transform: translateY(0); } 40% { transform: translateY(-10px); } 60% { transform: translateY(-5px); } }
                .hero-style-b .scroll-arrow i { display: block; animation: bounce 2s infinite; font-style: normal; }
                
                /* Pagination (Time Bar) Position Logic - Style B */
                .hero-style-b .swiper-pagination { bottom: 30px !important; }
                
                /* Style B Time Bar Visibility Fix */
                .hero-style-b .time-bar-container { position: absolute; bottom: 85px; left: 50%; transform: translateX(-50%); width: 220px; height: 4px; background: rgba(0, 0, 0, 0.5); border-radius: 2px; z-index: 999; pointer-events: none; overflow: hidden; }
                .hero-style-b .time-bar { width: 0%; height: 100%; background: #ffffff; border-radius: 2px; }
                @keyframes timeFlowB { from { width: 0%; } to { width: 100%; } }
                .hero-style-b .swiper-slide-active .time-bar { animation: timeFlowB 5.5s linear forwards; }

                @media (max-width: 768px) {
                    .hero-style-b .hero-content-center h2 { font-size: 2.5rem !important; }
                    .hero-style-b .hero-content-center p { font-size: 1.1rem !important; }
                    .hero-style-b .scroll-arrow { right: 20px; bottom: 80px; }
                    .hero-style-b .time-bar-container { width: 120px; }
                }
            </style>
            <div class="hero-section hero-style-b">
                <div class="swiper mySwiperB">
                    <div class="swiper-wrapper">
                    <?php foreach ($slides as $row) { ?>
                            <div class="swiper-slide">
                                <div class="hero-full">
                                    <div class="hero-bg-inner" style="background-image: url('<?php echo $row['img_url']; ?>');"></div>
                                    <div class="hero-overlay"></div>
                                    <div class="hero-content-center">
                                    <?php if ($row['mi_title']) { ?>
                                            <h2 style="font-size:4rem; margin-bottom:20px; font-weight:700;"><?php echo nl2br($row['mi_title']); ?></h2>
                                    <?php } ?>
                                    <?php if ($row['mi_desc']) { ?>
                                            <p style="font-size:1.5rem; margin-bottom:40px; opacity:0.9; max-width:800px; margin-left:auto; margin-right:auto;">
                                            <?php echo nl2br($row['mi_desc']); ?>
                                            </p><?php } ?>
                                    <?php if ($row['mi_link']) { ?>
                                            <a href="<?php echo $row['mi_link']; ?>"
                                                target="<?php echo $row['mi_target'] ? $row['mi_target'] : '_self'; ?>" class="btn-luxury"
                                                style="display:inline-block; border:1px solid #fff; color:#fff; padding:15px 40px; text-decoration:none;">VIEW MORE</a>
                                    <?php } ?>
                                    </div>
                                    <div class="time-bar-container"><div class="time-bar"></div></div>
                                </div>
                            </div>
                    <?php } ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
                <a href="javascript:void(0);" class="scroll-arrow" onclick="document.querySelector('.sub_con_wrapper').scrollIntoView({behavior:'smooth'});">
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
        <?php
    }

    // Style C: Vertical Full Screen Slider with Enhancements
    else if ($style == 'C') {
        ?>
            <style>
                .hero-section.hero-style-c { display: block; position: relative; width: 100%; height: 100vh; overflow: hidden; background: #000; }
                .hero-style-c .swiper { width: 100%; height: 100%; }
                .hero-style-c .hero-full { position: relative; width: 100%; height: 100vh; overflow: hidden; }
                .hero-style-c .hero-bg-inner { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-size: cover; background-position: center; z-index: 1; filter: brightness(0.6); }
                .hero-style-c .hero-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4); z-index: 2; }
                
                @keyframes kenburnsZoomC { 0% { transform: scale(1); } 100% { transform: scale(1.12); } }
                .hero-style-c .swiper-slide-active .hero-bg-inner { animation: kenburnsZoomC 12s ease-out forwards; }

                .btn-luxury { display: inline-block; transition: all 0.3s ease; position: relative; z-index: 5; }
                .btn-luxury:hover { background: #fff !important; color: #000 !important; transform: translateY(-3px); }
                .hero-style-c .swiper-slide-active { z-index: 5; }

                .hero-style-c .hero-content { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #fff; text-align: center; z-index: 3; padding: 0 20px; box-sizing: border-box; pointer-events: none; }
                .hero-style-c .text-wrap { opacity: 0; visibility: hidden; transform: scale(0.9); transition: all 1.2s cubic-bezier(0.2, 0.8, 0.2, 1); pointer-events: auto; }
                .hero-style-c .swiper-slide-active .text-wrap { opacity: 1; visibility: visible; transform: scale(1); }
                .hero-style-c .swiper-slide { pointer-events: none; }
                .hero-style-c .swiper-slide-active { pointer-events: auto; }

                .hero-style-c .time-bar-container { position: absolute; bottom: 85px; left: 50%; transform: translateX(-50%); width: 220px; height: 4px; background: rgba(0, 0, 0, 0.5); border-radius: 2px; z-index: 999; pointer-events: none; overflow: hidden; }
                .hero-style-c .time-bar { width: 0%; height: 100%; background: #ffffff; border-radius: 2px; }
                .hero-style-c .time-bar { width: 0%; height: 100%; background: #ffffff; box-shadow: 0 0 10px rgba(255,255,255,0.5); }
                @keyframes timeFlowC { from { width: 0%; } to { width: 100%; } }
                .hero-style-c .swiper-slide-active .time-bar { animation: timeFlowC 6s linear forwards; }

                .hero-style-c .scroll-arrow { position: absolute; bottom: 40px; right: 40px; color: #fff; font-size: 2rem; cursor: pointer; z-index: 10; text-align: center; text-decoration: none; }
                .hero-style-c .scroll-arrow span { display: block; font-size: 0.7rem; letter-spacing: 2px; margin-bottom: 5px; opacity: 0.8; text-transform: uppercase; }
                @keyframes bounce { 0%, 20%, 50%, 80%, 100% { transform: translateY(0); } 40% { transform: translateY(-10px); } 60% { transform: translateY(-5px); } }
                .hero-style-c .scroll-arrow i { display: block; animation: bounce 2s infinite; font-style: normal; }
            </style>
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
                                                <h2 style="font-size:4.5rem; font-weight:700; margin-bottom:20px; letter-spacing:-2px; line-height:1.1;">
                                                    <?php echo nl2br($row['mi_title']); ?>
                                                </h2><?php } ?>
                                        <?php if ($row['mi_desc']) { ?>
                                                <p style="font-size:1.3rem; line-height:1.6; margin-bottom:40px; opacity:0.8; max-width:800px; margin-left:auto; margin-right:auto;">
                                                    <?php echo nl2br($row['mi_desc']); ?>
                                                </p><?php } ?>
                                        <?php 
                                        $mi_link = trim($row['mi_link']);
                                        if ($mi_link) { ?>
                                                <a href="<?php echo $mi_link; ?>"
                                                    target="<?php echo $row['mi_target'] ? $row['mi_target'] : '_self'; ?>" class="btn-luxury"
                                                    style="border:2px solid #fff; padding:18px 50px; color:#fff; font-weight:700; text-decoration:none;">VIEW MORE</a>
                                        <?php } ?>
                                        </div>
                                    </div>
                                    <div class="time-bar-container"><div class="time-bar"></div></div>
                                </div>
                            </div>
                <?php } ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <a href="javascript:void(0);" class="scroll-arrow" onclick="document.querySelector('.sub_con_wrapper').scrollIntoView({behavior:'smooth'});">
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
        <?php
    }
}
?>