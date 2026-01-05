<?php
if (!defined('_GNUBOARD_'))
    exit;
?>
<section class="sec-product style-b" id="product">
    <style>
        .style-b {
            padding: var(--mc-section-padding, 80px) 0 0;
            overflow: hidden;
            background: var(--color-bg-dark, #121212);
            transition: var(--mc-transition, all 0.5s ease);
        }

        .style-b .section-title {
            text-align: center;
            margin-bottom: var(--mc-list-gap, 60px);
            font-size: var(--mc-title-size, 2.5rem);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--mc-accent, var(--color-accent-gold, #d4af37));
            font-family: var(--mc-font-heading, var(--font-heading, sans-serif));
        }

        .style-b .product-item {
            display: flex;
            align-items: center;
            min-height: 500px;
            /* Reduced from 600px for better density */
            position: relative;
        }

        .style-b .product-item:nth-child(even) {
            flex-direction: row-reverse;
        }

        .style-b .product-image {
            flex: 0 0 50%;
            height: 500px;
            overflow: hidden;
        }

        .style-b .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--mc-transition);
        }

        .style-b .product-item:hover .product-image img {
            transform: scale(1.05);
        }

        .style-b .product-info {
            flex: 0 0 50%;
            padding: 0 80px;
            /* Increased padding for better balance */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .style-b .product-item:nth-child(odd) .product-info {
            align-items: flex-start;
            text-align: left;
        }

        .style-b .product-item:nth-child(even) .product-info {
            align-items: flex-end;
            text-align: right;
        }

        .style-b .product-info h3 {
            font-size: var(--mc-item-title-size, 2.2rem);
            font-weight: 700;
            margin-bottom: 25px;
            line-height: 1.2;
            color: var(--color-text-primary, #fff);
            font-family: var(--mc-font-heading);
        }

        .style-b .product-info p {
            font-size: 1.1rem;
            line-height: var(--mc-desc-line-height, 1.7);
            color: var(--color-text-secondary, #ccc);
            margin-bottom: 40px;
            max-width: 550px;
        }

        .btn-luxury-outline {
            display: inline-block;
            padding: 15px 45px;
            border: 2px solid var(--mc-accent, #d4af37);
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: 0.3s;
        }

        .btn-luxury-outline:hover {
            background: var(--mc-accent, #d4af37);
            color: #000 !important;
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
                height: 400px;
                /* Fixed height for mobile consistency */
            }

            .style-b .product-info {
                flex: auto;
                width: 100%;
                padding: 40px 20px;
                text-align: center !important;
                /* Force center on mobile */
                align-items: center !important;
                margin-top: 0;
            }

            .style-b .product-info p {
                margin: 0 auto 40px;
            }
        }
    </style>
    <div class="container">
        <?php if ($show_title) { ?>
            <h2 class="section-title" data-aos="fade-up">
                <?php echo get_text($section_title); ?>
            </h2>
        <?php } ?>
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
                    <h3>
                        <?php echo nl2br(get_text($row['mc_title'])); ?>
                    </h3>
                    <p>
                        <?php echo nl2br($row['mc_desc']); ?>
                    </p>
                    <?php if ($row['mc_link']) { ?>
                        <a href="<?php echo $row['mc_link']; ?>" target="<?php echo $row['mc_target']; ?>"
                            class="btn-luxury-outline">VIEW PROJECT</a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</section>