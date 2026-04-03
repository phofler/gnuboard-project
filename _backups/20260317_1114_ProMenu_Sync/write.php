<?php
$sub_menu = '950200';
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');
include_once(G5_LIB_PATH . '/premium_module.lib.php');
include_once(G5_PLUGIN_PATH . '/sub_design/lib/design.lib.php');

auth_check_menu($auth, $sub_menu, 'w');

$w = isset($_GET['w']) ? clean_xss_tags($_GET['w']) : '';
$sd_id = isset($_GET['sd_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['sd_id']) : '';

$row = array('sd_id' => '', 'sd_theme' => '', 'sd_lang' => 'kr', 'sd_skin' => 'standard', 'sd_layout' => 'full', 'sd_breadcrumb' => 0, 'sd_breadcrumb_skin' => 'dropdown');
if ($w == 'u') {
    $db_row = sql_fetch(" SELECT * FROM " . G5_TABLE_PREFIX . "plugin_sub_design_groups WHERE sd_id = '{$sd_id}' ");
    if (!$db_row['sd_id']) alert('존재하지 않는 설정입니다.');
    $row = array_merge($row, (array)$db_row);
}

$g5['title'] = '서브 디자인 ' . ($w == 'u' ? '수정' : '추가');
include_once(G5_ADMIN_PATH . '/admin.head.php');
?>

<form name="fsubdesign" id="fsubdesign" action="./update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="old_sd_id" value="<?php echo $row['sd_id']; ?>">

    <div class="tbl_frm01 tbl_wrap">
        <table style="width:100%;">
            <caption><?php echo $g5['title']; ?></caption>
            <colgroup><col width="180"><col></colgroup>
            <tbody>
                <tr>
                    <th scope="row">설정 대상 (Theme & Lang)</th>
                    <td><?php
                        $themes = get_premium_themes();
                        $p = parse_premium_id($row['sd_id'], $themes);
                        echo get_theme_lang_select_ui(array("prefix" => "sd_", "theme" => $row['sd_theme'] ?: $p['theme'], "lang" => $row['sd_lang'] ?: ($p['lang'] ?: 'kr'), "custom" => $p['custom'], "id" => $row['sd_id']));
                    ?></td>
                </tr>
                <tr>
                    <th scope="row">레이아웃 선택</th>
                    <td><?php echo get_layout_select_ui(array("name" => "sd_layout", "selected" => $row['sd_layout'])); ?></td>
                </tr>
                <tr>
                    <th scope="row">스킨 선택</th>
                    <td><?php echo get_skin_select_ui(array("name" => "sd_skin", "selected" => $row['sd_skin'], "skins_dir" => G5_PLUGIN_PATH . '/sub_design/skins', "priority" => array("standard", "cinema", "works_dark", "instinct", "minimal"))); ?></td>
                </tr>
                <tr>
                    <th scope="row">브레드크럼 (LNB) 설정</th>
                    <td><?php echo get_breadcrumb_select_ui(array("active" => $row['sd_breadcrumb'], "selected_skin" => $row['sd_breadcrumb_skin'], "skins_dir" => G5_PLUGIN_PATH . '/sub_design/breadcrumb_skins')); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="local_desc01 local_desc" style="margin-top:30px;"><p>선택한 언어의 메뉴 목록입니다. 각 메뉴별 서브 비주얼을 구성하세요.</p></div>

    <div class="tbl_head01 tbl_wrap" id="menu_config_area">
        <table style="width:100% !important; border-collapse: collapse; table-layout: fixed;">
            <thead>
                <tr>
                    <th scope="col" style="width:80px;">코드</th>
                    <th scope="col" style="width:180px;">메뉴 명</th>
                    <th scope="col">메인 텍스트 (Main Text)</th>
                    <th scope="col">서브 텍스트 / 태그 (Sub Text / Tag)</th>
                    <th scope="col" style="width:150px;">이미지</th>
                </tr>
            </thead>
            <tbody id="menu_list_tbody">
                <tr><td colspan="5" style="padding:50px; text-align:center; color:#999;">언어와 테마를 선택하면 메뉴 목록이 나타납니다...</td></tr>
            </tbody>
        </table>
    </div>

    <div class="btn_fixed_top">
        <a href="./list.php" class="btn btn_02">목록</a>
        <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
    </div>
</form>

<style>
/* Image Manager Modal Styles */
#unsplash_modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 9999; justify-content: center; align-items: center; }
#unsplash_modal_content { width: 98%; max-width: 1800px; height: 96%; max-height: 1200px; background: #fff; position: relative; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); margin: 1% auto; }
#unsplash_iframe { width: 100%; height: 100%; border: none; }
.close-modal { position: absolute; top: 15px; right: 20px; font-size: 24px; color: #333; cursor: pointer; z-index: 10000; width: 35px; height: 35px; line-height: 35px; text-align: center; background: rgba(255, 255, 255, 0.9); border-radius: 50%; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
</style>

<div id="unsplash_modal">
    <div id="unsplash_modal_content">
        <span class="close-modal" onclick="closeUnsplashModal()">&times;</span>
        <iframe id="unsplash_iframe" src=""></iframe>
    </div>
</div>

<script>
$(function () {
    function load_menu_list() {
        var sd_id = $("input[name='sd_id']").val();
        var lang = $("#sd_lang").val();
        if (!sd_id) {
            $("#menu_list_tbody").html('<tr><td colspan="5" style="padding:50px; text-align:center; color:#999;">테마와 언어를 먼저 선택해주세요.</td></tr>');
            return;
        }
        $.post("./ajax.load_menus.php", { sd_id: sd_id, lang: lang, _t: new Date().getTime() }, function (data) {
            $("#menu_list_tbody").html(data);
        });
    }

    $("#sd_theme, #sd_lang, #sd_id_custom").on("change keyup", function () {
        setTimeout(load_menu_list, 100);
    });

    if (typeof generate_sd_id === "function") generate_sd_id();
    load_menu_list();
});

function openImageManager(index) {
    var url = "../../main_image_manager/adm/image_manager.php?mi_id=" + index + "&w=1920&h=450&v=" + Date.now();
    document.getElementById("unsplash_iframe").src = url;
    document.getElementById("unsplash_modal").style.display = "flex";
}

function closeUnsplashModal() {
    document.getElementById("unsplash_modal").style.display = "none";
    document.getElementById("unsplash_iframe").src = "";
}

function receiveImageUrl(url, index) {
    if (index !== undefined) {
        $("#sd_visual_url_" + index).val(url);
        var preview_box = $("#preview_" + index);
        preview_box.html('<img src="' + url + '" style="height:50px; border:1px solid #ddd; object-fit:cover; width:80px;">');
        closeUnsplashModal();
    }
}

function removeUrl(index) {
    if (confirm('이미지를 삭제하시겠습니까?')) {
        $("#sd_visual_url_" + index).val('');
        $("#preview_" + index).html('<div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#ccc; font-size:16px;"><i class="fa fa-picture-o"></i></div>');
    }
}
</script>

<?php include_once(G5_ADMIN_PATH . '/admin.tail.php'); ?>