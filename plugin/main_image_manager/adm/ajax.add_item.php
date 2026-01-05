<?php
define('_GNUBOARD_ADMIN_', true);
include_once('./_common.php');
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

$edit_skin = isset($_POST['skin']) ? $_POST['skin'] : 'basic';

// 권장 사이즈 계산
$w = 1920;
$h = 1080;
if ($edit_skin == 'basic') {
    $w = 640;
    $h = 960;
}
?>

<tr class="bg0 new_row">
    <td class="td_num">
        <?php echo $next_sort; ?>
        <input type="hidden" name="mi_item_id[<?php echo $mi_id; ?>]" value="<?php echo $mi_id; ?>">
    </td>
    <td class="td_left" style="padding:15px;">
        <div class="mi_preview_box" id="preview_<?php echo $mi_id; ?>" style="margin-bottom:10px; display:none;"></div>

        <input type="hidden" name="mi_image_url[<?php echo $mi_id; ?>]" id="mi_image_url_<?php echo $mi_id; ?>"
            value="">

        <div style="margin-bottom:10px;">
            <button type="button" class="btn btn_03" style="font-weight:bold; padding:8px 15px;"
                onclick="openImageManager('<?php echo $mi_id; ?>')">
                <i class="fa fa-picture-o"></i> 이미지 변경 / 관리
            </button>
        </div>

        <div style="margin-top:5px;">
            <input type="text" name="mi_title[<?php echo $mi_id; ?>]" value="" class="frm_input full_input"
                placeholder="타이틀 (Title)">
            <textarea name="mi_desc[<?php echo $mi_id; ?>]" class="frm_input full_input" style="margin-top:5px;"
                placeholder="설명 (Description)"></textarea>
            <input type="text" name="mi_link[<?php echo $mi_id; ?>]" value="" class="frm_input full_input"
                style="margin-top:5px;" placeholder="연결 링크 URL (http://...)">
        </div>
    </td>
    <td class="td_mng td_center">
        <button type="button" class="btn_02 btn_del_ajax" data-id="<?php echo $mi_id; ?>">삭제</button>
    </td>
</tr>