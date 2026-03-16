<?php
if (!defined('_GNUBOARD_')) exit;

// [Premium Standardization] Global Skin Context 상속
global $txt_addr, $txt_tel, $txt_fax, $txt_email, $txt_copyright, $txt_slogan, $img_logo, $link1_name, $link1_url, $link2_name, $link2_url;
global $txt_company, $txt_ceo, $txt_bizno;

// If editor content exists, prioritize it for maximum flexibility
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
                <?php if ($txt_company) { ?><div class="mega-company"><?php echo $txt_company; ?></div><?php } ?>
                <div class="mega-contact-row">
                    <?php if ($txt_ceo) { ?><span><?php echo $cp['ceo_label']; ?>. <?php echo $txt_ceo; ?></span><?php } ?>
                    <?php if ($txt_bizno) { ?><span style="margin-left:20px;"><?php echo $cp['bizno_label']; ?>. <?php echo $txt_bizno; ?></span><?php } ?>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-details">
                <div class="detail-item">
                    <span class="label"><?php echo $cp['addr_label']; ?></span>
                    <span class="value"><?php echo $txt_addr; ?></span>
                </div>
                <div class="detail-row">
                    <?php if ($txt_tel) { ?>
                        <div class="detail-item">
                            <span class="label"><?php echo $cp['tel_label']; ?></span>
                            <span class="value"><?php echo $txt_tel; ?></span>
                        </div>
                    <?php } ?>
                    <?php if ($txt_email) { ?>
                        <div class="detail-item">
                            <span class="label"><?php echo $cp['email_label']; ?></span>
                            <span class="value"><?php echo $txt_email; ?></span>
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
                    <div class="footer-copyright">
                        <?php echo $txt_copyright; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>