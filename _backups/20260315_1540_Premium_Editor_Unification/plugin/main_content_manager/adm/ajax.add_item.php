<?php
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!defined('G5_IS_ADMIN')) {
    die('접근 권한이 없습니다.');
}

$ms_id = isset($_POST['ms_id']) ? (int) $_POST['ms_id'] : 0;
$mc_id = 'new_' . time() . '_' . rand(100, 999); // Temporary ID for client-side tracking before save
$i = isset($_POST['count']) ? (int) $_POST['count'] : 0;
?>

<tr class="new_item_row">
    <td class="td_num text-center">
        <?php echo $i + 1; ?>
        <input type="hidden" name="mc_id[]" value="<?php echo $mc_id; ?>">
    </td>
    <td class="td_left" style="padding:15px;">
        <div style="display:flex; gap:20px;">
            <div style="width:200px;">
                <div style="margin-bottom:10px;">
                    <div id="mc_preview_<?php echo $mc_id; ?>"
                        style="width:100%; height:120px; background:#f5f5f5; border:1px solid #ddd; display:flex; align-items:center; justify-content:center; color:#999; font-size:12px; overflow:hidden;">
                        NO IMAGE</div>
                </div>
                <input type="hidden" name="mc_image_url[<?php echo $mc_id; ?>]" id="mc_image_url_<?php echo $mc_id; ?>"
                    value="">
                <div style="margin-top:5px; text-align:center;">
                    <button type="button" class="btn btn_02"
                        style="width:100%; padding:5px 0; font-size:12px; font-weight:bold;"
                        onclick="openUnsplashPopup('<?php echo $mc_id; ?>');">이미지 변경 / 관리</button>
                </div>
            </div>
            <div style="flex:1;">
                <div style="margin-bottom:10px; display:flex; gap:10px;">
                    <div style="flex:1;">
                        <input type="text" name="mc_subtitle[<?php echo $mc_id; ?>]" value="" class="frm_input"
                            style="width:100%; font-size:12px; color:#666;" placeholder="아이템 소제목 (Subtitle)">
                    </div>
                    <div style="width:100px;">
                        <input type="text" name="mc_tag[<?php echo $mc_id; ?>]" value="" class="frm_input"
                            style="width:100%; font-size:12px; text-align:center;" placeholder="태그 (Tag)">
                    </div>
                </div>
                <div style="margin-bottom:10px;">
                    <input type="text" name="mc_title[<?php echo $mc_id; ?>]" value="" class="frm_input"
                        style="width:100%; font-weight:bold;" placeholder="아이템 제목 (Main Title)">
                </div>
                <!-- Simple Style Editor Toolbar -->
                <div class="mc_editor_toolbar" style="margin-bottom:5px; display:flex; gap:5px; align-items:center;">
                    <span style="font-size:11px; color:#888; margin-right:5px;">스타일:</span>
                    <button type="button" class="btn btn_01" style="font-size:11px; padding:2px 5px;" onclick="apply_mc_style('<?php echo $mc_id; ?>', 'size', '1.25em')">크게</button>
                    <button type="button" class="btn btn_01" style="font-size:11px; padding:2px 5px;" onclick="apply_mc_style('<?php echo $mc_id; ?>', 'size', '0.85em')">작게</button>
                    <button type="button" class="btn btn_01" style="font-size:11px; padding:2px 5px; color:#d4af37;" onclick="apply_mc_style('<?php echo $mc_id; ?>', 'color', 'var(--color-accent-gold)')">골드</button>
                    <button type="button" class="btn btn_01" style="font-size:11px; padding:2px 5px; color:#ff3b30;" onclick="apply_mc_style('<?php echo $mc_id; ?>', 'color', '#ff3b30')">레드</button>
                    <button type="button" class="btn btn_01" style="font-size:11px; padding:2px 5px;" onclick="apply_mc_style('<?php echo $mc_id; ?>', 'bold', '')">두껍게</button>
                    <button type="button" class="btn btn_01" style="font-size:11px; padding:2px 5px;" onclick="apply_mc_style('<?php echo $mc_id; ?>', 'reset', '')">초기화</button>
                </div>
                <textarea name="mc_desc[<?php echo $mc_id; ?>]" id="mc_desc_<?php echo $mc_id; ?>" class="frm_input"
                    style="width:100%; height:100px; padding:10px; box-sizing:border-box;"
                    placeholder="아이템 상세 설명"></textarea>
            </div>
        </div>
    </td>
    <td class="td_left" style="width:250px;">
        <div style="margin-bottom:10px;">
            <label style="font-size:11px; color:#888;">연결 링크</label>
            <input type="text" name="mc_link[<?php echo $mc_id; ?>]" value="" class="frm_input" style="width:100%;">
        </div>
        <div style="margin-bottom:10px;">
            <label style="font-size:11px; color:#888;">버튼 텍스트</label>
            <input type="text" name="mc_link_text[<?php echo $mc_id; ?>]" value="" class="frm_input" style="width:100%;" placeholder="기본값 (자세히보기)">
        </div>
        <div>
            <label style="font-size:11px; color:#888;">타겟</label>
            <select name="mc_target[<?php echo $mc_id; ?>]" class="frm_input" style="width:100%;">
                <option value="">현재창</option>
                <option value="_blank">새창</option>
            </select>
        </div>
        <div style="margin-top:20px; text-align:right;">
            <button type="button" class="btn btn_02 btn_del_item" style="font-size:11px; color:red;">항목 삭제</button>
        </div>
    </td>
</tr>