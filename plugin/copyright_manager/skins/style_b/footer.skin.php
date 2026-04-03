<?php
if (!defined('_GNUBOARD_')) exit;

// [Premium Standardization] Global Skin Context 상속
global $txt_addr, $txt_tel, $txt_fax, $txt_email, $txt_copyright, $txt_slogan, $img_logo, $link1_name, $link1_url, $link2_name, $link2_url;
global $txt_company, $txt_ceo, $txt_bizno;

if (trim($cp['processed_content'])) {
    echo $processed_content . PHP_EOL;
    return;
}
?>
<div class="footer-skin-b">
    <div class="footer-container">
        <div class="footer-left">
            <?php if ($img_logo) { ?>
                <div class="footer-logo">
                    <img src="<?php echo $img_logo; ?>" alt="footer logo">
                </div>
            <?php } ?>
            <div class="footer-links">
                <?php if ($link1_name) { ?>
                    <a href="<?php echo $link1_url; ?>" class="link-privacy"><?php echo $link1_name; ?></a>
                <?php } ?>
                <?php if ($link2_name) { ?>
                    <a href="<?php echo $link2_url; ?>"><?php echo $link2_name; ?></a>
                <?php } ?>
            </div>
            <?php if ($txt_copyright) { ?>
                <div class="footer-copyright">
                    <?php echo $txt_copyright; ?>
                </div>
            <?php } ?>
        </div>

        <div class="footer-right">
            <div class="footer-contact-grid">
                <div class="info-item label-top" style="margin-bottom:10px; border-bottom:1px solid rgba(255,255,255,0.05); padding-bottom:15px;">
                    <?php if ($txt_company) { ?><span class="value" style="font-weight:700; font-size:1.1rem; color:#fff;"><?php echo $txt_company; ?></span><?php } ?>
                    <?php if ($txt_ceo) { ?><span class="value" style="margin-left:20px;"><span class="label" style="opacity:0.6;"><?php echo $cp['ceo_label']; ?></span> <?php echo $txt_ceo; ?></span><?php } ?>
                    <?php if ($txt_bizno) { ?><span class="value" style="margin-left:20px;"><span class="label" style="opacity:0.6;"><?php echo $cp['bizno_label']; ?></span> <?php echo $txt_bizno; ?></span><?php } ?>
                </div>
                <?php if ($txt_addr) { ?>
                    <div class="info-item label-top">
                        <span class="label"><?php echo $cp['addr_label']; ?></span>
                        <span class="value"><?php echo $txt_addr; ?></span>
                    </div>
                <?php } ?>
                <div class="contact-flex">
                    <?php if ($txt_tel) { ?>
                        <div class="info-item">
                            <span class="label"><?php echo $cp['tel_label']; ?></span>
                            <span class="value"><a href="tel:<?php echo $txt_tel; ?>"><?php echo $txt_tel; ?></a></span>
                        </div>
                    <?php } ?>
                    <?php if ($txt_fax) { ?>
                        <div class="info-item">
                            <span class="label"><?php echo $cp['fax_label']; ?></span>
                            <span class="value"><?php echo $txt_fax; ?></span>
                        </div>
                    <?php } ?>
                    <?php if ($txt_email) { ?>
                        <div class="info-item">
                            <span class="label"><?php echo $cp['email_label']; ?></span>
                            <span class="value"><a href="mailto:<?php echo $txt_email; ?>"><?php echo $txt_email; ?></a></span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>