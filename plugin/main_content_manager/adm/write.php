<?php
$sub_menu = "800190";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

$ms_id = isset($_GET['ms_id']) ? (int) $_GET['ms_id'] : 0;
$w = isset($_GET['w']) ? $_GET['w'] : '';

if ($w == 'u') {
    $html_title = '메인 섹션 수정';
    $ms = sql_fetch(" select * from g5_plugin_main_content_sections where ms_id = '{$ms_id}' ");
    if (!$ms['ms_id'])
        alert('등록된 자료가 없습니다.');
} else {
    $html_title = '메인 섹션 추가';
    $ms = array(
        'ms_id' => '',
        'ms_title' => '',
        'ms_show_title' => 1,
        'ms_skin' => 'A',
        'ms_sort' => 0,
        'ms_active' => 1,
        'ms_lang' => 'kr',
        'ms_theme' => 'corporate',
        'ms_key' => '',
        'ms_accent_color' => '#FF3B30',
        'ms_font_mode' => 'serif'
    );
}

$g5['title'] = $html_title;
include_once(G5_ADMIN_PATH . '/admin.head.php');

// Skin List Detection
// Skin List Definition
$skins = array(
    'A' => 'Style A (Default)',
    'B' => 'Style B (Wide)',
    'C' => 'Style C (Simple)',
    'D' => 'Style D (Modern List)',
    'philosophy_light' => 'Style Philosophy'
);

$items = array();
if ($w == 'u') {
    $sql = " select * from g5_plugin_main_content where ms_id = '{$ms_id}' order by mc_sort asc ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result)) {
        if ($row['mc_image']) {
            if (preg_match("/^(http|https):/i", $row['mc_image'])) {
                $row['img_url'] = $row['mc_image'];
            } else {
                $row['img_url'] = G5_DATA_URL . '/common_assets/' . $row['mc_image'];
            }
        } else {
            $row['img_url'] = '';
        }
        $items[] = $row;
    }
}

// Ensure at least 1 item for new or empty sections
if (count($items) < 1) {
    for ($i = count($items) + 1; $i <= 1; $i++) {
        $items[] = array('mc_id' => 'new_' . time() . '_' . $i, 'mc_image' => '', 'mc_title' => '', 'mc_desc' => '', 'mc_link' => '', 'mc_target' => '', 'img_url' => '');
    }
}
?>

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
    body {
        background-color: #fff;
        /* Fallback for body background */
    }

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
        /* Increased from 1300px */
        height: 96%;
        max-height: 1200px;
        /* Increased from 900px */
        background: #fff;
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        margin: 1% auto;
        /* Added margin for centering and 96% height */
    }

    #unsplash_iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .close-modal {
        position: fixed;
        /* Changed from absolute to fixed */
        top: 20px;
        /* Adjusted for better viewport positioning */
        right: 20px;
        /* Adjusted for better viewport positioning */
        font-size: 28px;
        /* Increased font size */
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

<form name="fmaincontent" id="fmaincontent" action="./update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="ms_id" value="<?php echo $ms_id; ?>">
    <input type="hidden" name="token" value="<?php echo get_admin_token(); ?>">

    <div class="tbl_frm01 tbl_wrap" style="margin-bottom:30px;">
        <h2 class="h2_frm">섹션 기본 설정</h2>
        <table>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row">설정 대상 (Theme & Lang)</th>
                    <td>
                        <div style="display:flex; gap:10px; align-items:center;">
                            <?php
                            // [Standardization] Parsing Existing ID for Edit Mode
                            $sel_theme = '';
                            $sel_lang = 'kr';
                            $sel_custom = '';
                            if ($w == 'u' && $ms['ms_key']) {
                                $parts = explode('_', $ms['ms_key']);

                                // Check if second part is a language
                                if (isset($parts[1]) && in_array($parts[1], array('en', 'jp', 'cn'))) {
                                    $sel_theme = $parts[0];
                                    $sel_lang = $parts[1];
                                    if (isset($parts[2])) {
                                        array_shift($parts); // theme
                                        array_shift($parts); // lang
                                        $sel_custom = implode('_', $parts);
                                    }
                                } else if (isset($parts[0])) {
                                    $sel_theme = $parts[0];
                                    $sel_lang = 'kr'; // Default to KR if no language part is found
                                    if (isset($parts[1])) {
                                        array_shift($parts); // theme
                                        $sel_custom = implode('_', $parts);
                                    }
                                }
                            }

                            $themes = array();
                            $theme_dir = G5_PATH . '/theme';
                            if (is_dir($theme_dir)) {
                                $tdir = dir($theme_dir);
                                while ($entry = $tdir->read()) {
                                    if ($entry == '.' || $entry == '..')
                                        continue;
                                    if (is_dir($theme_dir . '/' . $entry))
                                        $themes[] = $entry;
                                }
                                $tdir->close();
                            }
                            sort($themes);
                            ?>
                            <select name="ms_theme" id="ms_theme" class="frm_input" onchange="generate_ms_key();">
                                <option value="">테마 선택</option>
                                <?php foreach ($themes as $t) { ?>
                                    <option value="<?php echo $t; ?>" <?php echo ($ms['ms_theme'] == $t) ? 'selected' : ''; ?>><?php echo $t; ?></option>
                                <?php } ?>
                            </select>
                            <select name="ms_lang" id="ms_lang" class="frm_input" onchange="generate_ms_key();">
                                <option value="kr" <?php echo ($ms['ms_lang'] == 'kr') ? 'selected' : ''; ?>>한국어 (기본)
                                </option>
                                <option value="en" <?php echo ($ms['ms_lang'] == 'en') ? 'selected' : ''; ?>>English (EN)
                                </option>
                                <option value="jp" <?php echo ($ms['ms_lang'] == 'jp') ? 'selected' : ''; ?>>Japanese (JP)
                                </option>
                                <option value="cn" <?php echo ($ms['ms_lang'] == 'cn') ? 'selected' : ''; ?>>Chinese (CN)
                                </option>
                            </select>
                            <input type="text" name="ms_key_custom" id="ms_key_custom"
                                value="<?php echo $sel_custom; ?>" class="frm_input" style="width:150px;"
                                placeholder="커스텀 이름 (선택)" onkeyup="generate_ms_key();">
                        </div>

                        <div style="margin-top:5px; padding:10px; background:#f9f9f9; border:1px solid #eee;">
                            생성된 식별코드(ID): <strong id="ms_key_display"
                                style="color:#e74c3c; font-size:1.2em;"><?php echo $ms['ms_key']; ?></strong>
                            <input type="hidden" name="ms_key" id="ms_key" value="<?php echo $ms['ms_key']; ?>">
                        </div>
                        <span class="frm_info">테마와 언어를 선택하면 식별코드가 자동으로 생성됩니다. (예: corporate_en_sub)</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ms_title">섹션 메인 제목</label></th>
                    <td>
                        <input type="text" name="ms_title" value="<?php echo get_text($ms['ms_title']); ?>"
                            id="ms_title" class="frm_input" style="width:100%; max-width:400px; font-weight:bold;">
                        <label style="margin-left:15px;"><input type="checkbox" name="ms_show_title" value="1" <?php echo $ms['ms_show_title'] ? 'checked' : ''; ?>> 사용자 페이지 제목 출력</label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ms_skin">디자인 스킨</label></th>
                    <td>
                        <select name="ms_skin" id="ms_skin" required onchange="update_rec_size(this.value);">
                            <?php foreach ($skins as $key => $val) { ?>
                                <option value="<?php echo $key; ?>" <?php echo ($ms['ms_skin'] == $key) ? 'selected' : ''; ?>>
                                    <?php echo $val; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <span id="rec_size_info" style="margin-left:15px; font-weight:bold; color:#e52727;"></span>
                        <div class="frm_info">테마 전역 변수를 상속받는 스킨을 선택하세요. 스킨 종류에 따라 권장 이미지 사이즈가 달라집니다.</div>
                    </td>
                </tr>
                <script>
                    function update_rec_size(skin) {
                        var size_info = "";
                        if (skin == 'A') size_info = "(권장: 800 x 600 px)";
                        else if (skin == 'B') size_info = "(권장: 1200 x 600 px)";
                        else if (skin == 'C') size_info = "(권장: 800 x 600 px)";

                        document.getElementById('rec_size_info').innerHTML = size_info;
                    }
                    // 초기 로드 시 실행
                    document.addEventListener('DOMContentLoaded', function () {
                        update_rec_size(document.getElementById('ms_skin').value);
                    });
                </script>
                <tr>
                    <th scope="row">노출 설정</th>
                    <td>
                        <input type="number" name="ms_sort" value="<?php echo $ms['ms_sort']; ?>" class="frm_input"
                            size="5"> 순서 (낮을수록 먼저 노출)
                        <label style="margin-left:15px;"><input type="checkbox" name="ms_active" value="1" <?php echo $ms['ms_active'] ? 'checked' : ''; ?>> 섹션 사용 활성화</label>
                        <button type="button" class="btn btn_03"
                            style="margin-left:30px; background:#3498db; color:#fff; border:none; padding:5px 15px;"
                            onclick="view_preview();">실시간 미리보기</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="tbl_head01 tbl_wrap">
        <h2 class="h2_frm">섹션 내부 아이템 관리</h2>
        <table id="main_content_table">
            <caption>섹션 아이템 목록</caption>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>이미지/텍스트</th>
                    <th>링크/상세</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $row) {
                    $mi_id = $row['mc_id'];
                    ?>
                    <tr>
                        <td class="td_num text-center">
                            <?php echo $i + 1; ?>
                            <input type="hidden" name="mc_id[]" value="<?php echo $mi_id; ?>">
                        </td>
                        <td class="td_left" style="padding:15px;">
                            <div style="display:flex; gap:20px;">
                                <div style="width:200px;">
                                    <div style="margin-bottom:10px;">
                                        <div id="mc_preview_<?php echo $mi_id; ?>"
                                            style="width:100%; height:120px; background:#f5f5f5; border:1px solid #ddd; display:flex; align-items:center; justify-content:center; color:#999; font-size:12px; overflow:hidden;">
                                            <?php if ($row['img_url']) { ?>
                                                <img src="<?php echo $row['img_url']; ?>"
                                                    style="width:100%; height:100%; object-fit:cover;">
                                            <?php } else { ?>
                                                NO IMAGE
                                            <?php } ?>
                                        </div>
                                        <?php if ($row['img_url']) { ?>
                                            <div style="margin-top:5px; text-align:right;">
                                                <label style="font-size:11px; color:#888;"><input type="checkbox"
                                                        name="mc_image_del[<?php echo $mi_id; ?>]" value="1"> 삭제</label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <input type="hidden" name="mc_image_url[<?php echo $mi_id; ?>]"
                                        id="mc_image_url_<?php echo $mi_id; ?>"
                                        value="<?php echo preg_match('/^(http|https):/i', $row['mc_image']) ? $row['mc_image'] : ''; ?>">
                                    <div style="margin-top:5px; text-align:center;">
                                        <button type="button" class="btn btn_02"
                                            style="width:100%; padding:5px 0; font-size:12px; font-weight:bold;"
                                            onclick="openUnsplashPopup('<?php echo $mi_id; ?>');">이미지 변경 / 관리</button>
                                    </div>
                                </div>
                                <div style="flex:1;">
                                    <div style="margin-bottom:10px;">
                                        <input type="text" name="mc_title[<?php echo $mi_id; ?>]"
                                            value="<?php echo get_text($row['mc_title']); ?>" class="frm_input"
                                            style="width:100%; font-weight:bold;" placeholder="아이템 제목">
                                    </div>
                                    <textarea name="mc_desc[<?php echo $mi_id; ?>]" class="frm_input"
                                        style="width:100%; height:100px; padding:10px; box-sizing:border-box;"
                                        placeholder="아이템 상세 설명"><?php echo get_text($row['mc_desc']); ?></textarea>
                                </div>
                            </div>
                        </td>
                        <td class="td_left" style="width:250px;">
                            <div style="margin-bottom:10px;">
                                <label style="font-size:11px; color:#888;">연결 링크</label>
                                <input type="text" name="mc_link[<?php echo $mi_id; ?>]"
                                    value="<?php echo get_text($row['mc_link']); ?>" class="frm_input" style="width:100%;">
                            </div>
                            <div>
                                <label style="font-size:11px; color:#888;">타겟</label>
                                <select name="mc_target[<?php echo $mi_id; ?>]" class="frm_input" style="width:100%;">
                                    <option value="" <?php echo ($row['mc_target'] == '') ? 'selected' : ''; ?>>현재창</option>
                                    <option value="_blank" <?php echo ($row['mc_target'] == '_blank') ? 'selected' : ''; ?>>새창
                                    </option>
                                </select>
                            </div>
                            <div style="margin-top:20px; text-align:right;">
                                <button type="button" class="btn btn_02 btn_del_item" style="font-size:11px; color:red;"
                                    <?php if (strpos($mi_id, 'new_') === false) { ?>
                                        onclick="if(confirm('이 아이템을 삭제하시겠습니까?')) location.href='./update.php?w=di&ms_id=<?php echo $ms_id; ?>&mc_id=<?php echo $mi_id; ?>&token=<?php echo get_admin_token(); ?>';"
                                    <?php } ?>>항목 삭제</button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div
            style="margin-top:15px; text-align:center; padding:15px; background:#f9f9f9; border:1px solid #eee; border-top:none;">
            <button type="button" class="btn btn_03" onclick="addItem();">+ 항목 추가</button>
        </div>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="저장하기" class="btn_submit btn" accesskey="s">
        <button type="button" class="btn btn_03" style="background:#3498db; color:#fff; border:none;"
            onclick="view_preview();">실시간 미리보기</button>
        <a href="./list.php" class="btn btn_02">목록으로</a>
    </div>

</form>

<script>
    function openUnsplashPopup(mi_id) {
        var skin = document.getElementById('ms_skin').value;
        var w = 0, h = 0;

        if (skin == 'A') { w = 800; h = 600; }
        else if (skin == 'B') { w = 1200; h = 600; }
        else if (skin == 'C') { w = 800; h = 600; }

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
            document.getElementById('mc_image_url_' + mi_id).value = url;
            // 프리뷰 업데이트
            var $preview = $('#mc_preview_' + mi_id);
            if ($preview.length) {
                $preview.html('<img src="' + url + '" style="width:100%; height:100%; object-fit:cover;">');
                $preview.addClass('preview-updated');
                setTimeout(function () { $preview.removeClass('preview-updated'); }, 1500);
            }
            closeUnsplashModal();
        }
    }

    // Alias for compatibility with image_manager.php
    function receiveUnsplashUrl(url, mi_id) { receiveImageUrl(url, mi_id); }

    function addItem() {
        var count = $('#main_content_table tbody tr').length;
        $.ajax({
            url: './ajax.add_item.php',
            type: 'post',
            data: {
                ms_id: '<?php echo $ms_id; ?>',
                count: count
            },
            success: function (data) {
                var $data = $(data).addClass('item-row-new');
                $('#main_content_table tbody').append($data);

                // 새로 추가된 행의 첫 번째 입력란에 포커스
                $data.find('input[type="text"]').first().focus();
            }
        });
    }

    $(document).on('click', '.btn_del_item', function () {
        var $row = $(this).closest('tr');
        if (confirm('이 항목을 삭제하시겠습니까?')) {
            if ($(this).attr('onclick')) {
                // 이미 DB에 있는 항목
                return;
            } else {
                // 새로 추가된 항목
                $row.addClass('item-row-del');
                setTimeout(function () {
                    $row.remove();
                    reorder_items();
                }, 300);
            }
        }
    });

    function reorder_items() {
        $('#main_content_table tbody tr').each(function (i) {
            $(this).find('.td_num').contents().filter(function () {
                return this.nodeType == 3;
            }).first().replaceWith(i + 1);
        });
    }

    function generate_ms_key() {
        var lang = $('#ms_lang').val();
        var theme = $('#ms_theme').val();
        var custom = $('#ms_key_custom').val().trim();
        var ms_id = '<?php echo $ms_id; ?>';

        var key = theme;
        if (lang !== 'kr') {
            key += '_' + lang;
        }

        if (custom) {
            key += '_' + custom.replace(/[^a-z0-9_]/gi, '');
        } else if (!ms_id || ms_id == '0') {
            // New sections get a random suffix to avoid collisions during creation
            key += '_sec_' + Date.now().toString().slice(-4);
        } else {
            key += '_sec_' + ms_id;
        }

        $('#ms_key').val(key);
        $('#ms_key_display').text(key);
    }

    function view_preview() {
        var ms_key = $('#ms_key').val();
        var skin = $('#ms_skin').val();

        if (!ms_key) {
            alert('먼저 식별 코드를 생성해주세요.');
            return;
        }

        // Create a temporary hidden form to post data to the preview
        var url = './preview_style.php?style=' + ms_key + '&skin=' + skin + '&t=' + Date.now();

        // Open in the existing Unsplash modal for convenience
        document.getElementById('unsplash_iframe').src = url;
        document.getElementById('unsplash_modal').style.display = 'flex';
        adjustUnsplashModal();
    }

    function adjustUnsplashModal() {
        // Dynamic adjustment if needed, now standardizing to 98%/96%
        $('#unsplash_modal_content').css({ 'max-width': '1800px', 'width': '98%', 'height': '96%', 'max-height': '1200px' });
    }

    // Initialize ID generation on load if empty
    $(function () {
        if (!$('#ms_key').val()) {
            generate_ms_key();
        }
    });

</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>