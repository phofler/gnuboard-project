<?php
if (!defined('_GNUBOARD_'))
    exit;

include(G5_PLUGIN_PATH . '/main_content_manager/skins/skin.head.php');
?>
<section class="sec-product" id="product">
    <style>
        .sec-product {
            --mc-section-padding: 120px;
            --mc-item-gutter: 80px;
            --mc-list-gap: 120px;
            --mc-border-radius: 4px;
            --mc-item-title-size: 2.5rem;
            --mc-desc-line-height: 1.8;
            --mc-transition: all 0.5s ease;

            padding: var(--mc-section-padding) 0;
            overflow: hidden;
            background:
                <?php echo $mc_bg_var; ?>
            ;
            /* SMART INHERITANCE */
            transition: var(--mc-transition);
        }

        .sec-product .product-item {
            display: flex;
            gap: var(--mc-item-gutter);
            align-items: center;
            margin-bottom: var(--mc-list-gap);
        }

        .sec-product .product-item:nth-child(even) {
            flex-direction: row-reverse;
        }

        .sec-product .product-image {
            flex: 0 0 55%;
            overflow: hidden;
        }

        .sec-product .product-image img {
            width: 100%;
            height: 480px;
            object-fit: cover;
            display: block;
            border-radius: var(--mc-border-radius);
            transition: var(--mc-transition);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sec-product .product-item:hover .product-image img {
            transform: scale(1.02);
        }

        .sec-product .product-info {
            flex: 1;
            padding: 0;
        }

        .sec-product .product-info h3 {
            margin-top: 0;
            font-size: var(--mc-item-title-size);
            font-weight: 700;
            color: <?php echo $mc_text_primary; ?>;
            font-family: var(--mc-font-heading);
            margin-bottom: 30px;
            line-height: 1.2;
        }

        .sec-product .product-info p {
            font-size: 1.15rem;
            margin-bottom: 50px;
            line-height: var(--mc-desc-line-height);
            color: <?php echo $mc_text_secondary; ?>;
            word-break: keep-all;
        }

        .mc-btn-outline {
            display: inline-block;
            padding: 15px 40px;
            border: 1px solid var(--mc-accent);
            color: var(--mc-accent);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
            font-size: 13px;
            transition: 0.3s;
            text-decoration: none;
        }

        .mc-btn-outline:hover {
            background: var(--mc-accent);
            color: #fff !important;
        }

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
                text-align: center;
            }
        }
    </style>
    <div class="container">
        <?php if ($show_title && $section_title) { ?>
            <h2 data-aos="fade-up"
                style="color: var(--mc-accent); text-align:center; font-family: var(--mc-font-heading); font-size: 3rem; margin-bottom: 60px; text-transform: uppercase; letter-spacing: 2px;">
                <?php echo get_text($section_title); ?>
            </h2>
        <?php } ?>
        <div class="product-list">
            <?php
            foreach ($items as $i => $row) {
                $aos_effect = ($i % 2 == 0) ? 'fade-right' : 'fade-left';
                ?>
                <div class="product-item" data-aos="<?php echo $aos_effect; ?>">
                    <div class="product-image">
                        <img src="<?php echo $row['img_url']; ?>" alt="<?php echo get_text($row['title']); ?>">
                    </div>
                    <div class="product-info">
                        <h3>
                            <?php echo $row['title']; ?>
                        </h3>
                        <p>
                            <?php echo $row['desc']; ?>
                        </p>
                        <?php if ($row['mc_link']) { ?>
                            <a href="<?php echo $row['mc_link']; ?>" target="<?php echo $row['mc_target']; ?>"
                                class="mc-btn-outline"><?php echo $row['btn_text']; ?></a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>