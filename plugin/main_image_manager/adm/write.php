<?php
define('_GNUBOARD_ADMIN_', true);
$sub_menu = "800180";
include_once('./_common.php');
auth_check_menu($auth, $sub_menu, 'w');

$w = isset($_GET['w']) ? clean_xss_tags($_GET['w']) : '';
$mi_id = isset($_GET['mi_id']) ? clean_xss_tags($_GET['mi_id']) : '';

$config_table = G5_TABLE_PREFIX . 'plugin_main_image_config';

if ($w == 'u') {
    $g5['title'] = '메인 비주얼 수정';
    $mi_group_config = sql_fetch(" select * from {$config_table} where mi_id = '{$mi_id}' ");
    if (!$mi_group_config) {
        alert('그룹 정보를 찾을 수 없습니다.');
    }
} else {
    $g5['title'] = '메인 비주얼 추가';
    $mi_group_config = array(
        'mi_id' => '',
        'mi_subject' => '',
        'mi_skin' => 'basic'
    );
}

include_once(G5_ADMIN_PATH . '/admin.head.php');

// Skin Discovery
$skins_dir = G5_PLUGIN_PATH . '/main_image_manager/skins';
$skins = array();
$skin_names_map = array(
    'basic' => 'Basic (Split)',
    'full' => 'Smooth Fade',
    'fade' => 'Vertical Slide',
    'ultimate_hero' => 'Ultimate Hero'
);
$handle = opendir($skins_dir);
if ($handle) {
    while ($file = readdir($handle)) {
        if ($file == "." || $file == "..")
            continue;
        if (is_dir($skins_dir . '/' . $file)) {
            $name = isset($skin_names_map[$file]) ? $skin_names_map[$file] : ucfirst($file);
            $skins[$file] = $name;
        }
    }
    closedir($handle);
}

$rec_w = ($mi_group_config['mi_skin'] == 'basic') ? 640 : 1920;
$rec_h = ($mi_group_config['mi_skin'] == 'basic') ? 960 : 1080;
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
                // Theme & Language Parsing (Standardization Pattern A)
                $themes = array();
                $theme_dir = G5_PATH . '/theme'; // Fix: Scan the root theme directory
                if (is_dir($theme_dir)) {
                    $handle = opendir($theme_dir);
                    while ($file = readdir($handle)) {
                        if ($file == "." || $file == ".." || !is_dir($theme_dir . "/" . $file))
                            continue;
                        $themes[] = $file;
                    }
                    closedir($handle);
                }

                $langs = array(
                    'kr' => '한국어 (기본)',
                    'en' => 'English (EN)',
                    'jp' => 'Japanese (JP)',
                    'cn' => 'Chinese (CN)'
                );

                // Parse existing ID
                $parsed_theme = '';
                $parsed_lang = '';
                $parsed_custom = '';

                if ($w == 'u' && $mi_group_config['mi_id']) {
                    $parts = explode('_', $mi_group_config['mi_id']);

                    // Check if second part is a language
                    if (isset($parts[1]) && array_key_exists($parts[1], $langs) && $parts[1] != 'kr') {
                        $parsed_theme = $parts[0];
                        $parsed_lang = $parts[1];
                        if (isset($parts[2])) {
                            $parsed_custom = implode('_', array_slice($parts, 2));
                        }
                    } else if (isset($parts[0])) {
                        $parsed_theme = $parts[0];
                        $parsed_lang = 'kr';
                        if (isset($parts[1])) {
                            $parsed_custom = implode('_', array_slice($parts, 1));
                        }
                    }
                }
                ?>
                <tr>
                    <th scope="row">설정 대상 (Theme & Lang)</th>
                    <td>
                        <div style="display:flex; gap:10px; align-items:center;">
                            <select name="mi_theme" id="mi_theme" class="frm_input" onchange="generate_mi_id()">
                                <option value="">테마를 선택하세요</option>
                                <?php foreach ($themes as $t) { ?>
                                    <option value="<?php echo $t; ?>" <?php echo ($parsed_theme == $t) ? 'selected' : ''; ?>>
                                        <?php echo $t; ?>
                                    </option>
                                <?php } ?>
                                <?php if ($w == 'u' && !in_array($parsed_theme, $themes)) { ?>
                                    <option value="<?php echo $parsed_theme; ?>" selected><?php echo $parsed_theme; ?> (현재값)
                                    </option>
                                <?php } ?>
                            </select>

                            <select name="mi_lang" id="mi_lang" class="frm_input" onchange="generate_mi_id()">
                                <option value="">언어 선택</option>
                                <option value="kr" <?php echo ($parsed_lang == 'kr') ? 'selected' : ''; ?>>한국어</option>
                                <option value="en" <?php echo ($parsed_lang == 'en') ? 'selected' : ''; ?>>English
                                </option>
                                <option value="jp" <?php echo ($parsed_lang == 'jp') ? 'selected' : ''; ?>>Japanese
                                </option>
                                <option value="cn" <?php echo ($parsed_lang == 'cn') ? 'selected' : ''; ?>>Chinese
                                </option>
                            </select>

                            <!-- Custom Suffix -->
                            <input type="text" name="mi_id_custom" id="mi_id_custom"
                                value="<?php echo $parsed_custom; ?>" class="frm_input" style="width:150px;"
                                placeholder="커스텀 이름 (영문/숫자)" onkeyup="generate_mi_id()">
                        </div>
                        <div style="margin-top:5px; padding:10px; background:#f9f9f9; border:1px solid #eee;">
                            생성된 식별코드(ID): <strong id="display_mi_id"
                                style="color:#e74c3c; font-size:1.2em;"><?php echo $mi_group_config['mi_id']; ?></strong>
                            <input type="hidden" name="mi_id" id="mi_id"
                                value="<?php echo $mi_group_config['mi_id']; ?>">
                        </div>
                        <span class="frm_info">테마와 언어를 선택하면 식별코드가 자동으로 생성됩니다. (예: corporate_en_sub)</span>

                        <script>
                            function generate_mi_id() {
                                var theme = document.getElementById('mi_theme').value;
                                var lang = document.getElementById('mi_lang').value;
                                var custom = document.getElementById('mi_id_custom').value.trim();

                                if (!theme) return;

                                var new_id = theme;
                                if (lang && lang !== 'kr') {
                                    new_id += '_' + lang;
                                }

                                if (custom) {
                                    new_id += '_' + custom.replace(/[^a-z0-9_]/gi, '');
                                }

                                document.getElementById('mi_id').value = new_id;
                                document.getElementById('display_mi_id').innerText = new_id;
                            }
                        </script>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="mi_subject">제목</label></th>
                    <td>
                        <input type="text" name="mi_subject"
                            value="<?php echo stripslashes($mi_group_config['mi_subject']); ?>" id="mi_subject" required
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
                                margin-bottom: 15px;
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
                                color: #888;
                                font-size: 11px;
                            }

                            .mi-skin-item input[type="radio"]:checked+label {
                                border-color: #3498db;
                                background: #ebf5fb;
                                box-shadow: 0 0 0 1px #3498db;
                            }

                            .mi-skin-item input[type="radio"]:checked+label span {
                                color: #2980b9;
                            }
                        </style>
                        <div class="mi-skin-list">
                            <?php foreach ($skins as $key => $val) { ?>
                                <div class="mi-skin-item">
                                    <input type="radio" name="mi_skin" value="<?php echo $key; ?>"
                                        id="skin_<?php echo $key; ?>" <?php echo ($mi_group_config['mi_skin'] == $key) ? 'checked' : ''; ?> onclick="updateSizeInfo('<?php echo $key; ?>')">
                                    <label for="skin_<?php echo $key; ?>">
                                        <span><?php echo $val; ?></span>
                                        <small><?php echo ($key == 'basic') ? '640 x 960 px' : '1920 x 1080 px'; ?></small>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                        <span id="size_info" class="frm_info">
                            선택된 스킨 권장 사이즈: <strong id="rec_size"><?php echo $rec_w; ?> x <?php echo $rec_h; ?>
                                px</strong>
                        </span>

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

                            .close-modal:hover {
                                background: #fff;
                                transform: rotate(90deg);
                                color: #d4af37;
                            }
                        </style>

                        <div id="unsplash_modal">
                            <div id="unsplash_modal_content">
                                <span class="close-modal" onclick="closeUnsplashModal()">&times;</span>
                                <iframe id="unsplash_iframe" src=""></iframe>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    <?php if ($w == 'u') { ?>
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
                        $item_id = $row['mi_id'];
                        $img_src = '';
                        if ($row['mi_image']) {
                            if (preg_match("/^(http|https):/i", $row['mi_image'])) {
                                $img_src = $row['mi_image'];
                            } else {
                                $img_src = G5_DATA_URL . '/main_visual/' . $row['mi_image'];
                            }
                        }
                        ?>
                        <tr class="bg<?php echo $i % 2; ?>">
                            <td class="td_num">
                                <input type="text" name="mi_sort[<?php echo $item_id; ?>]"
                                    value="<?php echo $row['mi_sort']; ?>" class="frm_input" size="3">
                                <input type="hidden" name="mi_item_id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>">
                            </td>
                            <td class="td_left" style="padding:10px;">
                                <?php if ($img_src) { ?>
                                    <img src="<?php echo $img_src; ?>" id="preview_<?php echo $item_id; ?>"
                                        style="height:100px; margin-right:10px; vertical-align:middle; border:1px solid #ddd; object-fit:cover;">
                                    </div>
                                <?php } else { ?>
                                    <div class="mi_preview_box" id="preview_<?php echo $item_id; ?>"
                                        style="margin-bottom:10px; display:none;"></div>
                                <?php } ?>

                                <input type="hidden" name="mi_image_url[<?php echo $item_id; ?>]"
                                    id="mi_image_url_<?php echo $item_id; ?>"
                                    value="<?php echo preg_match("/^(http|https):/i", $row['mi_image']) ? $row['mi_image'] : ''; ?>">

                                <div style="margin-bottom:10px;">
                                    <button type="button" class="btn btn_03" style="font-weight:bold; padding:8px 15px;"
                                        onclick="openImageManager('<?php echo $item_id; ?>')">
                                        <i class="fa fa-picture-o"></i> 이미지 변경 / 관리
                                    </button>
                                </div>
                                <div style="margin-top:5px;">
                                    <input type="text" name="mi_title[<?php echo $item_id; ?>]"
                                        value="<?php echo stripslashes($row['mi_title']); ?>" class="frm_input full_input"
                                        placeholder="타이틀">
                                    <textarea name="mi_desc[<?php echo $item_id; ?>]" class="frm_input full_input"
                                        style="margin-top:5px;"
                                        placeholder="설명"><?php echo stripslashes($row['mi_desc']); ?></textarea>
                                    <input type="text" name="mi_link[<?php echo $item_id; ?>]"
                                        value="<?php echo stripslashes($row['mi_link']); ?>" class="frm_input full_input"
                                        style="margin-top:5px;" placeholder="연결 링크 URL">
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

<div id="unsplashModal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:99999; justify-content:center; align-items:center;">
    <div style="position:relative; width:90%; height:90%; background:#fff; border-radius:5px; overflow:hidden;">
        <button type="button" onclick="closeUnsplashSearch()"
            style="position:absolute; top:20px; right:20px; font-size:30px; border:none; background:none; cursor:pointer; color:#000;">&times;</button>
        <iframe id="unsplashFrame" src="" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<script>
    function updateSizeInfo(skin) {
        var rec = (skin == 'basic') ? "640 x 960 px" : "1920 x 1080 px";
        $("#rec_size").text(rec);
    }

    function openImageManager(mi_id) {
        var skin = $("input[name='mi_skin']:checked").val();
        var w = (skin == 'basic') ? 640 : 1920;
        var h = (skin == 'basic') ? 960 : 1080;

        var url = './image_manager.php?mi_id=' + mi_id + '&w=' + w + '&h=' + h + '&v=' + Date.now();
        document.getElementById('unsplash_iframe').src = url;
        document.getElementById('unsplash_modal').style.display = 'flex';
    }

    function closeUnsplashModal() {
        document.getElementById('unsplash_modal').style.display = 'none';
        document.getElementById('unsplash_iframe').src = '';
    }

    function receiveImageUrl(url, mi_id) {
        if (mi_id) {
            document.getElementById('mi_image_url_' + mi_id).value = url;
            var $preview = $('#preview_' + mi_id);
            if ($preview.length) {
                if ($preview.is("img")) {
                    $preview.attr("src", url);
                } else {
                    $preview.html('<img src="' + url + '" style="height:100px; margin-right:10px; vertical-align:middle; border:1px solid #ddd; object-fit:cover;">').show();
                }
            }
            closeUnsplashModal();
        }
    }

    // Alias for compatibility
    function receiveUnsplashUrl(url, mi_id) { receiveImageUrl(url, mi_id); }

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
            }, "json").fail(function (xhr, status, error) {
                alert("통신 오류가 발생했습니다: " + error);
            });
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
        // ID Validation
        var id_reg = /^[a-z0-9_]+$/;
        if (!id_reg.test(f.mi_id.value)) {
            alert('식별코드는 영문 소문자, 숫자, 언더바(_)만 가능합니다.');
            return false;
        }
        return true;
    }

    function view_preview() {
        var mi_id = $("#mi_id").val();
        var skin = $("input[name='mi_skin']:checked").val();

        // If ID is empty, use 'default' or a placeholder to trigger sample mode
        if (!mi_id) mi_id = 'sample';

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
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>