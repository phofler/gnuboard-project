<?php
if (!defined('_GNUBOARD_'))
    exit;
// Modern Minimal Skin for Online Inquiry
include_once(ONLINE_INQUIRY_PATH . '/skin.head.php');
?>

<div class="inquiry-form modern-inquiry-skin">
    <!-- Progress Indicator -->
    <div class="modern-steps-container">
        <div class="modern-step-item active" id="m-step-1-indicator">
            <div class="modern-step-dot"></div>
            <div class="modern-step-label">Type</div>
        </div>
        <div class="modern-step-item" id="m-step-2-indicator">
            <div class="modern-step-dot"></div>
            <div class="modern-step-label">Info</div>
        </div>
        <div class="modern-step-item" id="m-step-3-indicator">
            <div class="modern-step-dot"></div>
            <div class="modern-step-label">Content</div>
        </div>
    </div>

    <form name="fquestion" id="fquestion" action="<?php echo ONLINE_INQUIRY_URL; ?>/action/write_update.php"
        onsubmit="return fquestion_submit(this);" method="post" autocomplete="off">
        <input type="hidden" name="subject" value="Online Inquiry">

        <!-- STAGE 1: Inquiry Type -->
        <div class="modern-stage active" id="m-stage-1">
            <h3 class="modern-stage-title">Select Service</h3>
            <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 40px;">
                <label class="modern-check">
                    <input type="radio" name="iq_type" value="Design" checked> Interior Design
                </label>
                <label class="modern-check">
                    <input type="radio" name="iq_type" value="Construction"> Construction
                </label>
                <label class="modern-check">
                    <input type="radio" name="iq_type" value="Branding"> Branding
                </label>
            </div>
            <div class="btn-modern-nav">
                <button type="button" class="btn-modern-next" style="width:100%" onclick="moveModernStage(2)">Next
                    Step</button>
            </div>
        </div>

        <!-- STAGE 2: Basic Info -->
        <div class="modern-stage" id="m-stage-2">
            <h3 class="modern-stage-title">Your Contact</h3>
            <div class="modern-input-group">
                <input type="text" name="name" id="reg_name" required placeholder=" " class="modern-input">
                <label for="reg_name" class="modern-label"><?php echo $label_name; ?></label>
                <span class="focus-border"></span>
            </div>

            <div class="modern-input-group">
                <input type="text" name="contact" id="reg_contact" required placeholder=" " class="modern-input">
                <label for="reg_contact" class="modern-label"><?php echo $label_phone; ?></label>
                <span class="focus-border"></span>
            </div>
            <div class="btn-modern-nav">
                <button type="button" class="btn-modern-prev" onclick="moveModernStage(1)">Back</button>
                <button type="button" class="btn-modern-next" onclick="moveModernStage(3)">Next Step</button>
            </div>
        </div>

        <!-- STAGE 3: Message & Consent -->
        <div class="modern-stage" id="m-stage-3">
            <h3 class="modern-stage-title">Message</h3>
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
                $start_content .= "--------------------------------\n\n";
            }
            ?>
            <div class="modern-input-group">
                <textarea name="content" id="reg_content" required placeholder=" " class="modern-textarea"
                    rows="4"><?php echo $start_content; ?></textarea>
                <label for="reg_content" class="modern-label"><?php echo $label_msg; ?></label>
                <span class="focus-border"></span>
            </div>

            <div class="modern-consent">
                We collect your data to handle your inquiry.
                <label class="modern-check">
                    <input type="checkbox" name="agree" id="agree" required> Agree with terms.
                </label>
            </div>

            <div class="btn-modern-nav">
                <button type="button" class="btn-modern-prev" onclick="moveModernStage(2)">Back</button>
                <button type="submit" class="btn-modern-next"
                    style="font-weight:900"><?php echo $label_submit; ?></button>
            </div>
        </div>
    </form>
</div>

<script>
    function moveModernStage(stageNum) {
        // Validation
        if (stageNum == 3) {
            if (!document.getElementById('reg_name').value) { alert("이름을 입력해주세요."); document.getElementById('reg_name').focus(); return; }
            if (!document.getElementById('reg_contact').value) { alert("연락처를 입력해주세요."); document.getElementById('reg_contact').focus(); return; }
        }

        // Switch Stage
        document.querySelectorAll('.modern-stage').forEach(s => s.classList.remove('active'));
        document.getElementById('m-stage-' + stageNum).classList.add('active');

        // Indicators
        document.querySelectorAll('.modern-step-item').forEach((item, idx) => {
            item.classList.remove('active', 'completed');
            if (idx + 1 < stageNum) item.classList.add('completed');
            if (idx + 1 == stageNum) item.classList.add('active');
        });

        // Scroll
        document.querySelector('.modern-inquiry-skin').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function fquestion_submit(f) {
        if (!f.name.value) { alert("이름을 입력해주세요."); moveModernStage(2); f.name.focus(); return false; }
        if (!f.contact.value) { alert("연락처를 입력해주세요."); moveModernStage(2); f.contact.focus(); return false; }
        if (!f.content.value) { alert("내용을 입력해주세요."); moveModernStage(3); f.content.focus(); return false; }
        if (!f.agree.checked) { alert("개인정보 수집에 동의해주세요."); moveModernStage(3); f.agree.focus(); return false; }

        const iqType = document.querySelector('input[name="iq_type"]:checked').value;
        f.content.value = "[" + iqType + " Inquiry]\n" + f.content.value;
        return true;
    }
</script>