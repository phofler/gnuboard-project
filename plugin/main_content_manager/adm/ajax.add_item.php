<?php
include_once('./_common.php');
include_once(G5_PATH . '/extend/project_ui.extend.php');
include_once(G5_PLUGIN_PATH . '/main_content_manager/lib/main_content.lib.php');

$ms_id = (int) $_POST['ms_id'];
$count = (int) $_POST['count'];
$mi_id = 'new_' . time() . '_' . ($count + 1);

$ms = sql_fetch(" select ms_skin from g5_plugin_main_content_sections where ms_id = '{$ms_id}' ");
$skin = isset($ms['ms_skin']) ? $ms['ms_skin'] : 'A';
$info = get_mc_skin_info($skin);
?>

<tr>
    <td class="td_num text-center">
        추가
        <input type="hidden" name="mc_id[]" value="<?php echo $mi_id; ?>">
    </td>
    <td class="td_left" style="padding:15px;">
        <div style="display:flex; gap:20px;">
            <div style="width:200px;">
                <div id="mc_preview_<?php echo $mi_id; ?>" class="mc-no-image-placeholder" style="width:100%; height:120px; background:#f5f5f5; border:1px solid #ddd; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#999; font-size:11px; overflow:hidden; text-align:center;">
                    NO IMAGE<br><?php echo $info['width']; ?> x <?php echo $info['height']; ?>
                </div>
                <input type="hidden" name="mc_image_url[<?php echo $mi_id; ?>]" id="mc_image_url_<?php echo $mi_id; ?>" value="">
                <div class="img-mgr-btns">
                    <button type="button" class="btn btn_03" onclick="openUnsplashPopup('<?php echo $mi_id; ?>');">이미지 변경</button>
                    <button type="button" class="btn btn_02" style="background:#f1f1f1; border-color:#ccc; color:#666;" onclick="delete_mc_image('<?php echo $mi_id; ?>');">이미지 삭제</button>
                </div>
            </div>
            <div style="flex:1;">
                <div style="margin-bottom:10px; display:flex; gap:10px;">
                    <input type="text" name="mc_subtitle[<?php echo $mi_id; ?>]" value="" class="frm_input" style="flex:1;" placeholder="소제목">
                    <input type="text" name="mc_tag[<?php echo $mi_id; ?>]" value="" class="frm_input" style="width:100px; text-align:center;" placeholder="태그">
                </div>
                <input type="text" name="mc_title[<?php echo $mi_id; ?>]" value="" class="frm_input" style="width:100%; font-weight:bold; margin-bottom:10px;" placeholder="제목">
                
                <?php
                if (function_exists('get_premium_editor_ui')) {
                    echo get_premium_editor_ui(array(
                        'id' => 'mc_desc_' . $mi_id,
                        'name' => 'mc_desc[' . $mi_id . ']',
                        'value' => '',
                        'placeholder' => '아이템 상세 설명을 입력하세요...',
                        'height' => '100px'
                    ));
                } else {
                    echo '<textarea name="mc_desc[' . $mi_id . ']" id="mc_desc_' . $mi_id . '" class="frm_input" style="width:100%; height:100px;"></textarea>';
                }
                ?>
            </div>
        </div>
    </td>
    <td class="td_left" style="width:250px;">
        <label style="font-size:11px;">연결 링크</label>
        <input type="text" name="mc_link[<?php echo $mi_id; ?>]" value="" class="frm_input" style="width:100%; margin-bottom:10px;">
        <label style="font-size:11px;">버튼 텍스트</label>
        <input type="text" name="mc_link_text[<?php echo $mi_id; ?>]" value="" class="frm_input" style="width:100%; margin-bottom:10px;" placeholder="자세히보기">
        <select name="mc_target[<?php echo $mi_id; ?>]" class="frm_input" style="width:100%;"><option value="">현재창</option><option value="_blank">새창</option></select>
        <div style="margin-top:20px; text-align:right;"><button type="button" class="btn btn_02" style="color:red;" onclick="if(confirm('삭제하시겠습니까?')) $(this).closest('tr').remove();">항목 삭제</button></div>
    </td>
</tr>