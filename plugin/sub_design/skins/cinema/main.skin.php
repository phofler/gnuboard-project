<?php
if (!defined('_GNUBOARD_'))
    exit;

// cinema skin - Immersive, high-contrast cinematic hero
$sd_img_url = get_sub_design_image_url($item);
$main_text = $item['sd_main_text'] ? $item['sd_main_text'] : $g5['title'];
$sub_text = $item['sd_sub_text'];
$tag_text = isset($item['sd_tag']) ? $item['sd_tag'] : '';

// Effect settings
$effect = json_decode($item['sd_effect'], true);
if (!$effect) {
    $effect = array(
        'tag' => array('type' => 'fade-down', 'delay' => '200', 'duration' => '1500'),
        'main' => array('type' => 'zoom-out', 'delay' => '400', 'duration' => '1500'),
        'sub' => array('type' => 'fade-up', 'delay' => '800', 'duration' => '1500')
    );
}
?>
<section class="sub-hero sub-hero-cinema">
    <div class="sub-hero-bg" style="background-image: url('<?php echo $sd_img_url; ?>');"></div>
    <div class="sub-hero-overlay"></div>
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
            <div class="sub-hero-sep" data-aos="fade" data-aos-delay="<?php echo (int)$effect['sub']['delay']-100; ?>"></div>
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
    .sub-hero-cinema {
        position: relative;
        height: 70vh;
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        overflow: hidden;
        background: #000;
    }

    .sub-hero-cinema .sub-hero-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
        filter: brightness(0.5) saturate(1.2);
    }

    .sub-hero-cinema .sub-hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at center, transparent 0%, rgba(0, 0, 0, 0.6) 100%);
        z-index: 1;
    }

    .sub-hero-cinema .sub-hero-content {
        position: relative;
        z-index: 2;
        padding: 0 40px;
        max-width: 1200px;
    }

    .sub-hero-cinema .sub-hero-tag {
        margin-bottom: 20px;
        opacity: 0.9;
    }

    .sub-hero-cinema .sub-hero-title {
        margin: 0;
        text-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        background: linear-gradient(to bottom, #fff, #ccc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height:1;
    }

    .sub-hero-cinema .sub-hero-sep {
        width: 80px;
        height: 2px;
        background: #fff;
        margin: 35px auto;
    }

    .sub-hero-cinema .sub-hero-subtitle {
        opacity: 0.8;
    }

    @media (max-width: 768px) {
        .sub-hero-cinema { height: 60vh; min-height: 400px; }
    }
</style>