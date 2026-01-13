<?php
if (!defined('_GNUBOARD_'))
    exit;
// Modern Minimal Skin for Online Inquiry
include_once(ONLINE_INQUIRY_PATH . '/skin.head.php');
?>

<div class="inquiry-form modern-inquiry-skin">
    <!-- Content logic moved to skin.head.php -->

    <form name="fquestion" id="fquestion" action="<?php echo ONLINE_INQUIRY_URL; ?>/action/write_update.php"
        onsubmit="return fquestion_submit(this);" method="post" autocomplete="off">
        <input type="hidden" name="subject" value="Online Inquiry">

        <div class="modern-input-group">
            <input type="text" name="name" id="reg_name" required placeholder=" " class="modern-input">
            <label for="reg_name" class="modern-label">
                <?php echo $label_name; ?>
            </label>
            <span class="focus-border"></span>
        </div>

        <div class="modern-input-group">
            <input type="text" name="contact" id="reg_contact" required placeholder=" " class="modern-input">
            <label for="reg_contact" class="modern-label">
                <?php echo $label_phone; ?>
            </label>
            <span class="focus-border"></span>
        </div>

        <?php
        $start_content = '';
        if (isset($_GET['product_inquiry']) && $_GET['product_inquiry']) {
            $p_cat = isset($_GET['p_cat']) ? strip_tags($_GET['p_cat']) : '';
            $p_name = isset($_GET['p_name']) ? strip_tags($_GET['p_name']) : '';
            $start_content = "[제품 문의]\n";
            if ($p_cat)
                $start_content .= "카테고리: " . $p_cat . "\n";
            if ($p_name)
                $start_content .= "제품명: " . $p_name . "\n";
            $start_content .= "--------------------------------\n\n문의내용을 입력해주세요.";
        }
        ?>

        <div class="modern-input-group">
            <textarea name="content" id="reg_content" required placeholder=" " class="modern-textarea"
                rows="4"><?php echo $start_content; ?></textarea>
            <label for="reg_content" class="modern-label">
                <?php echo $label_msg; ?>
            </label>
            <span class="focus-border"></span>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn-modern-submit">
                <span>
                    <?php echo $label_submit; ?>
                </span>
                <i class="fa fa-long-arrow-right"></i>
            </button>
        </div>
    </form>
</div>

<script>
    function fquestion_submit(f) {
        if (!f.name.value) { alert("이름을 입력해주세요."); f.name.focus(); return false; }
        if (!f.contact.value) { alert("연락처를 입력해주세요."); f.contact.focus(); return false; }
        if (!f.content.value) { alert("내용을 입력해주세요."); f.content.focus(); return false; }
        return true;
    }
</script>