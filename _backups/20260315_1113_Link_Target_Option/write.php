<?php
define("_GNUBOARD_ADMIN_", true);
$sub_menu = "950180";
include_once("./_common.php");
auth_check_menu($auth, $sub_menu, "w");

$w = isset($_GET["w"]) ? clean_xss_tags($_GET["w"]) : "";
$mi_id = isset($_GET["mi_id"]) ? clean_xss_tags($_GET["mi_id"]) : "";

$config_table = G5_TABLE_PREFIX . "plugin_main_image_config";

// [Auto-Migration] Add mi_effect, mi_overlay if not exists
$check_sql = "show columns from {$config_table} like 'mi_effect'";
if(!sql_fetch($check_sql)) {
    sql_query("ALTER TABLE {$config_table} ADD COLUMN mi_effect VARCHAR(20) DEFAULT 'none' AFTER mi_skin");
    sql_query("ALTER TABLE {$config_table} ADD COLUMN mi_overlay FLOAT DEFAULT 0.4 AFTER mi_effect");
}

// [Auto-Migration] Add Premium Slide Fields if not exists
$data_table_name = G5_TABLE_PREFIX . "plugin_main_image_add";
$check_sql2 = "show columns from {$data_table_name} like 'mi_tag'";
if(!sql_fetch($check_sql2)) {
    sql_query("ALTER TABLE {$data_table_name} ADD COLUMN mi_tag VARCHAR(255) DEFAULT '' AFTER mi_video");
    sql_query("ALTER TABLE {$data_table_name} ADD COLUMN mi_subtitle VARCHAR(255) DEFAULT '' AFTER mi_title");
    sql_query("ALTER TABLE {$data_table_name} ADD COLUMN mi_btn_text VARCHAR(100) DEFAULT '' AFTER mi_link");
}

if ($w == "u") {
    $g5["title"] = "메인 비주얼 수정";
    $mi_group_config = sql_fetch(" select * from {$config_table} where mi_id = '{$mi_id}' ");
    if (!$mi_group_config) {
        alert("그룹 정보를 찾을 수 없습니다.");
    }
} else {
    $g5["title"] = "메인 비주얼 추가";
    $mi_group_config = array(
        "mi_id" => "",
        "mi_theme" => "",
        "mi_lang" => "kr",
        "mi_custom" => "",
        "mi_subject" => "",
        "mi_skin" => "basic",
        "mi_effect" => "zoom",
        "mi_overlay" => 0.4
    );
}

include_once(G5_ADMIN_PATH . "/admin.head.php");

// Skin Discovery
$skins_dir = G5_PLUGIN_PATH . "/main_image_manager/skins";
$skins = array();
$skin_names_map = array(
    "basic" => "Basic (Split)",
    "full" => "Smooth Fade",
    "fade" => "Vertical Slide",
    "corporate_hero" => "Corporate Hero",
    "ultimate_hero" => "Ultimate Hero"
);
$handle = opendir($skins_dir);
if ($handle) {
    while ($file = readdir($handle)) {
        if ($file == "." || $file == "..")
            continue;
        if (is_dir($skins_dir . "/" . $file)) {
            $name = isset($skin_names_map[$file]) ? $skin_names_map[$file] : ucfirst($file);
            $skins[$file] = $name;
        }
    }
    closedir($handle);
}

$rec_w = ($mi_group_config["mi_skin"] == "basic") ? 640 : 1920;
$rec_h = ($mi_group_config["mi_skin"] == "basic") ? 960 : 1080;
?>

<form name="fmainimage" id="fmainimage" action="./update.php" onsubmit="return fsubmit(this);" method="post"
    enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="old_mi_id" value="<?php echo $mi_id; ?>">

    <section id="group_config" class="tbl_frm01 tbl_wrap">
        <table>
            <caption>그룹 설정</caption>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <?php
                // Theme & Language (Unified Project UI Library)
                if (function_exists("get_theme_lang_select_ui")) {
                ?>
                <tr>
                    <th scope="row">설정 대상 (Theme & Lang)</th>
                    <td>
                        <?php echo get_theme_lang_select_ui(array(
                            "prefix" => "mi_",
                            "theme" => $mi_group_config["mi_theme"],
                            "lang" => $mi_group_config["mi_lang"],
                            "custom" => $mi_group_config["mi_custom"],
                            "id" => $mi_group_config["mi_id"]
                        )); ?>
                        <span class="frm_info">테마와 언어를 선택하면 식별코드가 자동으로 생성됩니다. (예: corporate_en_sub)</span>
                    </td>
                </tr>
                <?php } ?>

                <tr>
                    <th scope="row"><label for="mi_subject">제목</label></th>
                    <td>
                        <input type="text" name="mi_subject"
                            value="<?php echo stripslashes($mi_group_config["mi_subject"]); ?>" id="mi_subject" required
                            class="frm_input required" size="50">
                    </td>
                </tr>
                <tr>
                    <th scope="row">적용 스킨</th>
                    <td>
                        <style>
                            .mi-skin-list {
                                display: grid;
                                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                                gap: 15px;
                                margin-bottom: 25px;
                            }

                            .mi-skin-item {
                                cursor: pointer;
                            }

                            .mi-skin-item input[type="radio"] {
                                display: none;
                            }

                            .mi-skin-item label {
                                display: block;
                                padding: 20px 10px;
                                border: 1px solid #ddd;
                                border-radius: 8px;
                                background: #fafafa;
                                text-align: center;
                                transition: all 0.2s;
                                cursor: pointer;
                            }

                            .mi-skin-item label span {
                                display: block;
                                font-weight: bold;
                                margin-bottom: 5px;
                                color: #333;
                            }

                            .mi-skin-item label small {
                                display: block;
                                color: #888;
                                font-size: 11px;
                                margin-bottom: 8px;
                            }

                            .mi-skin-item label img {
                                width: 100%;
                                height: auto;
                                max-height: 80px;
                                object-fit: contain;
                                border-radius: 4px;
                                border: 1px solid #eee;
                                margin-top: 10px;
                            }

                            .mi-skin-item input[type="radio"]:checked+label {
                                border-color: #3498db;
                                background: #ebf5fb;
                                box-shadow: 0 0 0 1px #3498db;
                            }

                            .mi-skin-item input[type="radio"]:checked+label span {
                                color: #2980b9;
                            }

                            /* Effect Selection UI */
                            .effect-group {
                                margin-top: 20px;
                                padding: 20px;
                                background: #f8f9fa;
                                border-radius: 12px;
                                border: 1px solid #e9ecef;
                            }
                            .effect-title {
                                font-weight: bold;
                                margin-bottom: 15px;
                                color: #2c3e50;
                                display: flex;
                                align-items: center;
                                gap: 8px;
                            }
                            .effect-list {
                                display: flex;
                                gap: 10px;
                            }
                            .effect-btn {
                                flex: 1;
                                position: relative;
                            }
                            .effect-btn input {
                                display: none;
                            }
                            .effect-btn label {
                                display: block;
                                padding: 12px;
                                border: 1px solid #ced4da;
                                border-radius: 6px;
                                background: #fff;
                                text-align: center;
                                cursor: pointer;
                                transition: all 0.2s;
                                font-size: 13px;
                            }
                            .effect-btn input:checked + label {
                                background: #3498db;
                                color: #fff;
                                border-color: #2980b9;
                            }
                            .overlay-control {
                                margin-top: 20px;
                            }
                            .overlay-control label {
                                display: block;
                                margin-bottom: 8px;
                                font-weight: bold;
                            }
                            .overlay-row {
                                display: flex;
                                align-items: center;
                                gap: 15px;
                            }
                            input[type="range"] {
                                flex: 1;
                                height: 6px;
                                background: #dee2e6;
                                border-radius: 5px;
                            }
                        </style>
                        <div class="mi-skin-list">
                            <?php foreach ($skins as $key => $val) { ?>
                                <div class="mi-skin-item">
                                    <input type="radio" name="mi_skin" value="<?php echo $key; ?>"
                                        id="skin_<?php echo $key; ?>" <?php echo ($mi_group_config["mi_skin"] == $key) ? "checked" : ""; ?> onclick="updateSizeInfo('<?php echo $key; ?>')">
                                    <label for="skin_<?php echo $key; ?>">
                                        <span><?php echo $val; ?></span>
                                        <small><?php echo ($key == "basic") ? "640 x 960 px" : "1920 x 1080 px"; ?></small>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                        <span id="size_info" class="frm_info">
                            선택된 스킨 권장 사이즈: <strong id="rec_size"><?php echo $rec_w; ?> x <?php echo $rec_h; ?>
                                px</strong>
                        </span>

                        <!-- Effect Selection -->
                        <div class="effect-group">
                            <div class="effect-title">
                                <i class="fa fa-magic"></i> 프리미엄 효과 설정 (Premium Effects)
                            </div>
                            <div class="effect-list">
                                <?php
                                $effects = array(
                                    "none" => "효과 없음",
                                    "zoom" => "Ken Burns (확대)",
                                    "fade" => "Smooth Fade (페이드)"
                                );
                                foreach($effects as $key => $val) {
                                    $checked = ($mi_group_config['mi_effect'] == $key) ? "checked" : "";
                                ?>
                                <div class="effect-btn">
                                    <input type="radio" name="mi_effect" value="<?php echo $key; ?>" id="effect_<?php echo $key; ?>" <?php echo $checked; ?>>
                                    <label for="effect_<?php echo $key; ?>"><?php echo $val; ?></label>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="overlay-control">
                                <label for="mi_overlay">어두운 오버레이 강도 (Dark Overlay Intensity)</label>
                                <div class="overlay-row">
                                    <input type="range" name="mi_overlay" id="mi_overlay" min="0" max="0.9" step="0.1" value="<?php echo $mi_group_config['mi_overlay']; ?>" oninput="this.nextElementSibling.value = this.value">
                                    <output style="font-weight:bold; min-width:30px;"><?php echo $mi_group_config['mi_overlay']; ?></output>
                                </div>
                                <p class="frm_info">슬라이드 이미지 위의 텍스트 가독성을 높이기 위해 배경을 어둡게 만듭니다. (0: 투명, 0.9: 거의 검정)</p>
                            </div>
                        </div>

                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    <?php if ($w == "u") { ?>
        <section id="slide_management" class="tbl_head01 tbl_wrap" style="margin-top:30px;">
            <h3>이미지 및 텍스트 데이터 관리</h3>
            <table id="img_list_table">
                <thead>
                    <tr>
                        <th scope="col" style="width:60px">순서</th>
                        <th scope="col">이미지/텍스트 설정</th>
                        <th scope="col" style="width:120px">관리</th>
                    </tr>
                </thead>
                <tbody id="sortable_body">
                    <?php
                    $sql = " select * from g5_plugin_main_image_add where mi_style = '{$mi_id}' order by mi_sort asc, mi_id asc ";
                    $result = sql_query($sql);
                    $i = 0;
                    while ($row = sql_fetch_array($result)) {
                        $item_id = $row["mi_id"];
                        $img_src = "";
                        if ($row["mi_image"]) {
                            if (preg_match("/^(http|https):/i", $row["mi_image"])) {
                                $img_src = $row["mi_image"];
                            } else {
                                $img_src = G5_DATA_URL . "/main_visual/" . $row["mi_image"];
                            }
                        }
                        ?>
                        <tr class="bg<?php echo $i % 2; ?>">
                            <td class="td_num">
                                <input type="text" name="mi_sort[<?php echo $item_id; ?>]"
                                    value="<?php echo $row["mi_sort"]; ?>" class="frm_input" size="3">
                                <input type="hidden" name="mi_item_id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>">
                            </td>
                            <td class="td_left" style="padding:10px;">
                                <?php if ($img_src) { ?>
                                    <img src="<?php echo $img_src; ?>" id="preview_<?php echo $item_id; ?>"
                                        style="height:100px; margin-right:10px; vertical-align:middle; border:1px solid #ddd; object-fit:cover;">
                                <?php } else { ?>
                                    <div class="mi_preview_box" id="preview_<?php echo $item_id; ?>"
                                        style="margin-bottom:10px; display:none;"></div>
                                <?php } ?>

                                <input type="hidden" name="mi_image_url[<?php echo $item_id; ?>]"
                                    id="mi_image_url_<?php echo $item_id; ?>"
                                    value="<?php echo preg_match("/^(http|https):/i", $row["mi_image"]) ? $row["mi_image"] : ""; ?>">

                                <div style="margin-bottom:10px;">
                                    <button type="button" class="btn btn_03" style="font-weight:bold; padding:8px 15px;"
                                        onclick="openImageManager('<?php echo $item_id; ?>')">
                                        <i class="fa fa-picture-o"></i> 이미지 변경 / 관리
                                    </button>
                                </div>
                                <div style="margin-top:5px;">
                                    <input type="text" name="mi_tag[<?php echo $item_id; ?>]"
                                        value="<?php echo stripslashes($row["mi_tag"]); ?>" class="frm_input full_input"
                                        style="margin-bottom:5px; background:#f9fafb;" placeholder="태그 (Tag - 예: NEW, NOTICE)">
                                    <input type="text" name="mi_title[<?php echo $item_id; ?>]"
                                        value="<?php echo stripslashes($row["mi_title"]); ?>" class="frm_input full_input"
                                        placeholder="타이틀 (Title)">
                                    <input type="text" name="mi_subtitle[<?php echo $item_id; ?>]"
                                        value="<?php echo stripslashes($row["mi_subtitle"]); ?>" class="frm_input full_input"
                                        style="margin-top:5px;" placeholder="소제목 (Subtitle)">
                                    <textarea name="mi_desc[<?php echo $item_id; ?>]" class="frm_input full_input"
                                        style="margin-top:5px;"
                                        placeholder="설명 (Description)"><?php echo stripslashes($row["mi_desc"]); ?></textarea>
                                    
                                    <div style="display:flex; gap:5px; margin-top:5px;">
                                        <input type="text" name="mi_btn_text[<?php echo $item_id; ?>]"
                                            value="<?php echo stripslashes($row["mi_btn_text"]); ?>" class="frm_input"
                                            style="width:30%;" placeholder="버튼 텍스트 (기본: VIEW DETAILS)">
                                        <input type="text" name="mi_link[<?php echo $item_id; ?>]"
                                            value="<?php echo stripslashes($row["mi_link"]); ?>" class="frm_input"
                                            style="width:70%;" placeholder="연결 링크 URL">
                                    </div>
                                </div>
                            </td>
                            <td class="td_mng td_center">
                                <button type="button" class="btn_02 btn_del_ajax" data-id="<?php echo $item_id; ?>">삭제</button>
                            </td>
                        </tr>
                        <?php $i++;
                    } ?>
                </tbody>
            </table>
            <div style="margin: 15px 0; text-align: center;">
                <button type="button" id="btn_add_item" class="btn_02"><i class="fa fa-plus"></i> 슬라이드 추가</button>
            </div>
        </section>
    <?php } else { ?>
        <div class="local_desc02 local_desc">
            <p>💡 식별코드를 등록한 후, 상세 수정 페이지에서 슬라이드 이미지를 관리할 수 있습니다.</p>
        </div>
    <?php } ?>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="저장하기" class="btn_submit" accesskey="s">
        <button type="button" class="btn_02" onclick="view_preview()">미리보기</button>
        <a href="./list.php" class="btn_02">목록으로</a>
    </div>
</form>

<div id="preview_modal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:9999;">
    <div
        style="position:relative; width:98%; height:96%; margin:1% auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow: 0 0 40px rgba(0,0,0,0.6);">
        <button type="button" onclick="close_preview()"
            style="position:absolute; top:20px; right:20px; width:44px; height:44px; border:none; background:#fff; border-radius:50%; font-size:28px; cursor:pointer; color:#333; z-index:10001; box-shadow: 0 4px 15px rgba(0,0,0,0.3); line-height:44px; text-align:center; padding:0;">&times;</button>
        <iframe id="preview_frame" name="preview_frame" src="" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<style>
/* Premium Integrated Image Manager Modal Styles */
#unsplash_modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}
#unsplash_modal_content {
    width: 98%;
    max-width: 1800px;
    height: 96%;
    max-height: 1200px;
    background: #fff;
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}
#unsplash_iframe {
    width: 100%;
    height: 100%;
    border: none;
}
.close-modal {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 24px;
    color: #333;
    cursor: pointer;
    z-index: 10000;
    width: 35px;
    height: 35px;
    line-height: 35px;
    text-align: center;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: all 0.2s;
}
</style>

<div id="unsplash_modal">
    <div id="unsplash_modal_content">
        <span class="close-modal" onclick="closeUnsplashModal()">&times;</span>
        <iframe id="unsplash_iframe" src=""></iframe>
    </div>
</div>

<script>
    function updateSizeInfo(skin) {
        var rec = (skin == "basic") ? "640 x 960 px" : "1920 x 1080 px";
        $("#rec_size").text(rec);
    }

    function openImageManager(mi_id) {
        var skin = $("input[name='mi_skin']:checked").val();
        var w = (skin == "basic") ? 640 : 1920;
        var h = (skin == "basic") ? 960 : 1080;

        var url = "./image_manager.php?mi_id=" + mi_id + "&w=" + w + "&h=" + h + "&v=" + Date.now();
        document.getElementById("unsplash_iframe").src = url;
        document.getElementById("unsplash_modal").style.display = "flex";
    }

    function closeUnsplashModal() {
        document.getElementById("unsplash_modal").style.display = "none";
        document.getElementById("unsplash_iframe").src = "";
    }

    function receiveImageUrl(url, mi_id) {
        if (mi_id) {
            document.getElementById("mi_image_url_" + mi_id).value = url;
            var $preview = $("#preview_" + mi_id);
            if ($preview.length) {
                if ($preview.is("img")) {
                    $preview.attr("src", url);
                } else {
                    $preview.html("<img src=\"" + url + "\" style=\"height:100px; margin-right:10px; vertical-align:middle; border:1px solid #ddd; object-fit:cover;\">").show();
                }
            }
            closeUnsplashModal();
        }
    }

    $(function () {
        $(document).on("click", ".btn_del_ajax", function () {
            if (!confirm("삭제하시겠습니까?")) return;
            var mi_id = $(this).data("id");
            var $tr = $(this).closest("tr");
            $.post("./ajax.del_item.php", { mi_id: mi_id }, function (data) {
                if (data && data.result) {
                    $tr.fadeOut(300, function () { $(this).remove(); });
                } else {
                    alert(data.message || "삭제 중 오류가 발생했습니다.");
                }
            }, "json");
        });

        $("#btn_add_item").click(function () {
            var style = "<?php echo $mi_id; ?>";
            var skin = $("input[name='mi_skin']:checked").val();
            $.post("./ajax.add_item.php", { style: style, skin: skin }, function (html) {
                $("#sortable_body").append(html);
            });
        });
    });

    function fsubmit(f) {
        return true;
    }

    function view_preview() {
        var mi_id = $("#mi_id").val();
        var skin = $("input[name='mi_skin']:checked").val();
        if (!mi_id) mi_id = "sample";
        var url = "./preview_style.php?style=" + mi_id + "&skin=" + skin + "&v=" + Date.now();
        $("#preview_frame").attr("src", url);
        $("#preview_modal").css("display", "flex");
    }

    function close_preview() {
        $("#preview_modal").hide();
        $("#preview_frame").attr("src", "");
    }
</script>

<?php
include_once(G5_ADMIN_PATH . "/admin.tail.php");
?>