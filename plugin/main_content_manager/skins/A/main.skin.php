<?php
if (!defined('_GNUBOARD_'))
    exit;
?>
<section class="sec-product" id="product">
    <style>
        :root {
            /* Better Fallbacks for Skin A */
            --mc-section-padding: 120px;
            --mc-item-gutter: 80px;
            --mc-list-gap: 120px;
            --mc-border-radius: 4px;
            /* Previous stable style might have had sharper corners */
            --mc-item-title-size: 2.5rem;
            --mc-desc-line-height: 1.8;
            --mc-transition: all 0.5s ease;
            --mc-accent: var(--color-accent-gold, #d4af37);
            --mc-font-heading: var(--font-heading, 'Inter', sans-serif);
        }

        .sec-product {
            padding: var(--mc-section-padding) 0;
            overflow: hidden;
            background: var(--color-bg-dark, #fff);
            /* SMART INHERITANCE: Uses theme bg if dark, or white if light */
            transition: var(--mc-transition);
        }

        .sec-product .product-item {
            display: flex;
            gap: var(--mc-item-gutter);
            align-items: center;
            /* V-Center content */
            margin-bottom: var(--mc-list-gap);
        }

        .sec-product .product-item:nth-child(even) {
            flex-direction: row-reverse;
        }

        .sec-product .product-image {
            flex: 0 0 55%;
            /* Previous stable ratio: image slightly larger than text */
            overflow: hidden;
        }

        .sec-product .product-image img {
            width: 100%;
            height: 480px;
            /* Fixed height for better alignment consistency */
            object-fit: cover;
            display: block;
            border-radius: var(--mc-border-radius);
            transition: var(--mc-transition);
            /* Removed heavy shadow to match editorial look */
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sec-product .product-item:hover .product-image img {
            transform: scale(1.02);
        }

        .sec-product .product-info {
            flex: 1;
            padding: 0;
            /* Align tightly */
        }

        .sec-product .product-info h3 {
            margin-top: 0;
            font-size: var(--mc-item-title-size);
            font-weight: 700;
            color: var(--color-text-primary, #000);
            /* INHERIT: White in Dark mode, Black in Light mode */
            font-family: var(--mc-font-heading);
            margin-bottom: 30px;
            line-height: 1.2;
        }

        .sec-product .product-info p {
            font-size: 1.15rem;
            margin-bottom: 50px;
            line-height: var(--mc-desc-line-height);
            color: var(--color-text-secondary, #666);
            /* INHERIT: Grey in both dark/light */
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
                        <img src="<?php echo $row['img_url']; ?>" alt="<?php echo get_text($row['mc_title']); ?>">
                    </div>
                    <div class="product-info">
                        <h3>
                            <?php echo nl2br(get_text($row['mc_title'])); ?>
                        </h3>
                        <p>
                            <?php echo nl2br($row['mc_desc']); ?>
                        </p>
                        <?php if ($row['mc_link']) { ?>
                            <a href="<?php echo $row['mc_link']; ?>" target="<?php echo $row['mc_target']; ?>"
                                class="mc-btn-outline">VIEW PROJECT</a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>