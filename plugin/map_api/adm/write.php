<?php
$sub_menu = "950400";
include_once('./_common.php');
include_once('../lib/map.lib.php');
include_once(G5_LIB_PATH.'/premium_module.lib.php'); // Include Premium Framework
include_once('./check_db.php');

$html_title = '지도 설정';
$readonly = '';

if ($w == 'u') {
    $html_title .= ' 수정';
    $readonly = ' readonly';
} else {
    $html_title .= ' 입력';
}

$ma_id = isset($_REQUEST['ma_id']) ? clean_xss_tags($_REQUEST['ma_id']) : '';

$map = array();
if ($w == 'u' && $ma_id) {
    $map = sql_fetch(" SELECT * FROM {$table_name} WHERE ma_id = '{$ma_id}' ");
    if (!$map) {
        alert('존재하지 않는 자료입니다.');
    }
} else {
    // Defaults
    $map = array(
        'ma_id' => '',
        'ma_provider' => 'naver',
        'ma_lat' => '37.5665',
        'ma_lng' => '126.9780',
        'ma_api_key' => '',
        'ma_client_id' => ''
    );
}

$g5['title'] = $html_title;
include_once(G5_ADMIN_PATH . '/admin.head.php');
?>

<form name="fmapform" id="fmapform" action="./write_update.php" onsubmit="return fmapform_submit(this);" method="post">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="token" value="<?php echo get_admin_token(); ?>">

    <div class="btn_fixed_top">
        <input type="submit" value="확인" class="btn_submit btn">
        <a href="./list.php" class="btn btn_02">목록</a>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
            <caption>
                <?php echo $g5['title']; ?>
            </caption>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <?php echo render_premium_id_ui('ma_id', $map['ma_id'], $readonly); ?>

                <tr>
                    <th scope="row">지도 서비스 제공자</th>
                    <td>
                        <input type="radio" name="ma_provider" value="naver" id="p_naver" <?php echo ($map['ma_provider'] == 'naver') ? 'checked' : ''; ?>> <label for="p_naver">네이버
                            (Naver)</label>
                        &nbsp;&nbsp;
                        <input type="radio" name="ma_provider" value="google" id="p_google" <?php echo ($map['ma_provider'] == 'google') ? 'checked' : ''; ?>> <label for="p_google">구글
                            (Google)</label>
                        &nbsp;&nbsp;
                        <input type="radio" name="ma_provider" value="kakao" id="p_kakao" <?php echo ($map['ma_provider'] == 'kakao') ? 'checked' : ''; ?>> <label for="p_kakao">카카오
                            (Kakao)</label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">네이버 Client ID</th>
                    <td>
                        <input type="text" name="ma_client_id" value="<?php echo $map['ma_client_id']; ?>"
                            class="frm_input" size="50">
                        <span class="frm_info">네이버 지도 선택 시 필수</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">구글/카카오 API Key</th>
                    <td>
                        <input type="text" name="ma_api_key" value="<?php echo $map['ma_api_key']; ?>" class="frm_input"
                            size="50">
                        <span class="frm_info">구글/카카오 지도 선택 시 필수</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">위도 (Latitude)</th>
                    <td>
                        <input type="text" name="ma_lat" value="<?php echo $map['ma_lat']; ?>" class="frm_input"
                            required>
                    </td>
                </tr>
                <tr>
                    <th scope="row">경도 (Longitude)</th>
                    <td>
                        <input type="text" name="ma_lng" value="<?php echo $map['ma_lng']; ?>" class="frm_input"
                            required>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="확인" class="btn_submit" accesskey="s">
        <a href="./list.php" class="btn btn_02">목록</a>
    </div>

</form>

<script>
    function fmapform_submit(f) {
        if (jQuery('#ma_id').val() == '') {
            alert('식별코드가 생성되지 않았습니다. 테마를 선택하거나 커스텀 이름을 입력해주세요.');
            return false;
        }
        return true;
    }
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>