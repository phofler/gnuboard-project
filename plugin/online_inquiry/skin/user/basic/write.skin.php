<?php
if (!defined('_GNUBOARD_'))
    exit;
// $skin_url, $skin_path 는 form.php 에서 정의됨
?>

<div class="online_inquiry_wrap">
    <?php if ($page_subject) { ?>
        <h2 class="page_title"><?php echo $page_subject; ?></h2>
    <?php } ?>

    <?php if ($page_content) { ?>
        <div class="page_content" style="margin-bottom:30px;">
            <?php echo $page_content; ?>
        </div>
    <?php } ?>

    <form name="fquestion" id="fquestion" action="<?php echo ONLINE_INQUIRY_URL; ?>/action/write_update.php"
        onsubmit="return fquestion_submit(this);" method="post" autocomplete="off">
        <input type="hidden" name="theme" value="<?php echo isset($theme) ? $theme : ''; ?>">
        <input type="hidden" name="lang" value="<?php echo isset($lang) ? $lang : ''; ?>">

        <table class="tbl_input">
            <caption>온라인 문의 입력</caption>
            <colgroup>
                <col class="grid_3">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row"><label for="reg_name"><?php echo $label_name; ?><strong
                                class="sound_only">필수</strong></label></th>
                    <td><input type="text" name="name" id="reg_name" required class="frm_input full_input" size="50"
                            placeholder="<?php echo $label_name; ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="reg_contact"><?php echo $label_phone; ?><strong
                                class="sound_only">필수</strong></label></th>
                    <td><input type="text" name="contact" id="reg_contact" required class="frm_input full_input"
                            size="50" placeholder="<?php echo $label_phone; ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="reg_email">이메일</label></th>
                    <td><input type="text" name="email" id="reg_email" class="frm_input full_input" size="50"
                            placeholder="이메일 (선택)"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="reg_subject">제목<strong class="sound_only">필수</strong></label></th>
                    <td><input type="text" name="subject" id="reg_subject" required class="frm_input full_input"
                            size="50" placeholder="제목"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="reg_content"><?php echo $label_msg; ?><strong
                                class="sound_only">필수</strong></label></th>
                    <td><textarea name="content" id="reg_content" required class="frm_input"
                            placeholder="<?php echo $label_msg; ?>"></textarea></td>
                </tr>
            </tbody>
        </table>

        <div class="btn_confirm">
            <input type="submit" value="<?php echo $label_submit; ?>" class="btn_submit">
        </div>
    </form>
</div>

<script>
    function fquestion_submit(f) {
        // 추가적인 유효성 검사 로직 필요 시 여기에 작성
        return true;
    }
</script>