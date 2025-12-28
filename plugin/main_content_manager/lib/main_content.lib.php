<?php
if (!defined('_GNUBOARD_'))
    exit;

function get_main_content_config()
{
    $config_file = G5_PLUGIN_PATH . '/main_content_manager/active_style.php';
    $config = array('active_style' => 'A', 'section_title' => 'PRODUCT COLLECTION');
    if (file_exists($config_file)) {
        include($config_file);
        $config['active_style'] = $active_style;
        $config['section_title'] = $section_title;
    }
    return $config;
}

function get_main_content_list($style)
{
    $list = array();
    $sql = " select * from g5_plugin_main_content where mc_style = '{$style}' order by mc_sort asc ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result)) {
        if ($row['mc_image']) {
            if (preg_match("/^(http|https):/i", $row['mc_image'])) {
                $row['img_url'] = $row['mc_image'];
            } else {
                $row['img_url'] = G5_DATA_URL . '/main_content/' . $row['mc_image'];
            }
        } else {
            $row['img_url'] = '';
        }
        $list[] = $row;
    }
    return $list;
}

function display_main_content($style = '')
{
    global $g5;
    $config = get_main_content_config();
    if (!$style)
        $style = $config['active_style'];
    $items = get_main_content_list($style);
    $section_title = $config['section_title'];

    if (count($items) == 0)
        return;

    if ($style == 'A') {
        ?>
        <section class="sec-product" id="product">
            <style>
                .sec-product {
                    padding: 80px 0;
                    overflow: hidden;
                }

                .sec-product .product-item {
                    display: flex;
                    gap: 50px;
                    align-items: center;
                    margin-bottom: 80px;
                }

                /* 좌우 교차 배치 (Split Alternate) */
                .sec-product .product-item:nth-child(even) {
                    flex-direction: row-reverse;
                }

                .sec-product .product-image {
                    flex: 1;
                    width: 50%;
                }

                .sec-product .product-image img {
                    width: 100%;
                    height: auto;
                    display: block;
                    border-radius: 5px;
                }

                .sec-product .product-info {
                    flex: 1;
                    width: 50%;
                }

                .sec-product .product-info h3 {
                    margin-top: 0;
                    font-size: 28px;
                    font-weight: 700;
                    color: var(--color-text-primary, #333);
                    font-family: var(--font-heading, sans-serif);
                    margin-bottom: 20px;
                }

                .sec-product .product-info p {
                    font-size: 16px;
                    margin-bottom: 30px;
                    line-height: 1.6;
                    color: var(--color-text-secondary, #666);
                    word-break: keep-all;
                }

                /* 모바일/태블릿 세로 배치 (768px 이하) */
                @media (max-width: 768px) {

                    .sec-product .product-item,
                    .sec-product .product-item:nth-child(even) {
                        flex-direction: column;
                        gap: 30px;
                    }

                    .sec-product .product-image,
                    .sec-product .product-info {
                        flex: auto;
                        width: 100%;
                    }

                    .sec-product .product-info {
                        padding: 0 10px;
                    }
                }
            </style>
            <div class="container">
                <h2 data-aos="fade-up"><?php echo get_text($section_title); ?></h2>
                <div class="product-list">
                    <?php
                    $list = get_main_content_list('A');
                    foreach ($list as $i => $row) {
                        $aos_effect = ($i % 2 == 0) ? 'fade-right' : 'fade-left';
                        ?>
                        <div class="product-item" data-aos="<?php echo $aos_effect; ?>">
                            <div class="product-image">
                                <img src="<?php echo $row['img_url']; ?>" alt="<?php echo get_text($row['mc_title']); ?>">
                            </div>
                            <div class="product-info">
                                <h3><?php echo nl2br(get_text($row['mc_title'])); ?></h3>
                                <p><?php echo nl2br(get_text($row['mc_desc'])); ?></p>
                                <a href="<?php echo $row['mc_link']; ?>" target="<?php echo $row['mc_target']; ?>"
                                    class="btn-luxury">VIEW DETAIL</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <?php
    } else if ($style == 'B') {
        ?>
            <section class="sec-product style-b" id="product">
                <style>
                    .style-b {
                        padding: 100px 0 0;
                        overflow: hidden;
                        background: var(--color-bg-dark);
                    }

                    .style-b .section-title {
                        text-align: center;
                        margin-bottom: 80px;
                        font-size: 42px;
                        font-weight: 800;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        color: var(--color-accent-gold);
                    }

                    .style-b .product-item {
                        display: flex;
                        align-items: center;
                        min-height: 600px;
                        position: relative;
                    }

                    .style-b .product-item:nth-child(even) {
                        flex-direction: row-reverse;
                    }

                    .style-b .product-image {
                        flex: 0 0 50%;
                        height: 600px;
                        overflow: hidden;
                    }

                    .style-b .product-image img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        transition: 1s ease;
                    }

                    .style-b .product-item:hover .product-image img {
                        transform: scale(1.1);
                    }

                    .style-b .product-info {
                        flex: 0 0 50%;
                        padding: 80px;
                        box-sizing: border-box;
                    }

                    .style-b .product-info h3 {
                        font-size: 36px;
                        font-weight: 700;
                        margin-bottom: 25px;
                        line-height: 1.2;
                        color: var(--color-text-primary);
                        font-family: var(--font-heading, sans-serif);
                    }

                    .style-b .product-info p {
                        font-size: 18px;
                        line-height: 1.8;
                        color: var(--color-text-secondary);
                        margin-bottom: 40px;
                        max-width: 500px;
                    }

                    .style-b .btn-magazine {
                        display: inline-block;
                        padding: 15px 45px;
                        border: 2px solid var(--color-accent-gold);
                        color: #fff;
                        text-decoration: none;
                        font-weight: 700;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                        transition: 0.3s;
                    }

                    .style-b .btn-magazine:hover {
                        background: var(--color-accent-gold);
                        color: var(--color-bg-dark);
                    }

                    @media (max-width: 768px) {

                        .style-b .product-item,
                        .style-b .product-item:nth-child(even) {
                            flex-direction: column;
                            margin-bottom: 80px;
                        }

                        .style-b .product-image {
                            flex: auto;
                            width: 100%;
                            height: auto;
                        }

                        .style-b .product-image img {
                            height: auto;
                        }

                        .style-b .product-info {
                            flex: auto;
                            width: 100%;
                            padding: 40px 20px;
                            text-align: center;
                            margin-top: 0;
                        }

                        .style-b .product-info p {
                            margin: 0 auto 40px;
                        }
                    }
                </style>
                <div class="container">
                    <h2 class="section-title" data-aos="fade-up"><?php echo get_text($section_title); ?></h2>
                </div>
                <div class="product-list">
                <?php foreach ($items as $i => $row) {
                    $is_even = ($i % 2 == 1);
                    $img_aos = $is_even ? "fade-left" : "fade-right";
                    $txt_aos = $is_even ? "fade-right" : "fade-left";
                    ?>
                        <div class="product-item">
                            <div class="product-image" data-aos="<?php echo $img_aos; ?>">
                                <img src="<?php echo $row['img_url']; ?>" alt="<?php echo get_text($row['mc_title']); ?>">
                            </div>
                            <div class="product-info" data-aos="<?php echo $txt_aos; ?>" data-aos-delay="200">
                                <h3><?php echo nl2br(get_text($row['mc_title'])); ?></h3>
                                <p><?php echo nl2br(get_text($row['mc_desc'])); ?></p>
                                <a href="<?php echo $row['mc_link']; ?>" target="<?php echo $row['mc_target']; ?>"
                                    class="btn-magazine">VIEW DETAIL</a>
                            </div>
                        </div>
                <?php } ?>
                </div>
            </section>
        <?php
    } else if ($style == 'C') {
        ?>
                <section class="sec-product style-c" id="product">
                    <style>
                        .style-c {
                            padding: 100px 0;
                            overflow: hidden;
                            background: var(--color-bg-dark);
                        }



                        .style-c .section-title {
                            text-align: center;
                            margin-bottom: 80px;
                            font-size: 42px;
                            font-weight: 800;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: var(--color-accent-gold);
                        }

                        .style-c .product-item {
                            display: flex;
                            align-items: center;
                            gap: 50px;
                            margin-bottom: 120px;
                        }

                        .style-c .product-item:last-child {
                            margin-bottom: 0;
                        }

                        .style-c .product-item:nth-child(even) {
                            flex-direction: row-reverse;
                        }

                        .style-c .product-image {
                            flex: 1;
                            width: 50%;
                            overflow: hidden;
                        }

                        .style-c .product-image img {
                            width: 100%;
                            height: 450px;
                            object-fit: cover;
                            transition: 0.5s ease;
                            filter: brightness(0.9);
                        }

                        .style-c .product-item:hover .product-image img {
                            transform: scale(1.05);
                            filter: brightness(1);
                        }

                        .style-c .product-info {
                            flex: 1;
                            width: 50%;
                        }

                        .style-c .product-info h3 {
                            font-size: 32px;
                            font-weight: 700;
                            margin-bottom: 20px;
                            color: var(--color-text-primary);
                            font-family: var(--font-heading, sans-serif);
                        }

                        .style-c .product-info p {
                            font-size: 16px;
                            line-height: 1.8;
                            color: var(--color-text-secondary);
                            margin-bottom: 30px;
                            word-break: keep-all;
                        }

                        .style-c .btn-cinema {
                            display: inline-block;
                            padding: 12px 35px;
                            border: 1px solid var(--color-accent-gold);
                            color: var(--color-accent-gold);
                            text-decoration: none;
                            font-weight: 600;
                            text-transform: uppercase;
                            transition: 0.3s;
                        }

                        .style-c .btn-cinema:hover {
                            background: var(--color-accent-gold);
                            color: var(--color-bg-dark);
                        }

                        @media (max-width: 991px) {
                            .style-c .product-item {
                                flex-direction: column !important;
                                gap: 30px;
                                margin-bottom: 80px;
                            }

                            .style-c .product-image {
                                width: 100%;
                            }

                            .style-c .product-image img {
                                height: auto;
                                max-height: 400px;
                            }

                            .style-c .product-info {
                                width: 100%;
                                text-align: left;
                                padding: 0 10px;
                            }
                        }
                    </style>
                    <div class="container">
                        <h2 class="section-title" data-aos="fade-up"><?php echo get_text($section_title); ?></h2>
                        <div class="product-list">
                    <?php foreach ($items as $i => $row) { ?>
                                <div class="product-item">
                                    <div class="product-image" data-aos="fade-up">
                                        <img src="<?php echo $row['img_url']; ?>" alt="<?php echo get_text($row['mc_title']); ?>">
                                    </div>
                                    <div class="product-info" data-aos="fade-up" data-aos-delay="200">
                                        <h3><?php echo nl2br(get_text($row['mc_title'])); ?></h3>
                                        <p><?php echo nl2br(get_text($row['mc_desc'])); ?></p>
                                        <a href="<?php echo $row['mc_link']; ?>" target="<?php echo $row['mc_target']; ?>"
                                            class="btn-cinema">VIEW DETAIL</a>
                                    </div>
                                </div>
                    <?php } ?>
                        </div>
                    </div>
                </section>
        <?php
    }
}
?>