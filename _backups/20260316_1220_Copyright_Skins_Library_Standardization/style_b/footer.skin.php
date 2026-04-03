<?php
if (!defined('_GNUBOARD_'))
    exit;

// If editor content exists, prioritize it for maximum flexibility
if (trim($cp['processed_content'])) {
    echo $cp['processed_content'] . PHP_EOL;
    return;
}
?>
<div class="footer-skin-b">
    <div class="footer-container">
        <div class="footer-left">
            <?php if ($cp['logo_url']) { ?>
                <div class="footer-logo">
                    <img src="<?php echo $cp['logo_url']; ?>" alt="<?php echo $config['cf_title']; ?>">
                </div>
            <?php } ?>
            <div class="footer-links">
                <?php if ($cp['link1_name']) { ?>
                    <a href="<?php echo $cp['link1_url']; ?>"><?php echo $cp['link1_name']; ?></a>
                <?php } ?>
                <?php if ($cp['link2_name']) { ?>
                    <a href="<?php echo $cp['link2_url']; ?>"><?php echo $cp['link2_name']; ?></a>
                <?php } ?>
            </div>
            <?php if ($cp['copyright']) { ?>
                <div class="footer-copyright">
                    <?php echo $cp['copyright']; ?>
                </div>
            <?php } ?>
        </div>

        <div class="footer-right">
            <div class="footer-contact-grid">
                <?php if ($cp['addr_val']) { ?>
                    <div class="info-item label-top">
                        <span class="label"><?php echo $cp['addr_label']; ?></span>
                        <span class="value"><?php echo $cp['addr_val']; ?></span>
                    </div>
                <?php } ?>
                <div class="contact-flex">
                    <?php if ($cp['tel_val']) { ?>
                        <div class="info-item">
                            <span class="label"><?php echo $cp['tel_label']; ?></span>
                            <span class="value"><a href="tel:<?php echo $cp['tel_val']; ?>"><?php echo $cp['tel_val']; ?></a></span>
                        </div>
                    <?php } ?>
                    <?php if ($cp['fax_val']) { ?>
                        <div class="info-item">
                            <span class="label"><?php echo $cp['fax_label']; ?></span>
                            <span class="value"><?php echo $cp['fax_val']; ?></span>
                        </div>
                    <?php } ?>
                    <?php if ($cp['email_val']) { ?>
                        <div class="info-item">
                            <span class="label"><?php echo $cp['email_label']; ?></span>
                            <span class="value"><a href="mailto:<?php echo $cp['email_val']; ?>"><?php echo $cp['email_val']; ?></a></span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>