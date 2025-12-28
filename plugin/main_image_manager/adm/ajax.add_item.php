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
$row = sql_fetch(" select max(mi_sort) as max_sort from g5_plugin_main_image_add where mi_style = '{$edit_style}' ");
$next_sort = $row['max_sort'] + 1;

// DB에 새로운 행 추가
$sql = " INSERT INTO `g5_plugin_main_image_add` SET mi_style = '{$edit_style}', mi_sort = '{$next_sort}' ";
sql_query($sql);
$mi_id = sql_insert_id();

// 현재 행의 인덱스(순서)는 프론트엔드에서 계산된 값을 가져오거나, 
// 단순히 DB ID를 사용하여 유니크하게 처리해야 함. 
// 여기서는 프론트엔드에서 테이블 행 개수를 기반으로 인덱스를 관리한다고 가정하고,
// 단순히 새로 추가된 DB 데이터 기반으로 HTML만 리턴함. 
// input name의 인덱스(mi_id[i])가 0부터 순차적일 필요는 없으나,
// list.php는 for loop $i를 사용했음. 
// AJAX로 추가될 때는 기존 $i와 충돌하지 않는 유니크한 키가 필요함.
// 가장 쉬운 방법은 timestamp 등을 사용하는 것이나, 여기서는 mi_id를 키로 사용하도록 제안.
// 하지만 list.php의 update.php 로직이 $i (순차 인덱스)를 기반으로 배열을 받는지 확인 필요.
// list.php: name="mi_id[<?php echo $i; ?>]"
// update.php: $_POST['mi_id'] 배열을 foreach로 돌림. 키값($i)은 중요하지 않음.
// 따라서 여기서 $i 대신 $mi_id를 키로 사용해도 무방함.

// mi_id를 키로 사용함.
?>

<tr class="bg0 new_row">
    <td class="td_num">
        <?php echo $next_sort; ?>
        <input type="hidden" name="mi_id[<?php echo $mi_id; ?>]" value="<?php echo $mi_id; ?>">
    </td>
    <td class="td_left" style="padding:15px;">
        <!-- 이미지 프리뷰 및 업로드 -->
        <div style="border:1px solid #eee; padding:10px; background:#fff; margin-bottom:10px;">
            <div style="margin-bottom:5px;">
                <span style="font-size:11px; color:#888;">[이미지 없음]</span>
            </div>
            <div style="display:flex; align-items:center; gap:5px; margin-bottom:5px;">
                <input type="file" name="mi_image[<?php echo $mi_id; ?>]" class="frm_input" style="width:100%;">
                <button type="button" class="btn btn_02" onclick="openUnsplashSearch(this)"
                    style="white-space:nowrap; flex-shrink:0;">이미지 검색</button>
            </div>
            <div>
                <input type="text" name="mi_image_url[<?php echo $mi_id; ?>]" value="" class="frm_input full_input"
                    placeholder="이미지 URL (직접 입력 또는 Unsplash 검색)" style="width:100%;">
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
                <td><textarea name="mi_title[<?php echo $mi_id; ?>]" class="frm_input full_input" rows="2"></textarea>
                </td>
            </tr>
            <tr>
                <th style="width:60px; font-size:11px;">Desc</th>
                <td><textarea name="mi_desc[<?php echo $mi_id; ?>]" class="frm_input full_input mi_desc_textarea"
                        rows="3" maxlength="80"></textarea>
                    <div
                        style="font-size:11px; color:#888; margin-top:3px; display:flex; justify-content:space-between;">
                        <span>* 설명부분은 80자 이내 (2줄 권장)로 작성해 주세요.</span>
                        <span class="char_count"><strong>0</strong> / 80자</span>
                    </div>
                </td>
            </tr>
        </table>
    </td>
    <td class="td_center" style="vertical-align:top; padding-top:25px;">
        <input type="text" name="mi_link[<?php echo $mi_id; ?>]" value="" class="frm_input" size="30"
            placeholder="Link URL" style="width:100%; margin-bottom:5px;">
        <select name="mi_target[<?php echo $mi_id; ?>]" class="frm_input" style="width:100%;">
            <option value="">현재창</option>
            <option value="_blank">새창</option>
        </select>

        <div style="margin-top:20px; text-align:right;">
            <button type="button" class="btn btn_02 btn_del_ajax" data-id="<?php echo $mi_id; ?>"> 항목 삭제 </button>
        </div>
    </td>
</tr>