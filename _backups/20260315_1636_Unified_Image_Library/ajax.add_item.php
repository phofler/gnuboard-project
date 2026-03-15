<?php
define('_GNUBOARD_ADMIN_', true);
include_once('./_common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!defined('G5_IS_ADMIN')) {
    die('?묎렐 沅뚰븳???놁뒿?덈떎.');
}

$edit_style = isset($_POST['style']) ? $_POST['style'] : '';
if (!$edit_style) {
    die('?ㅽ????뺣낫媛 ?놁뒿?덈떎.');
}

// ?ㅼ쓬 ?뺣젹 ?쒖꽌 援ы븯湲?
$row = sql_fetch(" select max(mi_sort) as max_sort from g5_plugin_main_image_add where mi_style = '{$edit_style}' ");
$next_sort = $row['max_sort'] + 1;

// DB???덈줈????異붽?
$sql = " INSERT INTO `g5_plugin_main_image_add` SET mi_style = '{$edit_style}', mi_sort = '{$next_sort}' ";
sql_query($sql);
$mi_id = sql_insert_id();

$edit_skin = isset($_POST['skin']) ? $_POST['skin'] : 'basic';

// 沅뚯옣 ?ъ씠利?怨꾩궛
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
        <input type="hidden" name="mi_image_url[<?php echo $mi_id; ?>]" id="mi_image_url_<?php echo $mi_id; ?>"
            value="">
        <input type="hidden" name="mi_image_mobile_url[<?php echo $mi_id; ?>]" id="mi_image_mobile_url_<?php echo $mi_id; ?>"
            value="">

        <div style="display:flex; gap:10px; margin-bottom:10px;">
            <div style="flex:1;">
                <div style="font-weight:bold; margin-bottom:5px;">Desktop ?대?吏 (1920x1080)</div>
                <div class="mi_preview_box" id="preview_<?php echo $mi_id; ?>" 
                    style="width:100%; height:120px; border:1px dashed #ccc; display:flex; align-items:center; justify-content:center; color:#999;">誘몃━蹂닿린 ?놁쓬</div>
                <button type="button" class="btn btn_03" style="width:100%; margin-top:5px;"
                    onclick="openImageManager('<?php echo $mi_id; ?>', 'pc')">
                    <i class="fa fa-desktop"></i> PC ?대?吏 蹂寃?
                </button>
            </div>
            <div style="flex:1;">
                <div style="font-weight:bold; margin-bottom:5px;">Mobile ?대?吏 (640x960)</div>
                <div class="mi_preview_box" id="preview_mobile_<?php echo $mi_id; ?>" 
                    style="width:100%; height:120px; border:1px dashed #ccc; display:flex; align-items:center; justify-content:center; color:#999;">誘몃━蹂닿린 ?놁쓬</div>
                <button type="button" class="btn btn_01" style="width:100%; margin-top:5px;"
                    onclick="openImageManager('<?php echo $mi_id; ?>', 'mobile')">
                    <i class="fa fa-mobile"></i> 紐⑤컮???대?吏 蹂寃?
                </button>
            </div>
        </div>

        <div style="margin-top:5px;">
            <input type="text" name="mi_tag[<?php echo $mi_id; ?>]" value="" class="frm_input full_input"
                style="margin-bottom:5px; background:#f9fafb;" placeholder="?쒓렇 (Tag - ?? NEW, NOTICE)">
            <input type="text" name="mi_title[<?php echo $mi_id; ?>]" value="" class="frm_input full_input"
                placeholder="??댄? (Title)">
            <input type="text" name="mi_subtitle[<?php echo $mi_id; ?>]" value="" class="frm_input full_input"
                style="margin-top:5px;" placeholder="?뚯젣紐?(Subtitle)">
            <textarea name="mi_desc[<?php echo $mi_id; ?>]" class="frm_input full_input" style="margin-top:5px;"
                placeholder="?ㅻ챸 (Description)"></textarea>
            
            <div style="display:flex; gap:5px; margin-top:5px; align-items:center;">
                <input type="text" name="mi_btn_text[<?php echo $mi_id; ?>]" value="" class="frm_input"
                    style="width:30%;" placeholder="踰꾪듉 ?띿뒪??(湲곕낯: VIEW DETAILS)">
                <input type="text" name="mi_link[<?php echo $mi_id; ?>]" value="" class="frm_input"
                    style="width:70%;" placeholder="?곌껐 留곹겕 URL (http://...)">
                <label style="white-space:nowrap; margin-left:5px;">
                    <input type="checkbox" name="mi_target[<?php echo $mi_id; ?>]" value="_blank"> ??李?
                </label>
            </div>
        </div>
    </td>
    <td class="td_mng td_center">
        <button type="button" class="btn_02 btn_del_ajax" data-id="<?php echo $mi_id; ?>">??젣</button>
    </td>
</tr>
