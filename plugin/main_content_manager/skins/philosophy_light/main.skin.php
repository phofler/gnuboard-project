<?php
if (!defined('_GNUBOARD_'))
    exit;
?>
<style>
    .sec-philosophy-refined {
        padding: var(--mc-section-padding, 15vh) 0;
        background: var(--color-bg, var(--c-bg));
        transition: var(--mc-transition);
    }

    .philo-editorial-grid {
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: 0;
        align-items: center;
    }

    .philo-label-col {
        display: flex;
        justify-content: flex-start;
        padding-top: 0;
    }

    .philosophy-vertical-label {
        color: var(--c-brand);
        font-weight: 800;
        letter-spacing: 2.5px;
        font-size: 14px;
        text-transform: uppercase;
        writing-mode: horizontal-tb;
        white-space: nowrap;
    }

    .philosophy-main-text {
        font-family: var(--mc-font-heading, var(--font-heading));
        font-size: clamp(30px, 3.5vw, 45px);
        line-height: 1.45;
        color: var(--color-text-primary, var(--c-text));
        font-weight: 400;
        word-break: keep-all;
    }

    @media (max-width: 991px) {
        .philo-editorial-grid {
            grid-template-columns: 1fr;
            padding: 0 4vw;
        }

        .philo-label-col {
            margin-bottom: 20px;
            padding-top: 0;
        }

        .philosophy-vertical-label {
            writing-mode: horizontal-tb;
        }
    }
</style>

<div class="container">
    <div class="philo-editorial-grid" data-aos="fade-up">
        <!-- Vertical Label -->
        <div class="philo-label-col">
            <div class="philosophy-vertical-label">[ OUR PHILOSOPHY ]</div>
        </div>

        <!-- Main Manifesto Text -->
        <div class="philosophy-main-text">
            <?php echo nl2br(get_text($section_title)); ?>
        </div>
    </div>
</div>
</section>