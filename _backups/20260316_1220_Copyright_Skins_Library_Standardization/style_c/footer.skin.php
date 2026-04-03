<?php
if (!defined('_GNUBOARD_'))
    exit;

// If editor content exists, prioritize it for maximum flexibility
if (trim($cp['processed_content'])) {
    echo $cp['processed_content'] . PHP_EOL;
    return;
}
?>
<div class="footer-skin-c">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="grid-item branding">
                <?php if ($cp['logo_url']) { ?>
                    <img src="<?php echo $cp['logo_url']; ?>" alt="<?php echo $config['cf_title']; ?>" class="footer-logo">
                <?php } ?>
                <p class="brand-desc"><?php echo $cp['slogan'] ? $cp['slogan'] : $config['cf_title']; ?></p>
                <div class="footer-social">
                    <!-- Social icons could be added here if needed -->
                </div>
            </div>

            <div class="grid-item contact">
                <h3>Contact</h3>
                <div class="info-group">
                    <?php if ($cp['tel_val']) { ?>
                        <div class="info-item">
                            <span class="label"><?php echo $cp['tel_label']; ?></span>
                            <span class="value"><a
                                    href="tel:<?php echo $cp['tel_val']; ?>"><?php echo $cp['tel_val']; ?></a></span>
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
                            <span class="value"><a
                                    href="mailto:<?php echo $cp['email_val']; ?>"><?php echo $cp['email_val']; ?></a></span>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="grid-item location">
                <h3>Location</h3>
                <div class="info-item">
                    <span class="label"><?php echo $cp['addr_label']; ?></span>
                    <p class="address-text"><?php echo $cp['addr_val']; ?></p>
                </div>
            </div>

            <div class="grid-item links">
                <h3>Explore</h3>
                <ul class="footer-nav">
                    <?php if ($cp['link1_name']) { ?>
                        <li><a href="<?php echo $cp['link1_url']; ?>"><?php echo $cp['link1_name']; ?></a></li>
                    <?php } ?>
                    <?php if ($cp['link2_name']) { ?>
                        <li><a href="<?php echo $cp['link2_url']; ?>"><?php echo $cp['link2_name']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-copyright">
                <?php echo $cp['copyright']; ?>
            </div>
        </div>
    </div>
</div>