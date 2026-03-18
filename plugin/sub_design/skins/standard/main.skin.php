<?php
if (!defined('_GNUBOARD_'))
    exit;

// standard skin - Universal full-width visual with centered text
$sd_img_url = get_sub_design_image_url($item);
$main_text = $item['sd_main_text'] ? $item['sd_main_text'] : $g5['title'];
$sub_text = $item['sd_sub_text'];
$tag_text = isset($item['sd_tag']) ? $item['sd_tag'] : '';

// Effect settings
$effect = json_decode($item['sd_effect'], true);
if (!$effect) {
    $effect = array(
        'tag' => array('type' => 'fade-down', 'delay' => '200', 'duration' => '1000'),
        'main' => array('type' => 'fade-up', 'delay' => '400', 'duration' => '1000'),
        'sub' => array('type' => 'fade-up', 'delay' => '600', 'duration' => '1000')
    );
}
?>
<section class="sub-hero sub-hero-standard">
    <div class="sub-hero-bg" style="background-image: url('<?php echo $sd_img_url; ?>');"></div>
    <div class="sub-hero-content">
        <?php if ($tag_text) { ?>
            <p class="sub-hero-tag" 
               data-aos="<?php echo $effect['tag']['type']; ?>" 
               data-aos-delay="<?php echo $effect['tag']['delay']; ?>"
               data-aos-duration="<?php echo $effect['tag']['duration']; ?>">
                <?php echo $tag_text; ?>
            </p>
        <?php } ?>

        <h1 class="sub-hero-title"
            data-aos="<?php echo $effect['main']['type']; ?>" 
            data-aos-delay="<?php echo $effect['main']['delay']; ?>"
            data-aos-duration="<?php echo $effect['main']['duration']; ?>">
            <?php echo $main_text; ?>
        </h1>

        <?php if ($sub_text) { ?>
            <p class="sub-hero-subtitle"
               data-aos="<?php echo $effect['sub']['type']; ?>" 
               data-aos-delay="<?php echo $effect['sub']['delay']; ?>"
               data-aos-duration="<?php echo $effect['sub']['duration']; ?>">
                <?php echo $sub_text; ?>
            </p>
        <?php } ?>
    </div>
</section>

<style>
    .sub-hero-standard {
        position: relative;
        height: 50vh;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        overflow: hidden;
        background: #111;
    }

    .sub-hero-standard .sub-hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
        filter: brightness(0.6);
        transition: transform 0.8s ease;
    }

    .sub-hero-standard:hover .sub-hero-bg {
        transform: scale(1.05);
    }

    .sub-hero-standard .sub-hero-content {
        position: relative;
        z-index: 2;
        padding: 20px;
        max-width: 1360px; /* var(--spacing-container) 대용 */
    }

    .sub-hero-standard .sub-hero-tag {
        margin-bottom: 15px;
    }

    .sub-hero-standard .sub-hero-title {
        margin: 10px 0;
        text-transform: uppercase;
    }

    .sub-hero-standard .sub-hero-subtitle {
        margin-top: 25px;
    }

    @media (max-width: 768px) {
        .sub-hero-standard { height: 40vh; min-height: 300px; }
    }
</style>