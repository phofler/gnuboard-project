<?php
if (!defined('_GNUBOARD_'))
    exit;
// Corporate Theme Style Skin for Online Inquiry Plugin
?>
<div class="inquiry-form corporate-inquiry-skin">
    <form name="fquestion" id="fquestion" action="<?php echo ONLINE_INQUIRY_URL; ?>/action/write_update.php"
        onsubmit="return fquestion_submit(this);" method="post" autocomplete="off">
        <div class="form-group">
            <input type="text" class="form-control" name="name" id="reg_name" required placeholder="Name">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="contact" id="reg_contact" required
                placeholder="Contact Number">
        </div>
        <!-- Email field added for completeness although not in original screenshot, keeping hidden or minimal if desired. Original didn't have it visible? Let's check. 
             Original code had: Name, Contact, Message. No Email. I'll stick to original inputs but keep hidden email or just omit. 
             Wait, the plugin logic MIGHT expect email. write_update.php says email is optional. I will omit it to match design exactly. -->
        <?php
        // [Inquiry Pre-fill Logic]
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
        <div class="form-group">
            <textarea class="form-control" name="content" id="reg_content" rows="5" required
                placeholder="Message"><?php echo $start_content; ?></textarea>
            <!-- Mapping 'content' to 'Message' -->
        </div>

        <!-- Hidden required fields by plugin logic if any? Subject is required by write_update.php. 
             I must provide a subject. I'll make it a hidden field "Online Inquiry". -->
        <input type="hidden" name="subject" value="Online Inquiry">

        <button type="submit" class="btn-luxury">SEND MESSAGE</button>
    </form>
</div>

<script>
    function fquestion_submit(f) {
        if (!f.name.value) {
            alert("이름을 입력해주세요.");
            f.name.focus();
            return false;
        }
        if (!f.contact.value) {
            alert("연락처를 입력해주세요.");
            f.contact.focus();
            return false;
        }
        if (!f.content.value) {
            alert("내용을 입력해주세요.");
            f.content.focus();
            return false;
        }
        return true;
    }
</script>