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
<div class="footer-skin-d">
    <div class="footer-container">
        <div class="footer-top">
            <div class="footer-brand">
                <?php if ($img_logo) { ?>
                    <div class="footer-logo">
                        <img src="<?php echo $img_logo; ?>" alt="footer logo">
                    </div>
                <?php } ?>
                <?php if ($txt_slogan) { ?>
                    <div class="footer-slogan">
                        <?php echo $txt_slogan; ?>
                    </div>
                <?php } ?>
            </div>
            <div class="footer-mega-info">
                <?php if ($txt_company) { ?><div class="mega-company" style="font-size:3rem; font-weight:800; color:#fff; line-height:1; margin-bottom:15px;"><?php echo $txt_company; ?></div><?php } ?>
                <div class="mega-contact-row" style="opacity:0.6; font-size:1rem;">
                    <?php if ($txt_ceo) { ?><span><?php echo $cp['ceo_label']; ?>. <?php echo $txt_ceo; ?></span><?php } ?>
                    <?php if ($txt_bizno) { ?><span style="margin-left:30px;"><?php echo $cp['bizno_label']; ?>. <?php echo $txt_bizno; ?></span><?php } ?>
                </div>
            </div>
        </div>

        <div class="footer-bottom" style="margin-top:50px; border-top:1px solid rgba(255,255,255,0.1); padding-top:40px;">
            <div class="footer-details">
                <div class="detail-item" style="margin-bottom:10px;">
                    <span class="label"><?php echo $cp['addr_label']; ?></span>
                    <span class="value" style="font-size:1.1rem; color:#fff;"><?php echo $txt_addr; ?></span>
                </div>
                <div class="detail-row">
                    <?php if ($txt_tel) { ?>
                        <div class="detail-item">
                            <span class="label"><?php echo $cp['tel_label']; ?></span>
                            <span class="value"><a href="tel:<?php echo $txt_tel; ?>"><?php echo $txt_tel; ?></a></span>
                        </div>
                    <?php } ?>
                    <?php if ($txt_email) { ?>
                        <div class="detail-item">
                            <span class="label"><?php echo $cp['email_label']; ?></span>
                            <span class="value"><a href="mailto:<?php echo $txt_email; ?>"><?php echo $txt_email; ?></a></span>
                        </div>
                    <?php } ?>
                </div>
            </div>
            
            <div class="footer-meta">
                <div class="footer-links">
                    <?php if ($link1_name) { ?>
                        <a href="<?php echo $link1_url; ?>" class="link-privacy"><?php echo $link1_name; ?></a>
                    <?php } ?>
                    <?php if ($link2_name) { ?>
                        <a href="<?php echo $link2_url; ?>"><?php echo $link2_name; ?></a>
                    <?php } ?>
                </div>
                <?php if ($txt_copyright) { ?>
                    <div class="footer-copyright" style="opacity:0.4;">
                        <?php echo $txt_copyright; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>