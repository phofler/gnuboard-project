<?php
if (!defined('_GNUBOARD_'))
    exit;

// If editor content exists, prioritize it for maximum flexibility
if (trim($cp['processed_content'])) {
    echo $cp['processed_content'] . PHP_EOL;
    return;
}
?>
<div class="footer-skin-d">
    <div class="footer-container">
        <div class="footer-top">
            <div class="footer-logo">
                <?php if ($cp['logo_url']) { ?>
                    <img src="<?php echo $cp['logo_url']; ?>" alt="<?php echo $config['cf_title']; ?>">
                <?php } else { ?>
                    <?php echo $config['cf_title']; ?>
                <?php } ?>
            </div>
            <div class="scroll-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
                SCROLL TO TOP ↑
            </div>
        </div>

        <?php if ($cp['slogan']) { ?>
            <div class="footer-hero">
                <?php echo $cp['slogan']; ?>
            </div>
        <?php } ?>

        <div class="footer-grid">
            <div class="grid-item">
                <span>CONTACT</span>
                <?php if ($cp['tel_val']) { ?>
                    <a href="tel:<?php echo $cp['tel_val']; ?>">
                        <?php echo $cp['tel_val']; ?>
                    </a><br>
                <?php } ?>
                <?php if ($cp['email_val']) { ?>
                    <a href="mailto:<?php echo $cp['email_val']; ?>">
                        <?php echo $cp['email_val']; ?>
                    </a>
                <?php } ?>
            </div>
            <div class="grid-item">
                <span>ADDRESS</span>
                <?php echo nl2br($cp['addr_val']); ?>
            </div>
            <div class="grid-item">
                <span>SOCIAL</span>
                <?php if ($cp['link1_name']) { ?>
                    <a href="<?php echo $cp['link1_url']; ?>" target="_blank">
                        <?php echo $cp['link1_name']; ?>
                    </a><br>
                <?php } ?>
                <?php if ($cp['link2_name']) { ?>
                    <a href="<?php echo $cp['link2_url']; ?>" target="_blank">
                        <?php echo $cp['link2_name']; ?>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>