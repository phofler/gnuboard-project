<?php
$sub_menu = '800200';
include_once(dirname(__FILE__) . '/../../../common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'w');

$sd_id = isset($_GET['sd_id']) ? clean_xss_tags($_GET['sd_id']) : '';
$w = isset($_GET['w']) ? clean_xss_tags($_GET['w']) : '';

if (!defined('G5_PLUGIN_SUB_DESIGN_GROUP_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_GROUP_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_groups');
}
if (!defined('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_items');
}

$sd = array(
    'sd_id' => '',
    'sd_theme' => '',
    'sd_lang' => 'kr',
    'sd_skin' => 'standard'
);

if ($w == 'u' && $sd_id) {
    $sd = sql_fetch(" SELECT * FROM " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " WHERE sd_id = '$sd_id' ");
    if (!$sd) {
        alert('존재하지 않는 서브 디자인 그룹입니다.');
    }
}

// Theme List
$themes = array();
$theme_dir = G5_PATH . '/theme';
if (is_dir($theme_dir)) {
    $handle = opendir($theme_dir);
    while ($file = readdir($handle)) {
        if ($file == "." || $file == ".." || !is_dir($theme_dir . "/" . $file))
            continue;
        $themes[] = $file;
    }
    closedir($handle);
}

// Skins
$skins = array('standard', 'cinema', 'works_dark', 'minimal');

$g5['title'] = ($w == 'u') ? '서브 디자인 수정' : '서브 디자인 추가';
include_once(G5_ADMIN_PATH . '/admin.head.php');
?>

<form name="fsubdesign" id="fsubdesign" action="./update.php" onsubmit="return fsubmit(this);" method="post"
    enctype="multipart/form-data">
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
                <?php
                // Standard Parsing Logic
                $sel_theme = $sd['sd_theme'];
                $sel_lang = $sd['sd_lang'];
                $sel_custom = '';

                if ($w == 'u' && $sd['sd_id']) {
                    $parts = explode('_', $sd['sd_id']);
                    // Simplified parsing for Sub Design
                    if (isset($parts[0]) && in_array($parts[0], $themes)) {
                        $sel_theme = $parts[0];
                        if (isset($parts[1]) && in_array($parts[1], array('kr', 'en', 'jp', 'cn'))) {
                            $sel_lang = $parts[1];
                            if (isset($parts[2])) {
                                array_shift($parts);
                                array_shift($parts);
                                $sel_custom = implode('_', $parts);
                            }
                        }
                    }
                }
                ?>
                <tr>
                    <th scope="row">설정 대상 (Theme & Lang)</th>
                    <td>
                        <div style="display:flex; gap:10px; align-items:center;">
                            <select name="sd_theme" id="sd_theme" class="frm_input" onchange="generate_sd_id()"
                                required>
                                <option value="">테마 선택</option>
                                <?php foreach ($themes as $theme) {
                                    $selected = ($theme == $sel_theme) ? 'selected' : '';
                                    echo '<option value="' . $theme . '" ' . $selected . '>' . $theme . '</option>';
                                } ?>
                            </select>

                            <select name="sd_lang" id="sd_lang" class="frm_input" onchange="generate_sd_id()" required>
                                <option value="kr" <?php echo ($sel_lang == 'kr') ? 'selected' : ''; ?>>한국어 (기본)
                                </option>
                                <option value="en" <?php echo ($sel_lang == 'en') ? 'selected' : ''; ?>>English (EN)
                                </option>
                                <option value="jp" <?php echo ($sel_lang == 'jp') ? 'selected' : ''; ?>>Japanese (JP)
                                </option>
                                <option value="cn" <?php echo ($sel_lang == 'cn') ? 'selected' : ''; ?>>Chinese (CN)
                                </option>
                            </select>

                            <input type="text" name="sd_id_custom" id="sd_id_custom" value="<?php echo $sel_custom; ?>"
                                class="frm_input" style="width:150px;" placeholder="커스텀 이름 (선택)"
                                onkeyup="generate_sd_id()">
                        </div>

                        <div style="margin-top:5px; padding:10px; background:#f9f9f9; border:1px solid #eee;">
                            생성된 식별코드(ID): <strong id="display_sd_id" style="color:#e74c3c; font-size:1.2em;">
                                <?php echo $sd['sd_id']; ?>
                            </strong>
                            <input type="hidden" name="sd_id" id="sd_id" value="<?php echo $sd['sd_id']; ?>">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">스킨 선택</th>
                    <td>
                        <style>
                            .skin-selector {
                                display: grid;
                                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                                gap: 15px;
                                margin-bottom: 15px;
                            }

                            .skin-card {
                                border: 2px solid #eee;
                                border-radius: 10px;
                                padding: 15px;
                                cursor: pointer;
                                transition: all 0.2s;
                                position: relative;
                                background: #fff;
                                text-align: center;
                            }

                            .skin-card:hover {
                                border-color: #ddd;
                                transform: translateY(-2px);
                                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                            }

                            .skin-card.active {
                                border-color: #3498db;
                                background: #f0f7ff;
                            }

                            .skin-card input {
                                position: absolute;
                                opacity: 0;
                            }

                            .skin-name {
                                display: block;
                                font-size: 14px;
                                font-weight: 800;
                                color: #333;
                                margin-bottom: 5px;
                                text-transform: uppercase;
                            }

                            .skin-size {
                                display: block;
                                font-size: 11px;
                                color: #777;
                                letter-spacing: 0.05em;
                            }

                            .active-indicator {
                                position: absolute;
                                top: -10px;
                                right: -10px;
                                width: 24px;
                                height: 24px;
                                background: #3498db;
                                color: #fff;
                                border-radius: 50%;
                                line-height: 24px;
                                font-size: 12px;
                                display: none;
                            }

                            .skin-card.active .active-indicator {
                                display: block;
                            }

                            /* Image Management Column Styling */
                            .visual-preview-box {
                                position: relative;
                                width: 140px;
                                height: 80px;
                                border: 1px solid #ddd;
                                border-radius: 4px;
                                overflow: hidden;
                                background: #f1f1f1;
                                margin-bottom: 8px;
                            }

                            .visual-preview-box img {
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                            }

                            .btn-img-manage {
                                display: inline-flex;
                                align-items: center;
                                gap: 6px;
                                padding: 6px 12px;
                                background: #34495e;
                                color: #fff;
                                border: none;
                                border-radius: 4px;
                                font-size: 11px;
                                font-weight: 700;
                                cursor: pointer;
                                transition: background 0.2s;
                            }

                            .btn-img-manage:hover {
                                background: #2c3e50;
                            }

                            .btn-url-remove {
                                padding: 6px;
                                background: #fff;
                                border: 1px solid #ddd;
                                border-radius: 4px;
                                cursor: pointer;
                                color: #e74c3c;
                            }

                            .btn-url-remove:hover {
                                border-color: #e74c3c;
                            }
                        </style>

                        <div class="skin-selector">
                            <?php
                            $skin_sizes = array(
                                'standard' => '1920 x 450 px',
                                'cinema' => '1920 x 1080 px (FULL)',
                                'works_dark' => '1920 x 800 px',
                                'minimal' => '1920 x 600 px'
                            );
                            foreach ($skins as $skin) {
                                $active = ($skin == $sd['sd_skin']) ? 'active' : '';
                                ?>
                                <label class="skin-card <?php echo $active; ?>"
                                    onclick="selectSkin(event, '<?php echo $skin; ?>')">
                                    <input type="radio" name="sd_skin" value="<?php echo $skin; ?>" <?php echo ($active ? 'checked' : ''); ?>>
                                    <span class="active-indicator"><i class="fa fa-check"></i></span>
                                    <span class="skin-name"><?php echo $skin; ?></span>
                                    <span class="skin-size"><?php echo $skin_sizes[$skin]; ?></span>
                                </label>
                            <?php } ?>
                        </div>
                        <div style="padding:12px; background:#f8f9fa; border-radius:6px; font-size:12px; color:#555;">
                            선택된 스킨 권장 사이즈: <strong id="selected_skin_size"
                                style="color:#2980b9;"><?php echo $skin_sizes[$sd['sd_skin']]; ?></strong>
                        </div>
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
        <button type="button" class="btn btn_03" style="background:#3498db; color:#fff; border:none;"
            onclick="view_preview()">실시간 미리보기</button>
        <a href="./list.php" class="btn btn_02">목록으로</a>
    </div>
</form>

<div id="unsplash_modal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:9999;">
    <div id="unsplash_modal_content"
        style="position:relative; width:98%; height:96%; margin:1% auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow: 0 0 40px rgba(0,0,0,0.6);">
        <button type="button" onclick="closeUnsplashModal()"
            style="position:absolute; top:20px; right:20px; width:44px; height:44px; border:none; background:#fff; border-radius:50%; font-size:28px; cursor:pointer; color:#333; z-index:10001; box-shadow: 0 4px 15px rgba(0,0,0,0.3); line-height:44px; text-align:center; padding:0;">&times;</button>
        <iframe id="unsplash_iframe" name="unsplash_iframe" src=""
            style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<!-- Preview Modal -->
<div id="preview_modal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); z-index:10000;">
    <div
        style="position:relative; width:98%; height:96%; margin:1% auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow: 0 0 50px rgba(0,0,0,0.8);">
        <button type="button" onclick="closePreview()"
            style="position:absolute; top:20px; right:20px; width:44px; height:44px; border:none; background:#fff; border-radius:50%; font-size:28px; cursor:pointer; color:#333; z-index:10001; box-shadow: 0 4px 15px rgba(0,0,0,0.3); line-height:44px; text-align:center; padding:0;">&times;</button>
        <iframe id="preview_iframe" name="preview_iframe" src="" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<script>
    function selectSkin(e, skin) {
        $('.skin-card').removeClass('active');
        $(e.currentTarget).addClass('active');
        $(e.currentTarget).find('input').prop('checked', true);

        var sizes = {
            'standard': '1920 x 450 px',
            'cinema': '1920 x 1080 px (FULL)',
            'works_dark': '1920 x 800 px',
            'minimal': '1920 x 600 px'
        };
        $('#selected_skin_size').text(sizes[skin]);
    }

    function generate_sd_id() {
        var theme = $('#sd_theme').val();
        var lang = $('#sd_lang').val();
        var custom = $('#sd_id_custom').val();

        if (!theme) {
            $('#display_sd_id').text('-');
            $('#sd_id').val('');
            return;
        }

        var id = theme;
        if (lang != 'kr') id += '_' + lang;
        if (custom) {
            id += '_' + custom;
        } else {
            // No random suffix for Sub Design to keep it stable
        }

        $('#display_sd_id').text(id);
        $('#sd_id').val(id);

        loadMenuList(lang, id);
    }

    function loadMenuList(lang, sd_id) {
        $.post('./ajax.load_menus.php', { lang: lang, sd_id: sd_id }, function (html) {
            $('#menu_list_body').html(html);
        });
    }

    function openImageManager(idx) {
        currentTargetIdx = idx;
        var skin = $('input[name="sd_skin"]:checked').val();  var dims = {
            'standard': { w: 1920, h: 450 },
            'cinema': { w: 1920, h: 1080 },
            'works_dark': { w: 1920, h: 800 },
            'minimal': { w: 1920, h: 600 }
        };
        var w = dims[skin] ? dims[skin].w : 1920;
        var h = dims[skin] ? dims[skin].h : 600;

        var url = '<?php echo G5_PLUGIN_URL; ?>/main_image_manager/adm/image_manager.php?w=' + w +  ' & h =' +  h   +  '&v=' + Date.now();
        document.getElementById('unsplash_iframe').src = url;
        document.getElementById('unsplash_modal').style.display = 'flex';
    }

    function closeUnsplashModal() {
        document.getElementById('unsplash_modal').style.display = 'none';
        document.getElementById('unsplash_iframe').src = '';
    }

    function receiveImageUrl(url) {
        if (currentTargetIdx !== null) {
            $('#sd_visual_url_' + currentTargetIdx).val(url);
            $('#preview_' + currentTargetIdx).html('<img src="' + url + '">');
        }
        closeUnsplashModal();
    }
    // Backward compatibility alias
    window.receiveUnsplashUrl = receiveImageUrl;

    function removeUrl(idx) {
        $('#sd_visual_url_' + idx).val('');
        $('#preview_' + idx).html('<div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#ccc; font-size:20px;"><i class="fa fa-picture-o"></i></div>');
    }

    window.onload = function () {
        generate_sd_id();
    };

    function view_preview() {
        var skin = $('input[name="sd_skin"]:checked').val();

        // Use first menu item for preview if exists
        var main_text = $('input[name="sd_main_text[]"]').first().val() || 'SAMPLE TITLE';
        var sub_text = $('input[name="sd_sub_text[]"]').first().val() || 'Sample Subtitle Text';
        var visual_url = $('input[name="sd_visual_url[]"]').first().val();

        var query = 'skin=' + skin + '&main_text=' + encodeURIComponent(main_text) + '&sub_text=' + encodeURIComponent(sub_text) + '&visual_url=' + encodeURIComponent(visual_url);

        document.getElementById('preview_iframe').src = './preview.php?' + query;
        $('#preview_modal').fadeIn(200);
    }

    function closePreview() {
        $('#preview_modal').fadeOut(200);
        document.getElementById('preview_iframe').src = '';
    }

    function fsubmit(f) {
        if (!f.sd_id.value) { alert('테마를 선택해주세요.'); return false; }
        return true;
    }
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>