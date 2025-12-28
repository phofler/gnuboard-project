<?php
$sub_menu = "800150";
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

$plugin_path = G5_PLUGIN_PATH . '/top_menu_manager';
$skins_path = $plugin_path . '/skins';
$setting_file = $plugin_path . '/setting.php';

// Save logic (Skin)
if (isset($_POST['skin_name']) && $_POST['skin_name']) {
    check_admin_token();
    $skin_name = preg_replace('/[^a-z0-9_]/i', '', $_POST['skin_name']); // Sanitize
    $content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$top_menu_skin = '{$skin_name}';\n?>";
    file_put_contents($setting_file, $content);
    alert('스킨이 적용되었습니다.', './admin.php');
}

// Logo Upload Logic
if (isset($_POST['logo_upload']) && $_POST['logo_upload']) {
    check_admin_token();
    $data_path = G5_DATA_PATH . '/common';
    if (!is_dir($data_path)) {
        @mkdir($data_path, G5_DIR_PERMISSION);
        @chmod($data_path, G5_DIR_PERMISSION);
    }

    $logo_types = array('dark', 'light', 'mobile');
    foreach ($logo_types as $type) {
        $file_key = 'logo_pc_' . $type;
        if ($type == 'mobile')
            $file_key = 'logo_mobile';

        if (isset($_FILES[$file_key]['name']) && is_uploaded_file($_FILES[$file_key]['tmp_name'])) {
            if (!preg_match("/\.(jpg|jpeg|gif|png)$/i", $_FILES[$file_key]['name'])) {
                alert('이미지 파일(jpg, gif, png)만 업로드 가능합니다.');
            }

            $dest_file = $data_path . '/top_logo_' . $type . '.png';
            move_uploaded_file($_FILES[$file_key]['tmp_name'], $dest_file);
            chmod($dest_file, G5_FILE_PERMISSION);
        }
    }
    alert('로고가 업로드되었습니다.', './admin.php');
}

// Load current setting
$top_menu_skin = 'basic_light'; // default
if (file_exists($setting_file)) {
    include($setting_file);
}

// Get skin list
$skins = array();
$dir = dir($skins_path);
while ($entry = $dir->read()) {
    if ($entry == '.' || $entry == '..')
        continue;
    if (is_dir($skins_path . '/' . $entry)) {
        $skins[] = $entry;
    }
}
$dir->close();

// Custom Sort Order
$priority_order = array('basic', 'centered', 'modern', 'transparent', 'minimal');
usort($skins, function ($a, $b) use ($priority_order) {
    $pos_a = array_search($a, $priority_order);
    $pos_b = array_search($b, $priority_order);

    // items not found in priority list go to the end
    if ($pos_a === false)
        $pos_a = 999;
    if ($pos_b === false)
        $pos_b = 999;

    return $pos_a - $pos_b;
});

$g5['title'] = "상단 메뉴 스킨 관리";
include_once(G5_ADMIN_PATH . '/admin.head.php');

// Generate a single token for both forms
$admin_token = get_admin_token();
?>


<div class="local_desc01 local_desc">
    <p>상단 메인 메뉴(GNB)의 디자인 스킨을 선택할 수 있습니다.</p>
</div>

<form name="fskin" method="post" action="./admin.php">
    <input type="hidden" name="token" value="<?php echo $admin_token; ?>">
    <input type="hidden" name="skin_name" value="">
    <div class="tbl_head01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <colgroup>
                <col width="150">
                <col>
                <col width="100">
            </colgroup>
            <thead>
                <tr>
                    <th>스킨명</th>
                    <th>미리보기</th>
                    <th>선택</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($skins as $skin) {
                    $is_active = ($skin == $top_menu_skin);
                    $preview_img = G5_PLUGIN_URL . '/top_menu_manager/skins/' . $skin . '/preview.png';
                    if (!file_exists($skins_path . '/' . $skin . '/preview.png')) {
                        // Generate a dummy preview if not exists (or just show text)
                        $preview_img = '';
                    }
                    ?>
                    <tr class="<?php echo $is_active ? 'bg2' : ''; ?>">
                        <td class="td_category">
                            <?php echo $skin; ?>
                            <?php
                            if ($skin == 'minimal')
                                echo ' <span style="color:blue;">[작업중]</span>';
                            ?>
                            <?php if ($is_active)
                                echo '<br><strong style="color:red">[사용중]</strong>'; ?>
                        </td>
                        <td style="padding:10px; text-align:center;">
                            <?php
                            $preview_file = $skins_path . '/' . $skin . '/preview.php';
                            $preview_url = G5_PLUGIN_URL . '/top_menu_manager/skins/' . $skin . '/preview.php';

                            if (file_exists($preview_file)) { ?>
                                <button type="button" class="btn btn_01"
                                    onclick="showPreview('<?php echo $preview_url; ?>')">미리보기</button>
                            <?php } else { ?>
                                <span style="color:#ccc;">No Preview</span>
                            <?php } ?>
                        </td>
                        <td class="td_mng">
                            <?php if (!$is_active) { ?>
                                <button type="button"
                                    onclick="this.form.skin_name.value='<?php echo $skin; ?>'; this.form.submit();"
                                    class="btn btn_03">이 스킨
                                    적용</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn_02" disabled>적용중</button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</form>

<h2 class="h2_frm" style="margin-top:40px;">로고 관리 (Logo Management)</h2>
<p>각 스킨 모드(다크/라이트) 및 모바일에서 사용할 로고를 직접 업로드할 수 있습니다. (권장 확장자: PNG 투명 배경)</p>
</div>

<form name="flogo" method="post" action="./admin.php" enctype="multipart/form-data">
    <input type="hidden" name="token" value="<?php echo $admin_token; ?>">
    <input type="hidden" name="logo_upload" value="1">

    <div class="tbl_frm01 tbl_wrap">
        <table>
            <caption>로고 업로드</caption>
            <colgroup>
                <col span="1" width="200">
                <col span="1">
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row">PC 로고</th>
                    <td>
                        <input type="file" name="logo_pc_dark" id="logo_pc_dark">
                        <span class="frm_info">사이트 상단에 공통으로 사용되는 로고입니다. (배경이 어두운 스킨이 많으므로 <strong>흰색 로고</strong>를
                            권장합니다.)</span>
                        <?php
                        $logo_dark = G5_DATA_PATH . '/common/top_logo_dark.png';
                        if (file_exists($logo_dark)) {
                            echo '<div style="margin-top:10px; background:#333; padding:10px; display:inline-block;"><img src="' . G5_DATA_URL . '/common/top_logo_dark.png?v=' . time() . '" style="max-height:40px;"></div>';
                        }
                        ?>
                    </td>
                </tr>
                <!-- 
                <tr>
                    <th scope="row">PC 로고 (라이트/컬러)</th>
                    <td>
                        <input type="file" name="logo_pc_light" id="logo_pc_light">
                        <span class="frm_info">밝은 배경의 스킨(Transparent 등)에서 사용됩니다. (유색/검정 로고 권장)</span>
                        <?php
                        // $logo_light = G5_DATA_PATH . '/common/top_logo_light.png';
                        // if (file_exists($logo_light)) {
                        //     echo '<div style="margin-top:10px; background:#fff; padding:10px; display:inline-block; border:1px solid #ddd;"><img src="' . G5_DATA_URL . '/common/top_logo_light.png?v=' . time() . '" style="max-height:40px;"></div>';
                        // }
                        ?>
                    </td>
                </tr> 
                -->
                <tr>
                    <th scope="row">모바일 로고</th>
                    <td>
                        <input type="file" name="logo_mobile" id="logo_mobile">
                        <span class="frm_info">모바일 뷰에서 공통으로 사용됩니다.</span>
                        <?php
                        $logo_mobile = G5_DATA_PATH . '/common/top_logo_mobile.png';
                        if (file_exists($logo_mobile)) {
                            echo '<div style="margin-top:10px; background:#f8f8f8; padding:10px; display:inline-block; border:1px solid #ddd;"><img src="' . G5_DATA_URL . '/common/top_logo_mobile.png?v=' . time() . '" style="max-height:40px;"></div>';
                        }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="로고 업로드" class="btn_submit" accesskey="s">
    </div>
</form>


<!-- Preview Modal -->
<div id="previewModal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999; justify-content:center; align-items:center;">
    <div
        style="position:relative; width:90%; height:90%; background:#fff; border-radius:5px; overflow:hidden; box-shadow:0 0 20px rgba(0,0,0,0.5);">
        <button type="button" onclick="closePreview()"
            style="position:absolute; top:10px; right:15px; font-size:24px; color:#333; background:none; border:none; cursor:pointer; z-index:10000;">&times;</button>
        <iframe id="previewFrame" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<script>
    function showPreview(url) {
        var modal = document.getElementById('previewModal');
        var frame = document.getElementById('previewFrame');
        frame.src = url;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closePreview() {
        var modal = document.getElementById('previewModal');
        var frame = document.getElementById('previewFrame');
        modal.style.display = 'none';
        frame.src = '';
        document.body.style.overflow = '';
    }

    // Close when clicking outside
    document.getElementById('previewModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closePreview();
        }
    });
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>