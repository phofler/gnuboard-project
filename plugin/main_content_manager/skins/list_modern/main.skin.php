<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * [SKIN] List Modern (Services)
 * Reference: index_ko.html (.sec-services)
 * Features: Numbered List, Hover Interaction, Accordion-like feel
 */

// 1. Theme CSS Variables (Ensuring consistency)
// Uses: --c-text, --c-brand, --f-display
?>

<style>
    /* Scoped Styles for List Modern Skin */
    .sec-services-<?php echo $ms_id; ?> {
        padding-top: 10vh;
        padding-bottom: 15vh;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        /* Optional Divider */
    }

    /* Section Title */
    .sec-services-<?php echo $ms_id; ?>.t-h2 {
        font-family: var(--f-display, serif);
        font-size: clamp(24px, 3vw, 48px);
        margin-bottom: 4rem;
        font-weight: 400;
        color: var(--c-text);
        text-transform: uppercase;
        letter-spacing: -0.02em;
    }

    /* Service List Container */
    .service-list {
        border-top: 1px solid var(--c-text);
    }

    /* Service Item Row */
    .service-item {
        border-bottom: 1px solid var(--c-text);
        padding: 4vh 0;
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        cursor: pointer;
        transition: 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        text-decoration: none;
        /* In case it's an anchor */
        color: var(--c-text);
    }

    .service-item:hover {
        color: var(--c-brand);
        padding-left: 20px;
        /* Slight indent on hover */
    }

    /* Number (01, 02...) */
    .svc-num {
        font-size: 16px;
        font-weight: 800;
        font-family: var(--f-body, sans-serif);
        width: 60px;
        /* Fixed width for alignment */
    }

    /* Service Name (Huge Text) */
    .svc-name {
        font-size: clamp(32px, 5vw, 80px);
        /* Responsive Huge */
        font-family: var(--f-display, serif);
        text-transform: uppercase;
        flex-grow: 1;
        /* Pushes Desc to right */
        letter-spacing: -0.02em;
        line-height: 1;
    }

    /* Service Description (Right Aligned) */
    .svc-desc {
        max-width: 350px;
        font-size: 15px;
        color: var(--c-sub, #555);
        text-align: right;
        line-height: 1.6;
        font-weight: 500;
        display: none;
        /* Hidden on mobile potentially? No, kept visible. */
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .service-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .svc-name {
            font-size: 32px;
        }

        .svc-desc {
            text-align: left;
            padding-left: 60px;
            /* Align with name */
            max-width: 100%;
        }
    }
</style>

<section class="container sec-services-<?php echo $ms_id; ?>" data-aos="fade-up">

    <!-- Section Title (e.g. WHAT WE DO) -->
    <?php if ($ms['ms_title_view'] != 'N' && $ms['ms_title']) { ?>
        <h2 class="t-h2">
            <?php echo $ms['ms_title']; ?>
        </h2>
    <?php } ?>

    <div class="service-list">
        <?php
        // Loop through Items
        // $ms_items is provided by the Main Content Manager render function
        if (isset($ms_items) && is_array($ms_items)) {
            $i = 1;
            foreach ($ms_items as $item) {
                $num = sprintf("%02d", $i); // 01, 02 format
                $link_href = $item['mi_link'] ? $item['mi_link'] : 'javascript:void(0);';
                $target = $item['mi_target'] ? 'target="_blank"' : '';

                // Description: mi_content (Textarea)
                // Convert newlines to <br> for HTML display
                $desc = nl2br(strip_tags($item['mi_content']));
                ?>
                <!-- Item Row -->
                <a href="<?php echo $link_href; ?>" <?php echo $target; ?> class="service-item" data-aos="fade-up"
                    data-aos-delay="
            <?php echo $i * 100; ?>">
                    <span class="svc-num">
                        <?php echo $num; ?>
                    </span>
                    <span class="svc-name">
                        <?php echo $item['mi_subject']; ?>
                    </span>

                    <?php if ($desc) { ?>
                        <div class="svc-desc">
                            <?php echo $desc; ?>
                        </div>
                    <?php } ?>
                </a>
                <?php
                $i++;
            }
        } else {
            // Empty State
            if ($is_admin == 'super') {
                echo '<div class="py-5 text-center text-muted">No items found. Please add Items (Services) in the admin panel.</div>';
            }
        }
        ?>
    </div>

</section>