<?php
if (!defined('_GNUBOARD_'))
    exit;

// instinct skin - Editorial Asymmetric layout matching sub_ko.html
$sd_img_url = get_sub_design_image_url($item);
$main_text = $item['sd_main_text'] ? $item['sd_main_text'] : $g5['title'];
$sub_text = $item['sd_sub_text'];
$sd_tag = $item['sd_tag'] ? $item['sd_tag'] : 'WHO WE ARE';
?>
<section class="sub-hero-instinct">
    <div class="instinct-hero-wrap">
        <!-- HERO SECTION -->
        <div class="instinct-header-meta" data-aos="fade-down">
            <ul class="instinct-breadcrumb">
                <li>Home</li>
                <?php
                // [Breadcrumb Logic] Show Main Category as Active (Red)
                global $current_me_code;
                $bc_text = str_replace(' 페이지', '', $g5['title']); // Default fallback
                
                if ($current_me_code) {
                    $code_1st = substr($current_me_code, 0, 2);
                    $row_1st = sql_fetch(" SELECT me_name FROM {$g5['menu_table']} WHERE me_code = '{$code_1st}' ");
                    if ($row_1st['me_name']) {
                        $bc_text = $row_1st['me_name']; // Override with Main Category
                    }
                }
                ?>
                <li class="active">
                    <?php echo $bc_text; ?>
                </li>
            </ul>
            <div class="instinct-sub-tag"><?php echo $sd_tag; ?></div>
        </div>

        <div class="instinct-hero-grid">
            <div class="instinct-hero-img-box" data-aos="fade-right">
                <img src="<?php echo $sd_img_url; ?>" alt="<?php echo $main_text; ?>">
            </div>
            <div class="instinct-title-wrap">
                <h1 class="instinct-page-title" data-aos="fade-up" data-aos-delay="200">
                    <?php echo nl2br($main_text); ?>
                </h1>
                <?php if ($sub_text) { ?>
                    <div class="instinct-sub-title" data-aos="fade-up" data-aos-delay="300">
                        <?php echo $sub_text; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<style>
    /* [Skin Scope] Instinct Sub Hero - Zero Gap Sync with sub_ko.html */
    .sub-hero-instinct {
        width: 100%;
        background: var(--color-bg, #F3F3F3);
        overflow: hidden;
    }

    .instinct-hero-wrap {
        width: 100%;
        max-width: var(--spacing-container, 1400px);
        margin: 0 auto;
        padding: 50px 20px 100px;
    }

    .instinct-header-meta {
        margin-bottom: 60px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .instinct-breadcrumb {
        display: flex;
        gap: 20px;
        /* Prototype Sync: L141 */
        font-size: 13px;
        /* Prototype Sync: L142 */
        font-weight: 700;
        text-transform: uppercase;
        color: #888;
        padding: 0;
        margin: 0;
    }

    .instinct-breadcrumb li {
        opacity: 0.6;
        color: var(--color-text-primary, #050505);
    }

    .instinct-breadcrumb li.active {
        opacity: 1;
        color: var(--color-brand, #FF3B30);
    }

    .instinct-sub-tag {
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 2px;
        color: var(--color-brand, #FF3B30);
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .instinct-hero-grid {
        display: grid;
        grid-template-columns: 500px 1fr;
        gap: 80px;
        align-items: center;
    }

    .instinct-hero-img-box {
        width: 100%;
        height: 500px;
        background: #fff;
        overflow: hidden;
        box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.1);
    }

    .instinct-hero-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: grayscale(100%);
        transition: 1s cubic-bezier(0.075, 0.82, 0.165, 1);
    }

    .instinct-hero-img-box:hover img {
        filter: grayscale(0%);
        transform: scale(1.05);
    }

    .instinct-page-title {
        font-family: var(--font-heading, 'Italiana', serif);
        font-size: clamp(60px, 9vw, 130px);
        line-height: 0.9;
        text-transform: uppercase;
        letter-spacing: -0.02em;
        margin-bottom: 0px;
        color: var(--color-text-primary, #050505);
    }

    .instinct-sub-title {
        font-family: 'Alex Brush', cursive;
        /* Script Font for Editorial touch */
        font-size: 45px;
        margin-top: 40px;
        font-weight: 400;
        color: var(--color-text-primary, #050505);
        opacity: 0.8;
    }

    @media (max-width: 1024px) {
        .instinct-hero-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .instinct-hero-img-box {
            height: 400px;
            order: 2;
        }

        .instinct-title-wrap {
            order: 1;
            padding-bottom: 30px;
        }

        .instinct-page-title {
            font-size: 12vw;
        }
    }
</style>