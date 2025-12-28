<?php
$sub_menu = "800350";
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

$g5['title'] = '카피라이트 및 하단 정보 관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');

$table_name = G5_TABLE_PREFIX . 'copyright_config';

// DB Auto Install
$row = sql_fetch(" SHOW TABLES LIKE '{$table_name}' ");
if (!$row) {
    include_once('./install.php');
} else {
    include_once('./install.php');
}

$setting_file = './setting.php';

// Update Logic
if (isset($_POST['w']) && $_POST['w'] == 'u') {
    check_admin_token();

    $logo_url = $_POST['logo_url'];

    // Logo Upload
    if (isset($_FILES['logo_file']['name']) && is_uploaded_file($_FILES['logo_file']['tmp_name'])) {
        $data_path = G5_DATA_PATH . '/common';
        if (!is_dir($data_path)) {
            @mkdir($data_path, G5_DIR_PERMISSION);
            @chmod($data_path, G5_DIR_PERMISSION);
        }

        if (preg_match("/\.(jpg|jpeg|gif|png)$/i", $_FILES['logo_file']['name'])) {
            $dest_file = $data_path . '/footer_logo.png';
            move_uploaded_file($_FILES['logo_file']['tmp_name'], $dest_file);
            chmod($dest_file, G5_FILE_PERMISSION);
            $logo_url = G5_DATA_URL . '/common/footer_logo.png';
        }
    }

    $sql = " update {$table_name}
                set logo_url = '{$logo_url}',
                    addr_label = '{$_POST['addr_label']}',
                    addr_val = '{$_POST['addr_val']}',
                    tel_label = '{$_POST['tel_label']}',
                    tel_val = '{$_POST['tel_val']}',
                    fax_label = '{$_POST['fax_label']}',
                    fax_val = '{$_POST['fax_val']}',
                    email_label = '{$_POST['email_label']}',
                    email_val = '{$_POST['email_val']}',
                    slogan = '{$_POST['slogan']}',
                    copyright = '{$_POST['copyright']}',
                    link1_name = '{$_POST['link1_name']}',
                    link1_url = '{$_POST['link1_url']}',
                    link2_name = '{$_POST['link2_name']}',
                    link2_url = '{$_POST['link2_url']}'
                where id = 1 ";
    sql_query($sql);

    // Save Skin Selection to file
    $skin_name = preg_replace('/[^a-z0-9_]/i', '', $_POST['footer_skin']);
    $content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$footer_skin = '{$skin_name}';\n?>";
    file_put_contents($setting_file, $content);

    alert('저장되었습니다.', './admin.php');
}

// Load current setting
$footer_skin = 'style_a';
if (file_exists($setting_file)) {
    include($setting_file);
}

// Load current config
$cp = sql_fetch(" select * from {$table_name} where id = 1 ");
if (!$cp) {
    $cp = array(
        'addr_label' => '주소',
        'tel_label' => '연락처',
        'fax_label' => '팩스',
        'email_label' => '이메일',
        'logo_url' => '',
        'addr_val' => '',
        'tel_val' => '',
        'fax_val' => '',
        'email_val' => '',
        'copyright' => '',
        'link1_name' => '',
        'link1_url' => '',
        'link2_name' => '',
        'link2_url' => ''
    );
}

$admin_token = get_admin_token();
?>

<form name="fcopyright" id="fcopyright" action="./admin.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="w" value="u">
    <input type="hidden" name="token" value="<?php echo $admin_token; ?>">
    <input type="hidden" name="logo_url" value="<?php echo $cp['logo_url']; ?>">

    <div class="btn_fixed_top">
        <input type="submit" value="확인" class="btn_submit btn">
    </div>

    <h2 class="h2_frm">하단 스킨 선택</h2>
    <div class="tbl_head01 tbl_wrap">
        <table>
            <caption>스킨 선택</caption>
            <colgroup>
                <col span="1" width="150">
                <col span="1">
                <col span="1" width="100">
            </colgroup>
            <thead>
                <tr>
                    <th>스킨명</th>
                    <th>디자인 특징</th>
                    <th>선택</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $skins = array(
                    'style_a' => 'Classic Centered - 깔끔한 중앙 정렬 레이아웃',
                    'style_b' => 'Modern Split - 세련된 좌우 분할 레이아웃',
                    'style_c' => 'Cinematic Grid - 정보 중심의 다단 레이아웃'
                );
                foreach ($skins as $sk => $desc) {
                    $is_active = ($sk == $footer_skin);
                    ?>
                    <tr class="<?php echo $is_active ? 'bg2' : ''; ?>">
                        <td class="td_category">
                            <?php echo strtoupper(str_replace('_', ' ', $sk)); ?>
                            <?php if ($is_active)
                                echo '<br><strong style="color:red">[사용중]</strong>'; ?>
                        </td>
                        <td style="padding:15px;"><?php echo $desc; ?></td>
                        <td class="td_mng">
                            <label><input type="radio" name="footer_skin" value="<?php echo $sk; ?>" <?php echo $is_active ? 'checked' : ''; ?>> 선택</label>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <h2 class="h2_frm" style="margin-top:40px;">하단 정보 관리</h2>

    <div class="tbl_frm01 tbl_wrap">
        <table>
            <caption>하단 정보 관리</caption>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row">하단 로고</th>
                    <td>
                        <input type="file" name="logo_file" id="logo_file">
                        <span class="frm_info">하단(footer)에 표시될 로고를 업로드하세요. (권장: PNG 투명 배경)</span>
                        <?php if ($cp['logo_url']) { ?>
                            <div style="margin-top:10px; background:#333; padding:10px; display:inline-block;">
                                <img src="<?php echo $cp['logo_url']; ?>?v=<?php echo time(); ?>" style="max-height:40px;">
                            </div>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">사훈 (간단한멘트)</th>
                    <td>
                        <input type="text" name="slogan"
                            value="<?php echo isset($cp['slogan']) ? $cp['slogan'] : ''; ?>" id="slogan"
                            class="frm_input" style="width:100%;">
                        <span class="frm_info">Style C 등 일부 스킨에서 로고 아래 등에 표시됩니다.</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">주소 (Address)</th>
                    <td>
                        <label for="addr_label">명칭</label>
                        <input type="text" name="addr_label" value="<?php echo $cp['addr_label']; ?>" id="addr_label"
                            class="frm_input" size="15">
                        <label for="addr_val" style="margin-left:20px;">내용</label>
                        <input type="text" name="addr_val" value="<?php echo $cp['addr_val']; ?>" id="addr_val"
                            class="frm_input" size="60">
                    </td>
                </tr>
                <tr>
                    <th scope="row">연락처 (Tel)</th>
                    <td>
                        <label for="tel_label">명칭</label>
                        <input type="text" name="tel_label" value="<?php echo $cp['tel_label']; ?>" id="tel_label"
                            class="frm_input" size="15">
                        <label for="tel_val" style="margin-left:20px;">내용</label>
                        <input type="text" name="tel_val" value="<?php echo $cp['tel_val']; ?>" id="tel_val"
                            class="frm_input" size="60">
                    </td>
                </tr>
                <tr>
                    <th scope="row">팩스 (Fax)</th>
                    <td>
                        <label for="fax_label">명칭</label>
                        <input type="text" name="fax_label" value="<?php echo $cp['fax_label']; ?>" id="fax_label"
                            class="frm_input" size="15">
                        <label for="fax_val" style="margin-left:20px;">내용</label>
                        <input type="text" name="fax_val" value="<?php echo $cp['fax_val']; ?>" id="fax_val"
                            class="frm_input" size="60">
                    </td>
                </tr>
                <tr>
                    <th scope="row">이메일 (Email)</th>
                    <td>
                        <label for="email_label">명칭</label>
                        <input type="text" name="email_label" value="<?php echo $cp['email_label']; ?>" id="email_label"
                            class="frm_input" size="15">
                        <label for="email_val" style="margin-left:20px;">내용</label>
                        <input type="text" name="email_val" value="<?php echo $cp['email_val']; ?>" id="email_val"
                            class="frm_input" size="60">
                    </td>
                </tr>
                <tr>
                    <th scope="row">카피라이트 (Copyright)</th>
                    <td>
                        <textarea name="copyright" id="copyright" class="frm_input"
                            style="width:100%; height:80px;"><?php echo $cp['copyright']; ?></textarea>
                        <span class="frm_info">HTML 태그 사용 가능 (예: Copyright &copy; 2024 All rights reserved.)</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">추가 링크 1</th>
                    <td>
                        <label for="link1_name">제목</label>
                        <input type="text" name="link1_name" value="<?php echo $cp['link1_name']; ?>" id="link1_name"
                            class="frm_input" size="20">
                        <label for="link1_url" style="margin-left:20px;">링크(URL)</label>
                        <input type="text" name="link1_url" value="<?php echo $cp['link1_url']; ?>" id="link1_url"
                            class="frm_input" size="60">
                    </td>
                </tr>
                <tr>
                    <th scope="row">추가 링크 2</th>
                    <td>
                        <label for="link2_name">제목</label>
                        <input type="text" name="link2_name" value="<?php echo $cp['link2_name']; ?>" id="link2_name"
                            class="frm_input" size="20">
                        <label for="link2_url" style="margin-left:20px;">링크(URL)</label>
                        <input type="text" name="link2_url" value="<?php echo $cp['link2_url']; ?>" id="link2_url"
                            class="frm_input" size="60">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="확인" class="btn_submit" accesskey="s">
    </div>
</form>


<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>