<?php
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!defined('G5_IS_ADMIN')) {
    die('접근 권한이 없습니다.');
}

$edit_style = isset($_POST['style']) ? $_POST['style'] : '';
if (!$edit_style) {
    die('스타일 정보가 없습니다.');
}

// 다음 정렬 순서 구하기
$row = sql_fetch(" select max(mc_sort) as max_sort from g5_plugin_main_content where mc_style = '{$edit_style}' ");
$next_sort = $row['max_sort'] + 1;

// DB에 새로운 행 추가
$sql = " INSERT INTO `g5_plugin_main_content` SET mc_style = '{$edit_style}', mc_sort = '{$next_sort}' ";
sql_query($sql);
$mc_id = sql_insert_id();

?>

<tr class="bg0 new_row">
    <td class="td_num">
        <?php echo $next_sort; ?>
        <input type="hidden" name="mc_id[<?php echo $mc_id; ?>]" value="<?php echo $mc_id; ?>">
    </td>
    <td class="td_left" style="padding:15px;">
        <!-- 이미지 프리뷰 및 업로드 -->
        <div style="border:1px solid #eee; padding:10px; background:#fff; margin-bottom:10px;">
            <div class="old_img_box" style="margin-bottom:5px;">
                <span style="font-size:11px; color:#888;">[이미지 없음]</span>
            </div>
            <div style="margin-bottom:5px;">
                <input type="file" name="mc_image[<?php echo $mc_id; ?>]" class="frm_input" style="width:100%;">
            </div>
            <div style="display:flex; align-items:center; gap:5px; margin-bottom:5px;">
                <input type="text" name="mc_image_url[<?php echo $mc_id; ?>]" value="" class="frm_input"
                    placeholder="이미지 URL (직접 입력 또는 Unsplash 검색)" style="flex:1;">
                <button type="button" class="btn btn_02" onclick="openUnsplashSearch(this)"
                    style="white-space:nowrap; flex-shrink:0;">이미지 검색</button>
            </div>
            <div class="params_box" style="margin-top:5px; display:none;">
                <img src="" class="preview_thumb" style="max-height:150px; width:auto; border:1px solid #ddd;">
                <button type="button" onclick="removeUnsplashImage(this)"
                    style="display:block; margin-top:5px; font-size:11px; color:red; border:none; background:none; cursor:pointer;">[x]
                    취소</button>
            </div>
        </div>

        <!-- 텍스트 입력 -->
        <table class="box_tbl" style="width:100%;">
            <tr>
                <th style="width:60px; font-size:11px;">Title</th>
                <td><textarea name="mc_title[<?php echo $mc_id; ?>]" class="frm_input full_input" rows="2"></textarea>
                </td>
            </tr>
            <tr>
                <th style="width:60px; font-size:11px;">Desc</th>
                <td><textarea name="mc_desc[<?php echo $mc_id; ?>]" class="frm_input full_input mc_desc_textarea"
                        rows="3" maxlength="500"></textarea>
                    <div
                        style="font-size:11px; color:#888; margin-top:3px; display:flex; justify-content:space-between;">
                        <span>* 설명부분은 500자 이내로 작성해 주세요.</span>
                        <span class="char_count"><strong>0</strong> / 500자</span>
                    </div>
                </td>
            </tr>
        </table>
    </td>
    <td class="td_center" style="vertical-align:top; padding-top:25px;">
        <input type="text" name="mc_link[<?php echo $mc_id; ?>]" value="" class="frm_input" size="30"
            placeholder="Link URL" style="width:100%; margin-bottom:5px;">
        <select name="mc_target[<?php echo $mc_id; ?>]" class="frm_input" style="width:100%;">
            <option value="">현재창</option>
            <option value="_blank">새창</option>
        </select>

        <div style="margin-top:20px; text-align:right;">
            <button type="button" class="btn btn_02 btn_del_ajax" data-id="<?php echo $mc_id; ?>"> 항목 삭제 </button>
        </div>
    </td>
</tr>