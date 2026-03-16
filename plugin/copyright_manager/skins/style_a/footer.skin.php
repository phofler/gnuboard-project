<?php
if (!defined('_GNUBOARD_')) exit;

// [Premium Standardization] Global Skin Context 상속
global $txt_addr, $txt_tel, $txt_fax, $txt_email, $txt_copyright, $txt_slogan, $img_logo, $link1_name, $link1_url, $link2_name, $link2_url;
global $txt_company, $txt_ceo, $txt_bizno;

// If editor content exists, it is processed and printed.
// To ensure corporate information is always visible, we can either:
// 1. Force it in the wrapper (done in lib.php)
// 2. Or require placeholders in the editor.
if (trim($cp['processed_content'])) {
    echo $processed_content . PHP_EOL;
    return;
}
?>
<div class="footer-skin-a">
    <div class="footer-container">
        <?php if ($img_logo) { ?>
            <div class="footer-logo">
                <img src="<?php echo $img_logo; ?>" alt="footer logo">
            </div>
        <?php } ?>

        <div class="footer-contact">
             <div class="info-row" style="margin-bottom:15px; border-bottom:1px solid rgba(255,255,255,0.1); padding-bottom:15px;">
                <?php if ($txt_company) { ?><span class="info-item" style="font-size:1.1rem; color:#fff;"><strong><?php echo $txt_company; ?></strong></span><?php } ?>
                <?php if ($txt_ceo) { ?><span class="info-item"><span class="label"><?php echo $cp['ceo_label']; ?></span> <?php echo $txt_ceo; ?></span><?php } ?>
                <?php if ($txt_bizno) { ?><span class="info-item"><span class="label"><?php echo $cp['bizno_label']; ?></span> <?php echo $txt_bizno; ?></span><?php } ?>
            </div>
            <div class="info-item">
                <span class="label"><?php echo $cp['addr_label']; ?></span>
                <span class="value"><?php echo $txt_addr; ?></span>
            </div>
            <div class="contact-row">
                <?php if ($txt_tel) { ?>
                    <span class="info-item">
                        <span class="label"><?php echo $cp['tel_label']; ?></span>
                        <span class="value"><a href="tel:<?php echo $txt_tel; ?>"><?php echo $txt_tel; ?></a></span>
                    </span>
                <?php } ?>
                <?php if ($txt_fax) { ?>
                    <span class="info-item">
                        <span class="label"><?php echo $cp['fax_label']; ?></span>
                        <span class="value"><?php echo $txt_fax; ?></span>
                    </span>
                <?php } ?>
                <?php if ($txt_email) { ?>
                    <span class="info-item">
                        <span class="label"><?php echo $cp['email_label']; ?></span>
                        <span class="value"><a href="mailto:<?php echo $txt_email; ?>"><?php echo $txt_email; ?></a></span>
                    </span>
                <?php } ?>
            </div>
        </div>

        <?php if ($txt_copyright) { ?>
            <div class="footer-copyright">
                <?php echo $txt_copyright; ?>
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
    </div>
</div>