<?php
if (!defined('_GNUBOARD_'))
    exit;

include(G5_PLUGIN_PATH . '/main_content_manager/skins/skin.head.php');
?>
<section class="sec-product style-c" id="product">
    <style>
        .style-c {
            --mc-section-padding: 100px;
            --mc-item-gutter: 100px;
            --mc-list-gap: 120px;
            --mc-border-radius: 0;
            --mc-item-title-size: 2.8rem;
            --mc-desc-line-height: 1.8;
            --mc-transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);

            padding: var(--mc-section-padding) 0;
            overflow: hidden;
            background: <?php echo $mc_bg_var; ?>;
            transition: var(--mc-transition);
        }

        .style-c .product-item {
            display: flex;
            align-items: center;
            gap: var(--mc-item-gutter);
            margin-bottom: var(--mc-list-gap);
        }

        .style-c .product-item:last-child { margin-bottom: 0; }
        .style-c .product-item:nth-child(even) { flex-direction: row-reverse; }

        .style-c .product-image { flex: 0 0 50%; overflow: hidden; }
        .style-c .product-image img {
            width: 100%;
            height: 550px;
            object-fit: cover;
            transition: var(--mc-transition);
            filter: brightness(0.85);
            border-radius: var(--mc-border-radius);
        }

        .style-c .product-item:hover .product-image img { transform: scale(1.05); filter: brightness(1); }

        .style-c .product-info { flex: 1; }

        .style-c .product-tag {
            display: inline-block;
            padding: 5px 15px;
            background: var(--mc-accent);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .style-c .product-subtitle {
            display: block;
            font-size: 1rem;
            color: var(--mc-accent);
            margin-bottom: 10px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .style-c .product-info h3 {
            font-size: var(--mc-item-title-size);
            font-weight: 700;
            margin-bottom: 25px;
            color: <?php echo $mc_text_primary; ?>;
            font-family: var(--mc-font-heading);
            line-height: 1.2;
        }

        .style-c .product-desc {
            font-size: 1.15rem;
            line-height: var(--mc-desc-line-height);
            color: <?php echo $mc_text_secondary; ?>;
            margin-bottom: 40px;
            word-break: keep-all;
        }

        .mc-btn-outline {
            display: inline-block;
            padding: 15px 45px;
            border: 2px solid var(--mc-accent);
            color: var(--mc-accent);
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: 0.3s;
        }

        .mc-btn-outline:hover { background: var(--mc-accent); color: #fff !important; }

        @media (max-width: 991px) {
            .style-c .product-item { flex-direction: column !important; gap: 30px; margin-bottom: 80px; }
            .style-c .product-image { width: 100%; }
            .style-c .product-image img { height: auto; max-height: 400px; }
            .style-c .product-info { width: 100%; text-align: left; padding: 0 10px; }
        }
    </style>
    <div class="container">
        <?php if ($show_title && $section_title) { ?>
            <div class="section-header" style="text-align:center; margin-bottom:80px;" data-aos="fade-up">
                <h2 class="section-title" style="font-weight:700; color:<?php echo $mc_text_primary; ?>; margin-bottom:10px;">
                    <?php echo get_text($section_title); ?>
                </h2>
                <?php if (isset($section_subtitle) && $section_subtitle) { ?>
                    <p class="section-subtitle-main" style="font-size:1.1rem; color:<?php echo $mc_text_secondary; ?>; opacity:0.8; letter-spacing:1px;">
                        <?php echo get_text($section_subtitle); ?>
                    </p>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="product-list">
            <?php foreach ($items as $i => $row) {
                $btn_text = (isset($row['mc_link_text']) && $row['mc_link_text']) ? $row['mc_link_text'] : 'VIEW MORE';
                ?>
                <div class="product-item">
                    <div class="product-image" data-aos="fade-up">
                        <img src="<?php echo $row['img_url']; ?>" alt="<?php echo get_text($row['mc_title']); ?>">
                    </div>
                    <div class="product-info" data-aos="fade-up" data-aos-delay="200">
                        <?php if (isset($row['mc_tag']) && $row['mc_tag']) { ?>
                            <span class="product-tag"><?php echo get_text($row['mc_tag']); ?></span>
                        <?php } ?>
                        <?php if (isset($row['mc_subtitle']) && $row['mc_subtitle']) { ?>
                            <span class="product-subtitle"><?php echo get_text($row['mc_subtitle']); ?></span>
                        <?php } ?>
                        <h3><?php echo get_text($row['mc_title']); ?></h3>
                        <div class="product-desc">
                            <?php echo $row['mc_desc']; ?>
                        </div>
                        <?php if ($row['mc_link']) { ?>
                            <a href="<?php echo $row['mc_link']; ?>" target="<?php echo $row['mc_target']; ?>" class="mc-btn-outline"><?php echo get_text($btn_text); ?></a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>