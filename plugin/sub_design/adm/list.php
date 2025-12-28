<?php
$sub_menu = '800200';
define('G5_IS_ADMIN', true);
include_once(dirname(__FILE__) . '/../../../common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!defined('G5_PLUGIN_SUB_DESIGN_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design');
}

// Table Creation Check
if (!sql_query(" DESCRIBE " . G5_PLUGIN_SUB_DESIGN_TABLE . " ", false)) {
    $sql = " CREATE TABLE IF NOT EXISTS `" . G5_PLUGIN_SUB_DESIGN_TABLE . "` (
                `sd_id` int(11) NOT NULL AUTO_INCREMENT,
                `me_code` varchar(255) NOT NULL DEFAULT '',
                `sd_main_text` varchar(255) NOT NULL DEFAULT '',
                `sd_sub_text` varchar(255) NOT NULL DEFAULT '',
                `sd_visual_img` varchar(255) NOT NULL DEFAULT '',
                PRIMARY KEY (`sd_id`),
                UNIQUE KEY `me_code` (`me_code`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";
    sql_query($sql, true);
} else {
    // Column Add Check
    $row = sql_fetch(" SHOW COLUMNS FROM `" . G5_PLUGIN_SUB_DESIGN_TABLE . "` LIKE 'sd_visual_img' ");
    if (empty($row)) {
        sql_query(" ALTER TABLE `" . G5_PLUGIN_SUB_DESIGN_TABLE . "` ADD `sd_visual_img` varchar(255) NOT NULL DEFAULT '' AFTER `sd_sub_text` ", true);
    }

    // [NEW] URL Column Add Check
    $row = sql_fetch(" SHOW COLUMNS FROM `" . G5_PLUGIN_SUB_DESIGN_TABLE . "` LIKE 'sd_visual_url' ");
    if (empty($row)) {
        sql_query(" ALTER TABLE `" . G5_PLUGIN_SUB_DESIGN_TABLE . "` ADD `sd_visual_url` varchar(255) NOT NULL DEFAULT '' AFTER `sd_visual_img` ", true);
    }
}

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '서브디자인 관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');

// Fetch Menus and Design Data (Level 1 and Level 2)
$sql = " SELECT a.me_code, a.me_name, b.sd_main_text, b.sd_sub_text, b.sd_visual_img, b.sd_visual_url 
         FROM {$g5['menu_table']} a 
         LEFT JOIN " . G5_PLUGIN_SUB_DESIGN_TABLE . " b ON a.me_code = b.me_code 
         WHERE length(a.me_code) = 2 OR length(a.me_code) = 4 
         ORDER BY a.me_code ";
$result = sql_query($sql);
?>

<div class="local_desc01 local_desc">
    <p>
        각 대메뉴(1차 메뉴) 및 서브메뉴(2차 메뉴)에 표시될 비주얼 문구와 이미지를 설정합니다.<br>
        <strong>메인 문구</strong>는 크게, <strong>서브 문구</strong>는 작게 표시됩니다.<br>
        이미지는 서브 페이지 상단 배경으로 사용됩니다.
    </p>
</div>

<form name="fsubdesign" id="fsubdesign" action="./update.php" onsubmit="return fsubdesign_submit(this);" method="post"
    enctype="multipart/form-data">
    <input type="hidden" name="token" value="<?php echo get_admin_token(); ?>">

    <div class="tbl_head01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <colgroup>
                <col width="100">
                <col width="150">
                <col width="200"><!-- Main Text Width Reduced -->
                <col>
                <col width="550"><!-- Visual Image Width Increased Further -->
            </colgroup>
            <thead>
                <tr>
                    <th scope="col">메뉴코드</th>
                    <th scope="col">메뉴명</th>
                    <th scope="col">메인 문구</th>
                    <th scope="col">서브 문구</th>
                    <th scope="col">서브 비주얼 이미지</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    $file_thumb = '';
                    $url_thumb = '';
                    $active_target = ''; // 'file' or 'url'
                
                    if ($row['sd_visual_img']) {
                        $file_path = G5_DATA_URL . '/sub_visual/' . $row['sd_visual_img'];
                        $file_thumb = '<a href="' . $file_path . '" target="_blank"><img src="' . $file_path . '" width="60" style="margin-bottom:5px; border:1px solid #ddd; vertical-align:middle;"></a>';
                        $active_target = 'file';
                    }

                    if ($row['sd_visual_url']) {
                        $url_path = $row['sd_visual_url'];
                        $url_thumb = '<img src="' . $url_path . '" width="60" style="border:1px solid #ddd; vertical-align:middle; object-fit:cover; height:35px;">';
                        if (!$active_target)
                            $active_target = 'url';
                    }

                    // Visual Indentation for Sub Menu
                    $me_name = $row['me_name'];
                    $indent_class = '';
                    if (strlen($row['me_code']) == 4) {
                        $me_name = '└ ' . $me_name;
                        $indent_class = 'style="padding-left:20px;"';
                    }
                    ?>
                    <tr class="bg<?php echo $i % 2; ?>">
                        <td class="td_code"><?php echo $row['me_code']; ?>
                            <input type="hidden" name="me_code[<?php echo $i; ?>]" value="<?php echo $row['me_code']; ?>">
                        </td>
                        <td class="td_category" <?php echo $indent_class; ?>><?php echo $me_name; ?></td>
                        <td>
                            <input type="text" name="sd_main_text[<?php echo $i; ?>]"
                                value="<?php echo get_text($row['sd_main_text']); ?>" class="frm_input frm_input_full"
                                placeholder="MAIN TEXT">
                        </td>
                        <td>
                            <input type="text" name="sd_sub_text[<?php echo $i; ?>]"
                                value="<?php echo get_text($row['sd_sub_text']); ?>" class="frm_input frm_input_full"
                                placeholder="SUB TEXT">
                        </td>
                        <td>
                            <!-- [1] Uploaded File Section -->
                            <div class="file_mng_area"
                                style="padding:10px; background:#f9f9f9; border-radius:5px; border:1px solid #eee;">
                                <div
                                    style="display:flex; justify-content:flex-end; align-items:center; height:18px; margin-bottom:5px;">
                                    <?php if ($active_target == 'file')
                                        echo '<span style="font-size:10px; background:#2277d2; color:#fff; padding:2px 8px; border-radius:3px;">[사용중]</span>'; ?>
                                </div>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <?php if ($file_thumb)
                                        echo $file_thumb; ?>
                                    <input type="file" name="sd_visual_img_<?php echo $i; ?>" class="frm_input">
                                </div>
                                <div class="frm_info" style="margin-top:5px;">권장 사이즈 : 1200 x 600 px</div>
                                <?php if ($row['sd_visual_img']) { ?>
                                    <div style="margin-top:5px;">
                                        <label><input type="checkbox" name="sd_visual_img_del[<?php echo $i; ?>]" value="1">
                                            서버파일 삭제</label>
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- [2] External URL / Image Search Section -->
                            <div class="url_mng_area"
                                style="margin-top:10px; padding:10px; background:#f0f4f9; border-radius:5px; border:1px solid #dce4ee;">
                                <div
                                    style="display:flex; justify-content:flex-end; align-items:center; height:18px; margin-bottom:5px;">
                                    <?php if ($active_target == 'url')
                                        echo '<span style="font-size:10px; background:#2277d2; color:#fff; padding:2px 8px; border-radius:3px;">[사용중]</span>'; ?>
                                </div>

                                <div class="visual_preview_box"
                                    style="<?php echo $row['sd_visual_url'] ? 'display:flex;' : 'display:none;'; ?> align-items:center; gap:10px; margin-bottom:10px;">
                                    <div class="preview_thumb_wrap"><?php echo $url_thumb; ?></div>
                                    <button type="button" class="btn btn_02" onclick="removeUnsplashImage(this)"
                                        style="padding:2px 5px; font-size:11px;">URL 비우기</button>
                                </div>

                                <div style="display:flex; gap:5px;">
                                    <input type="text" name="sd_visual_url[<?php echo $i; ?>]"
                                        value="<?php echo get_text($row['sd_visual_url']); ?>"
                                        class="frm_input frm_input_full" placeholder="외부 이미지 URL (권장 : 1200x600 px)">
                                    <button type="button" class="btn btn_03" onclick="openUnsplashSearch(this)"
                                        style="white-space:nowrap;">이미지 검색</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <?php if ($i == 0)
                    echo '<tr><td colspan="5" class="empty_table">등록된 메뉴가 없습니다. [환경설정 > 메뉴설정]에서 메뉴를 먼저 등록해주세요.</td></tr>'; ?>
            </tbody>
        </table>
    </div>

    <div class="btn_fixed_top">
        <input type="submit" value="일괄수정" class="btn_submit" accesskey="s">
    </div>
</form>

<div id="unsplashModal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:99999; justify-content:center; align-items:center;">
    <div style="position:relative; width:90%; height:90%; background:#fff; border-radius:5px; overflow:hidden;">
        <button type="button" onclick="closeUnsplashSearch()"
            style="position:absolute; top:20px; right:20px; font-size:30px; border:none; background:none; cursor:pointer; color:#000;">&times;</button>
        <iframe id="unsplashFrame" src="" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<script>
    var currentBtn = null;
    function openUnsplashSearch(btn) {
        currentBtn = $(btn);
        var modal = document.getElementById('unsplashModal');
        var frame = document.getElementById('unsplashFrame');

        // Sub-page hero size (approx 1200x600)
        var w = 1200;
        var h = 600;

        frame.src = "<?php echo G5_PLUGIN_URL; ?>/unsplash_api/popup.php?w=" + w + "&h=" + h;
        modal.style.display = 'flex';
    }

    function closeUnsplashSearch() {
        document.getElementById('unsplashModal').style.display = 'none';
        document.getElementById('unsplashFrame').src = '';
    }

    function receiveUnsplashUrl(url) {
        closeUnsplashSearch();
        if (!currentBtn) return;

        var td = currentBtn.closest("td");
        var urlInput = td.find("input[name^='sd_visual_url']");
        var previewBox = td.find(".visual_preview_box");
        var thumbWrap = previewBox.find(".preview_thumb_wrap");

        // Set value
        urlInput.val(url);

        // Update preview
        thumbWrap.html('<img src="' + url + '" width="60" style="border:1px solid #ddd; vertical-align:middle; object-fit:cover; height:35px;">');
        previewBox.css('display', 'flex');
    }

    function removeUnsplashImage(btn) {
        var td = $(btn).closest("td");
        td.find("input[name^='sd_visual_url']").val("");
        td.find(".visual_preview_box").hide();
    }

    function fsubdesign_submit(f) {
        return true;
    }
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>