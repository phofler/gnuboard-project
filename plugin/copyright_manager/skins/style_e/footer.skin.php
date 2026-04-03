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
<div class="footer-skin-e">
    <div class="footer-container">
        <?php if ($img_logo) { ?>
            <div class="footer-logo">
                <img src="<?php echo $img_logo; ?>" alt="footer logo">
            </div>
        <?php } ?>
        <?php if ($txt_copyright) { ?>
            <div class="footer-copyright">
                <?php echo $txt_copyright; ?>
            </div>
        <?php } ?>
    </div>
</div>
