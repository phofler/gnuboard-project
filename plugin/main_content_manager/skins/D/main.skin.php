<?php
if (!defined('_GNUBOARD_'))
    exit;
?>
<section class="sec-services-modern">
    <style>
        :root {
            /* Fallback Variables for Skin D */
            --mc-section-padding: 12vh;
            --mc-transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);
            --mc-accent: var(--color-accent-gold, #d4af37);
            --mc-font-heading: var(--font-heading, 'Inter', sans-serif);
        }

        .sec-services-modern {
            padding: var(--mc-section-padding) 0;
            background: var(--color-bg-dark, #fff);
            /* INHERIT THEME BG */
            transition: var(--mc-transition);
        }

        .svc-modern-list {
            border-top: 2px solid var(--color-text-primary, #1a1a1a);
            margin-top: 60px;
        }

        .svc-modern-item {
            border-bottom: 1px solid var(--color-text-divider, rgba(255, 255, 255, 0.1));
            padding: 40px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* V-Center */
            cursor: pointer;
            transition: var(--mc-transition);
            position: relative;
            color: var(--color-text-primary, #000);
            text-decoration: none;
        }

        .svc-modern-item:hover {
            color: var(--mc-accent);
            padding-left: 30px;
            border-bottom-color: var(--mc-accent);
        }

        .svc-num {
            font-size: 14px;
            font-weight: 800;
            width: 60px;
            opacity: 0.5;
        }

        .svc-name {
            font-size: clamp(32px, 5vw, 72px);
            font-family: var(--mc-font-heading);
            text-transform: uppercase;
            flex: 1;
            font-weight: 300;
            letter-spacing: -1px;
        }

        .svc-desc {
            max-width: 350px;
            font-size: 1rem;
            color: var(--color-text-secondary, #666);
            text-align: right;
            line-height: 1.6;
            margin-left: 4vw;
            word-break: keep-all;
        }

        .t-h2-title {
            font-size: clamp(24px, 3vw, 42px);
            font-weight: 400;
            font-family: var(--mc-font-heading);
            color: var(--mc-accent);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        @media (max-width: 768px) {
            .svc-modern-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .svc-desc {
                text-align: left;
                margin-left: 0;
                max-width: 100%;
            }
        }
    </style>

    <div class="container">
        <?php if ($section_title) { ?>
            <div class="t-h2-title" data-aos="fade-up">
                <?php echo $section_title; ?>
            </div>
        <?php } ?>

        <div class="svc-modern-list">
            <?php foreach ($items as $k => $item) {
                $link_url = $item['mc_link'] ? $item['mc_link'] : 'javascript:void(0);';
                $target_attr = $item['mc_target'] ? 'target="' . $item['mc_target'] . '"' : '';
                $tag_name = $item['mc_link'] ? 'a' : 'div';
                $href_attr = $item['mc_link'] ? 'href="' . $link_url . '" ' . $target_attr : '';
                ?>
                <<?php echo $tag_name; ?>     <?php echo $href_attr; ?> class="svc-modern-item" data-aos="fade-up"
                    data-aos-delay="<?php echo $k * 100; ?>">
                    <span class="svc-num"><?php echo sprintf("%02d", $k + 1); ?></span>
                    <span class="svc-name"><?php echo $item['mc_title']; ?></span>
                    <div class="svc-desc">
                        <?php echo nl2br($item['mc_desc']); ?>
                    </div>
                </<?php echo $tag_name; ?>>
            <?php } ?>
        </div>
    </div>
</section>