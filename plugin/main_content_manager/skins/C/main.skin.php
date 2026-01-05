<?php
if (!defined('_GNUBOARD_'))
    exit;
?>
<section class="sec-product style-c" id="product">
    <style>
        :root {
            /* Better Fallbacks for Skin C */
            --mc-section-padding: 100px;
            --mc-item-gutter: 100px;
            --mc-list-gap: 120px;
            --mc-border-radius: 0;
            /* Modern sharp look for C */
            --mc-item-title-size: 2.8rem;
            --mc-desc-line-height: 1.8;
            --mc-transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            --mc-accent: var(--color-accent-gold, #d4af37);
            --mc-font-heading: var(--font-heading, 'Inter', sans-serif);
        }

        .style-c {
            padding: var(--mc-section-padding) 0;
            overflow: hidden;
            background: var(--color-bg-dark, #fff);
            /* SMART INHERITANCE */
            transition: var(--mc-transition);
        }

        .style-c .section-title {
            text-align: center;
            margin-bottom: var(--mc-list-gap);
            font-size: var(--mc-title-size, 3rem);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--mc-accent);
            font-family: var(--mc-font-heading);
        }

        .style-c .product-item {
            display: flex;
            align-items: center;
            gap: var(--mc-item-gutter);
            margin-bottom: var(--mc-list-gap);
        }

        .style-c .product-item:last-child {
            margin-bottom: 0;
        }

        .style-c .product-item:nth-child(even) {
            flex-direction: row-reverse;
        }

        .style-c .product-image {
            flex: 0 0 50%;
            overflow: hidden;
        }

        .style-c .product-image img {
            width: 100%;
            height: 550px;
            /* Taller for Skin C (Cinema Style) */
            object-fit: cover;
            transition: var(--mc-transition);
            filter: brightness(0.85);
            border-radius: var(--mc-border-radius);
        }

        .style-c .product-item:hover .product-image img {
            transform: scale(1.05);
            filter: brightness(1);
        }

        .style-c .product-info {
            flex: 1;
        }

        .style-c .product-info h3 {
            font-size: var(--mc-item-title-size);
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--color-text-primary, #000);
            font-family: var(--mc-font-heading);
            line-height: 1.2;
        }

        .style-c .product-info p {
            font-size: 1.15rem;
            line-height: var(--mc-desc-line-height);
            color: var(--color-text-secondary, #666);
            margin-bottom: 40px;
            word-break: keep-all;
        }

        .mc-btn-outline {
            display: inline-block;
            padding: 15px 45px;
            border: 1px solid var(--mc-accent);
            color: var(--mc-accent);
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: 0.3s;
        }

        .mc-btn-outline:hover {
            background: var(--mc-accent);
            color: #fff !important;
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
        <?php if ($show_title) { ?>
            <h2 class="section-title" data-aos="fade-up">
                <?php echo get_text($section_title); ?>
            </h2>
        <?php } ?>
        <div class="product-list">
            <?php foreach ($items as $i => $row) { ?>
                <div class="product-item">
                    <div class="product-image" data-aos="fade-up">
                        <img src="<?php echo $row['img_url']; ?>" alt="<?php echo get_text($row['mc_title']); ?>">
                    </div>
                    <div class="product-info" data-aos="fade-up" data-aos-delay="200">
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