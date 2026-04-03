<?php
$sub_menu = "950200";
include_once("./_common.php");
define("G5_IS_ADMIN", true);
include_once(G5_ADMIN_PATH . "/admin.lib.php");
include_once(G5_PLUGIN_PATH . "/sub_design/lib/design.lib.php");

auth_check_menu($auth, $sub_menu, "w");

$sd_id = isset($_GET["sd_id"]) ? clean_xss_tags($_GET["sd_id"]) : "";
$w = isset($_GET["w"]) ? clean_xss_tags($_GET["w"]) : "";

$sd = array(
    "sd_id" => "",
    "sd_theme" => "",
    "sd_lang" => "kr",
    "sd_skin" => "standard",
    "sd_layout" => "full"
);

if ($w == "u" && $sd_id) {
    $sd = sql_fetch(" SELECT * FROM " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " WHERE sd_id = '$sd_id' ");
    if (!$sd) {
        alert("존재하지 않는 서브 디자인 그룹입니다.");
    }
}

$g5["title"] = ($w == "u") ? "서브 디자인 수정" : "서브 디자인 추가";
include_once(G5_ADMIN_PATH . "/admin.head.php");
?>

<style>
    /* Image Management Column Styling */
    .visual-preview-box { position: relative; width: 140px; height: 80px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden; background: #f1f1f1; margin-bottom: 8px; }
    .visual-preview-box img { width: 100%; height: 100%; object-fit: cover; }
    .btn-img-manage { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: #34495e; color: #fff; border: none; border-radius: 4px; font-size: 11px; font-weight: 700; cursor: pointer; transition: background 0.2s; }
    .btn-img-manage:hover { background: #2c3e50; }
    .btn-url-remove { padding: 6px; background: #fff; border: 1px solid #ddd; border-radius: 4px; cursor: pointer; color: #e74c3c; }
    .btn-url-remove:hover { border-color: #e74c3c; }
</style>

<form name="fsubdesign" id="fsubdesign" action="./update.php" onsubmit="return fsubmit(this);" method="post" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="old_sd_id" value="<?php echo $sd_id; ?>">
    <input type="hidden" name="token" value="<?php echo get_admin_token(); ?>">

    <section id="group_config" class="tbl_frm01 tbl_wrap">
        <table>
            <caption>그룹 설정</caption>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row">설정 대상 (Theme & Lang)</th>
                    <td>
                        <?php 
                        // parse id to parts for default values if editing
                        $sel_custom = "";
                        if($w == "u" && $sd["sd_id"]) {
                             $parts = explode("_", $sd["sd_id"]);
                             if(count($parts) > 1) {
                                  $last = end($parts);
                                  if(in_array($last, array("en", "jp", "cn", "kr"))) array_pop($parts);
                                  if(count($parts) > 1) $sel_custom = array_pop($parts);
                             }
                        }

                        echo get_theme_lang_select_ui(array(
                            "prefix" => "sd_",
                            "theme" => $sd["sd_theme"],
                            "lang" => $sd["sd_lang"],
                            "custom" => $sel_custom,
                            "id" => $sd["sd_id"]
                        )); 
                        ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">레이아웃 선택</th>
                    <td>
                        <?php 
                        echo get_layout_select_ui(array(
                            "name" => "sd_layout",
                            "selected" => $sd["sd_layout"]
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">스킨 선택</th>
                    <td>
                        <?php 
                        echo get_skin_select_ui(array(
                            "name" => "sd_skin",
                            "selected" => $sd["sd_skin"],
                            "skins_dir" => G5_PLUGIN_PATH . "/sub_design/skins",
                            "priority" => array("standard", "cinema", "works_dark")
                        ));
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    <div class="local_desc01 local_desc" style="margin-top:30px;">
        <p>선택한 언어의 메뉴 목록입니다. 각 메뉴별 서브페이지 비주얼을 구성하세요.</p>
    </div>

    <div class="tbl_head01 tbl_wrap" style="width:100%; max-width:100%;">
        <table style="width:100%;">
            <caption>메뉴별 상세 설정</caption>
            <colgroup>
                <col width="100">
                <col width="150">
                <col width="250">
                <col>
                <col width="550">
            </colgroup>
            <thead>
                <tr>
                    <th scope="col">메뉴코드</th>
                    <th scope="col">메뉴명</th>
                    <th scope="col">메인 문구</th>
                    <th scope="col">서브 문구</th>
                    <th scope="col">배경 이미지</th>
                </tr>
            </thead>
            <tbody id="menu_list_body">
                <!-- Dynamic Content via JS -->
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="저장하기" class="btn_submit">
        <button type="button" class="btn btn_03" style="background:#3498db; color:#fff; border:none;" onclick="view_preview()">실시간 미리보기</button>
        <a href="./list.php" class="btn btn_02">목록으로</a>
    </div>
</form>

<div id="unsplash_modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:9999;">
    <div id="unsplash_modal_content" style="position:relative; width:98%; height:96%; margin:1% auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow: 0 0 40px rgba(0,0,0,0.6);">
        <button type="button" onclick="closeUnsplashModal()" style="position:absolute; top:20px; right:20px; width:44px; height:44px; border:none; background:#fff; border-radius:50%; font-size:28px; cursor:pointer; color:#333; z-index:10001; box-shadow: 0 4px 15px rgba(0,0,0,0.3); line-height:44px; text-align:center; padding:0;">&times;</button>
        <iframe id="unsplash_iframe" name="unsplash_iframe" src="" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<!-- Preview Modal -->
<div id="preview_modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); z-index:10000;">
    <div style="position:relative; width:98%; height:96%; margin:1% auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow: 0 0 50px rgba(0,0,0,0.8);">
        <button type="button" onclick="closePreview()" style="position:absolute; top:20px; right:20px; width:44px; height:44px; border:none; background:#fff; border-radius:50%; font-size:28px; cursor:pointer; color:#333; z-index:10001; box-shadow: 0 4px 15px rgba(0,0,0,0.3); line-height:44px; text-align:center; padding:0;">&times;</button>
        <iframe id="preview_iframe" name="preview_iframe" src="" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<script>
    // Standard ID Generator bridge
    window.sync_menu_table_info = function() {
        var lang = $("#sd_lang").val();
        var sd_id = $("#sd_id").val();
        if(sd_id) loadMenuList(lang, sd_id);
    };

    function loadMenuList(lang, sd_id) {
        $.post("./ajax.load_menus.php", { lang: lang, sd_id: sd_id }, function (html) {
            $("#menu_list_body").html(html);
        });
    }

    var currentTargetIdx = null;
    function openImageManager(idx) {
        currentTargetIdx = idx;
        var skin = $("input[name='sd_skin']:checked").val();
        
        var dims = { "standard": { w: 1920, h: 450 }, "cinema": { w: 1920, h: 1080 }, "works_dark": { w: 1920, h: 800 }, "minimal": { w: 1920, h: 600 }, "instinct": { w: 500, h: 500 } };
        var w = dims[skin] ? dims[skin].w : 1920;
        var h = dims[skin] ? dims[skin].h : 600;

        var url = "<?php echo G5_PLUGIN_URL; ?>/main_image_manager/adm/image_manager.php?w=" + w + "&h=" + h + "&v=" + Date.now();
        document.getElementById("unsplash_iframe").src = url;
        document.getElementById("unsplash_modal").style.display = "flex";
    }

    function closeUnsplashModal() {
        document.getElementById("unsplash_modal").style.display = "none";
        document.getElementById("unsplash_iframe").src = "";
    }

    function receiveImageUrl(url) {
        if (currentTargetIdx !== null) {
            $("#sd_visual_url_" + currentTargetIdx).val(url);
            $("#preview_" + currentTargetIdx).html('<img src="' + url + '">');
        }
        closeUnsplashModal();
    }
    window.receiveUnsplashUrl = receiveImageUrl;

    function removeUrl(idx) {
        $("#sd_visual_url_" + idx).val("");
        $("#preview_" + idx).html('<div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#ccc; font-size:20px;"><i class="fa fa-picture-o"></i></div>');
    }

    $(function () {
        if ($("#sd_id").val() == "") {
            generate_sd_id();
        } else {
            loadMenuList($("#sd_lang").val(), $("#sd_id").val());
        }
    });

    function view_preview() {
        var skin = $("input[name='sd_skin']:checked").val();
        var main_text = $("input[name='sd_main_text[]']").first().val() || "SAMPLE TITLE";
        var sub_text = $("input[name='sd_sub_text[]']").first().val() || "Sample Subtitle Text";
        var visual_url = $("input[name='sd_visual_url[]']").first().val();

        var query = "skin=" + skin + "&main_text=" + encodeURIComponent(main_text) + "&sub_text=" + encodeURIComponent(sub_text) + "&visual_url=" + encodeURIComponent(visual_url);
        document.getElementById("preview_iframe").src = "./preview.php?" + query;
        $("#preview_modal").fadeIn(200);
    }

    function closePreview() {
        $("#preview_modal").fadeOut(200);
        document.getElementById("preview_iframe").src = "";
    }

    function fsubmit(f) {
        if (!f.sd_id.value) { alert("테마를 선택해주세요."); return false; }
        return true;
    }
</script>

<?php
include_once(G5_ADMIN_PATH . "/admin.tail.php");
?>