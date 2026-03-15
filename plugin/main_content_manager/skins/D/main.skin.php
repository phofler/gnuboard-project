<?php
if (!defined('_GNUBOARD_'))
    exit;

include(G5_PLUGIN_PATH . '/main_content_manager/skins/skin.head.php');
?>
<section class="sec-services-modern">
    <style>
        .sec-services-modern {
            --mc-section-padding: 12vh;
            --mc-transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1);

            padding: var(--mc-section-padding) 0;
            background: <?php echo $mc_bg_var; ?>;
            transition: var(--mc-transition);
        }

        .svc-modern-list { border-top: 2px solid <?php echo $mc_text_primary; ?>; margin-top: 60px; }

        .svc-modern-item {
            border-bottom: 1px solid rgba(127, 127, 127, 0.2);
            padding: 40px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: var(--mc-transition);
            position: relative;
            color: <?php echo $mc_text_primary; ?>;
            text-decoration: none;
        }

        .svc-modern-item:hover { color: var(--mc-accent); padding-left: 30px; border-bottom-color: var(--mc-accent); }

        .svc-meta { width: 100px; display: flex; flex-direction: column; gap: 5px; }
        .svc-num { font-size: 14px; font-weight: 800; opacity: 0.5; }
        .svc-tag { font-size: 10px; background: var(--mc-accent); color: #fff; padding: 2px 6px; width: fit-content; border-radius: 2px; text-transform: uppercase; }

        .svc-content { flex: 1; display: flex; flex-direction: column; }
        .svc-subtitle { font-size: 12px; color: var(--mc-accent); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 5px; font-weight: 600; }
        .svc-name { font-size: clamp(32px, 5vw, 64px); font-family: var(--mc-font-heading); text-transform: uppercase; font-weight: 300; letter-spacing: -1px; }

        .svc-desc-wrap { max-width: 350px; text-align: right; margin-left: 4vw; }
        .svc-desc { font-size: 1rem; color: <?php echo $mc_text_secondary; ?>; line-height: 1.6; word-break: keep-all; margin-bottom: 15px; }
        .svc-btn-text { font-size: 12px; font-weight: 800; color: var(--mc-accent); text-transform: uppercase; letter-spacing: 1px; }

        @media (max-width: 768px) {
            .svc-modern-item { flex-direction: column; align-items: flex-start; gap: 20px; }
            .svc-desc-wrap { text-align: left; margin-left: 0; max-width: 100%; }
        }
    </style>

    <div class="container">
        <?php if ($section_title) { ?>
            <div class="section-header" style="text-align:left; margin-bottom:40px;" data-aos="fade-up">
                <h2 class="section-title" style="color:<?php echo $mc_text_primary; ?>; margin-bottom:5px;">
                    <?php echo get_text($section_title); ?>
                </h2>
                <?php if (isset($section_subtitle) && $section_subtitle) { ?>
                    <p class="section-subtitle-main" style="font-size:1.1rem; color:<?php echo $mc_text_secondary; ?>; opacity:0.8;">
                        <?php echo get_text($section_subtitle); ?>
                    </p>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="svc-modern-list">
            <?php foreach ($items as $k => $item) {
                $link_url = $item['mc_link'] ? $item['mc_link'] : 'javascript:void(0);';
                $tag_name = $item['mc_link'] ? 'a' : 'div';
                $href_attr = $item['mc_link'] ? 'href="' . $link_url . '" target="' . $item['mc_target'] . '"' : '';
                $btn_text = (isset($item['mc_link_text']) && $item['mc_link_text']) ? $item['mc_link_text'] : 'VIEW PROJECT';
                ?>
                <<?php echo $tag_name; ?> <?php echo $href_attr; ?> class="svc-modern-item" data-aos="fade-up" data-aos-delay="<?php echo $k * 100; ?>">
                    <div class="svc-meta">
                        <span class="svc-num"><?php echo sprintf("%02d", $k + 1); ?></span>
                        <?php if (isset($item['mc_tag']) && $item['mc_tag']) { ?>
                            <span class="svc-tag"><?php echo get_text($item['mc_tag']); ?></span>
                        <?php } ?>
                    </div>
                    <div class="svc-content">
                        <?php if (isset($item['mc_subtitle']) && $item['mc_subtitle']) { ?>
                            <span class="svc-subtitle"><?php echo get_text($item['mc_subtitle']); ?></span>
                        <?php } ?>
                        <span class="svc-name"><?php echo get_text($item['mc_title']); ?></span>
                    </div>
                    <div class="svc-desc-wrap">
                        <div class="svc-desc">
                            <?php echo $item['mc_desc']; ?>
                        </div>
                        <?php if ($item['mc_link']) { ?>
                            <span class="svc-btn-text"><?php echo get_text($btn_text); ?> →</span>
                        <?php } ?>
                    </div>
                </<?php echo $tag_name; ?>>
            <?php } ?>
        </div>
    </div>
</section>