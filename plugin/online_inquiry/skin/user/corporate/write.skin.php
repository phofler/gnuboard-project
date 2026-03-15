<?php
if (!defined('_GNUBOARD_'))
    exit;
// Corporate Theme Style Skin for Online Inquiry Plugin

// Corporate Theme Style Skin for Online Inquiry Plugin
include_once(ONLINE_INQUIRY_PATH . '/skin.head.php');
?>

<div class="inquiry-form corporate-inquiry-skin">
    <!-- Progress Bar -->
    <div class="inquiry-steps-container">
        <div class="step-item active" id="step-1-indicator">
            <div class="step-dot">1</div>
            <div class="step-label">Category</div>
        </div>
        <div class="step-item" id="step-2-indicator">
            <div class="step-dot">2</div>
            <div class="step-label">Basic info</div>
        </div>
        <div class="step-item" id="step-3-indicator">
            <div class="step-dot">3</div>
            <div class="step-label">Message</div>
        </div>
    </div>

    <form name="fquestion" id="fquestion" action="<?php echo ONLINE_INQUIRY_URL; ?>/action/write_update.php"
        onsubmit="return fquestion_submit(this);" method="post" autocomplete="off">

        <!-- STAGE 1: Category Selection -->
        <div class="form-stage active" id="stage-1">
            <h3 class="stage-title">Select Category</h3>
            <div class="form-group" style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                <label class="form-control" style="display:flex; align-items:center; cursor:pointer;">
                    <input type="radio" name="iq_type" value="General" checked
                        style="width:20px; height:20px; margin-right:10px;"> General Inquiry
                </label>
                <label class="form-control" style="display:flex; align-items:center; cursor:pointer;">
                    <input type="radio" name="iq_type" value="Partnership"
                        style="width:20px; height:20px; margin-right:10px;"> Partnership
                </label>
                <label class="form-control" style="display:flex; align-items:center; cursor:pointer;">
                    <input type="radio" name="iq_type" value="Recruit"
                        style="width:20px; height:20px; margin-right:10px;"> Recruitment
                </label>
                <label class="form-control" style="display:flex; align-items:center; cursor:pointer;">
                    <input type="radio" name="iq_type" value="Other"
                        style="width:20px; height:20px; margin-right:10px;"> Other
                </label>
            </div>
            <div class="btn-group-nav">
                <button type="button" class="btn-luxury btn-next" onclick="moveStage(2)">Next Step</button>
            </div>
        </div>

        <!-- STAGE 2: Basic Info -->
        <div class="form-stage" id="stage-2">
            <h3 class="stage-title">Basic Information</h3>
            <div class="form-group">
                <input type="text" class="form-control" name="name" id="reg_name" required
                    placeholder="<?php echo $label_name; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="contact" id="reg_contact" required
                    placeholder="<?php echo $label_phone; ?>">
            </div>
            <div class="btn-group-nav">
                <button type="button" class="btn-prev" onclick="moveStage(1)">Back</button>
                <button type="button" class="btn-luxury btn-next" onclick="moveStage(3)">Next Step</button>
            </div>
        </div>

        <!-- STAGE 3: Content & Consent -->
        <div class="form-stage" id="stage-3">
            <h3 class="stage-title">Inquiry Details</h3>
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
                    placeholder="<?php echo $label_msg; ?>"><?php echo $start_content; ?></textarea>
            </div>

            <!-- Privacy Consent -->
            <div class="consent-box">
                개인정보 수집 및 이용에 동의합니다. (문의 처리를 위한 목적으로만 사용됩니다.)
                <label class="consent-check-wrap">
                    <input type="checkbox" name="agree" id="agree" required>
                    동의함 (Agree)
                </label>
            </div>

            <input type="hidden" name="subject" value="Online Inquiry">

            <div class="btn-group-nav">
                <button type="button" class="btn-prev" onclick="moveStage(2)">Back</button>
                <button type="submit" class="btn-luxury"><?php echo $label_submit; ?></button>
            </div>
        </div>
    </form>
</div>

<script>
    function moveStage(stageNum) {
        // Validation for each stage
        if (stageNum == 2) {
            // No validation for stage 1 (just radio)
        } else if (stageNum == 3) {
            if (!document.getElementById('reg_name').value) {
                alert("이름을 입력해주세요.");
                document.getElementById('reg_name').focus();
                return;
            }
            if (!document.getElementById('reg_contact').value) {
                alert("연락처를 입력해주세요.");
                document.getElementById('reg_contact').focus();
                return;
            }
        }

        // 1. Hide all stages
        document.querySelectorAll('.form-stage').forEach(stage => stage.classList.remove('active'));
        // 2. Show target stage
        document.getElementById('stage-' + stageNum).classList.add('active');

        // 3. Update indicators
        document.querySelectorAll('.step-item').forEach((item, idx) => {
            item.classList.remove('active', 'completed');
            if (idx + 1 < stageNum) item.classList.add('completed');
            if (idx + 1 == stageNum) item.classList.add('active');
        });

        // Scroll to top of form
        document.querySelector('.inquiry-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function fquestion_submit(f) {
        if (!f.name.value) {
            alert("이름을 입력해주세요.");
            moveStage(2);
            f.name.focus();
            return false;
        }
        if (!f.contact.value) {
            alert("연락처를 입력해주세요.");
            moveStage(2);
            f.contact.focus();
            return false;
        }
        if (!f.content.value) {
            alert("내용을 입력해주세요.");
            moveStage(3);
            f.content.focus();
            return false;
        }
        if (!f.agree.checked) {
            alert("개인정보 수집에 동의해주세요.");
            moveStage(3);
            f.agree.focus();
            return false;
        }

        // Add inquiry type to content
        const iqType = document.querySelector('input[name="iq_type"]:checked').value;
        f.content.value = "[유형: " + iqType + "]\n" + f.content.value;

        return true;
    }
</script>