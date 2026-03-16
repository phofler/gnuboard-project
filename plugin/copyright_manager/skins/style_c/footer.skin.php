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
<div class="footer-skin-c">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="grid-item logo-area">
                <?php if ($img_logo) { ?>
                    <img src="<?php echo $img_logo; ?>" alt="footer logo" class="footer-logo">
                <?php } ?>
                <div class="footer-company-info" style="margin-top:25px;">
                    <?php if ($txt_company) { ?><div class="company-name" style="font-size:1.2rem; font-weight:700; margin-bottom:8px; color:#fff;"><?php echo $txt_company; ?></div><?php } ?>
                    <?php if ($txt_ceo || $txt_bizno) { ?>
                        <div class="company-sub" style="font-size:0.9rem; color:rgba(255,255,255,0.6);">
                            <?php if ($txt_ceo) { ?><span><span style="opacity:0.6; font-size:0.8rem;"><?php echo $cp['ceo_label']; ?></span> <?php echo $txt_ceo; ?></span><?php } ?>
                            <?php if ($txt_bizno) { ?><span style="margin-left:15px;"><span style="opacity:0.6; font-size:0.8rem;"><?php echo $cp['bizno_label']; ?></span> <?php echo $txt_bizno; ?></span><?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="grid-item info-area">
                <div class="contact-grid">
                    <div class="contact-item">
                        <span class="label"><?php echo $cp['addr_label']; ?></span>
                        <span class="value"><?php echo $txt_addr; ?></span>
                    </div>
                    <div class="contact-sub-grid">
                        <?php if ($txt_tel) { ?>
                            <div class="contact-item">
                                <span class="label"><?php echo $cp['tel_label']; ?></span>
                                <span class="value"><a href="tel:<?php echo $txt_tel; ?>"><?php echo $txt_tel; ?></a></span>
                            </div>
                        <?php } ?>
                        <?php if ($txt_email) { ?>
                            <div class="contact-item">
                                <span class="label"><?php echo $cp['email_label']; ?></span>
                                <span class="value"><a href="mailto:<?php echo $txt_email; ?>"><?php echo $txt_email; ?></a></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="grid-item link-area">
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
        </div>
    </div>
</div>