<?php
if (!defined('_GNUBOARD_'))
    exit;
?>
<div class="footer-skin-a">
    <div class="footer-container">
        <?php if ($cp['logo_url']) { ?>
            <div class="footer-logo">
                <img src="<?php echo $cp['logo_url']; ?>" alt="<?php echo $config['cf_title']; ?>">
            </div>
        <?php } ?>

        <div class="footer-contact">
            <?php if ($cp['addr_val']) { ?>
                <div class="info-item">
                    <span class="label"><?php echo $cp['addr_label']; ?></span>
                    <span class="value"><?php echo $cp['addr_val']; ?></span>
                </div>
            <?php } ?>
            <div class="contact-row">
                <?php if ($cp['tel_val']) { ?>
                    <div class="info-item">
                        <span class="label"><?php echo $cp['tel_label']; ?></span>
                        <span class="value"><?php echo $cp['tel_val']; ?></span>
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
                        <span class="value"><?php echo $cp['email_val']; ?></span>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php if ($cp['copyright']) { ?>
            <div class="footer-copyright">
                <?php echo $cp['copyright']; ?>
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
    </div>
</div>