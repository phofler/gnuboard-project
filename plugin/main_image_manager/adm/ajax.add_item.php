<?php
define("_GNUBOARD_ADMIN_", true);
include_once("./_common.php");

$style = isset($_POST['style']) ? clean_xss_tags($_POST['style']) : '';
$skin = isset($_POST['skin']) ? clean_xss_tags($_POST['skin']) : 'basic';
$mi_id = 'new_' . time() . '_' . rand(100, 999);
?>
<tr>
    <td class="td_num">추가</td>
    <td class="td_left" style="padding:10px;">
        <div style="display:flex;">
            <div id="preview_wrap_<?php echo $mi_id; ?>" style="width:200px; margin-right:20px;">
                <div class="mi_preview_box" id="preview_<?php echo $mi_id; ?>"
                    style="width:100%; height:120px; background:#f5f5f5; border:1px solid #ddd; display:flex; align-items:center; justify-content:center; color:#999; font-size:11px; text-align:center;">
                    NO IMAGE<br><?php echo ($skin == "basic") ? "640x960" : "1920x1080"; ?>
                </div>

                <input type="hidden" name="mi_image_url[<?php echo $mi_id; ?>]"
                    id="mi_image_url_<?php echo $mi_id; ?>" value="">

                <div style="display:flex; gap:5px; margin-top:10px;">
                    <button type="button" class="btn btn_03" style="flex:1; padding:7px 0; font-size:11px;"
                        onclick="openImageManager('<?php echo $mi_id; ?>')">이미지 변경</button>
                    <button type="button" class="btn btn_02" style="flex:1; padding:7px 0; font-size:11px; background:#f1f1f1; border-color:#ccc; color:#666;"
                        onclick="clear_mi_image('<?php echo $mi_id; ?>')">이미지 삭제</button>
                </div>
            </div>
            
            <div style="flex:1;">
                <input type="text" name="mi_tag[<?php echo $mi_id; ?>]" value="" class="frm_input full_input"
                    style="margin-bottom:5px; background:#f9fafb;" placeholder="태그 (Tag - 예: NEW, NOTICE)">
                <input type="text" name="mi_title[<?php echo $mi_id; ?>]" value="" class="frm_input full_input"
                    placeholder="타이틀 (Title)">
                <input type="text" name="mi_subtitle[<?php echo $mi_id; ?>]" value="" class="frm_input full_input"
                    style="margin-top:5px;" placeholder="소제목 (Subtitle)">
                <textarea name="mi_desc[<?php echo $mi_id; ?>]" class="frm_input full_input"
                    style="margin-top:5px; height:60px;" placeholder="설명 (Description)"></textarea>
                
                <div style="display:flex; gap:5px; margin-top:5px; align-items:center;">
                    <input type="text" name="mi_btn_text[<?php echo $mi_id; ?>]" value="" class="frm_input"
                        style="width:30%;" placeholder="버튼 텍스트">
                    <input type="text" name="mi_link[<?php echo $mi_id; ?>]" value="" class="frm_input"
                        style="width:70%;" placeholder="연결 링크 URL">
                    <label style="white-space:nowrap; margin-left:5px;">
                        <input type="checkbox" name="mi_target[<?php echo $mi_id; ?>]" value="_blank"> 새 창
                    </label>
                </div>
            </div>
        </div>
    </td>
    <td class="td_mng td_center">
        <button type="button" class="btn_02" onclick="$(this).closest('tr').remove();">항목 취소</button>
    </td>
</tr>