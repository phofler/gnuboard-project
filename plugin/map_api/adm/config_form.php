<?php
$sub_menu = "800400";
define('G5_IS_ADMIN', true);
include_once(dirname(__FILE__) . '/../../../common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');
include_once(dirname(__FILE__) . '/../hook.php');

if (!defined('G5_ADMIN_PATH')) {
    define('G5_ADMIN_PATH', G5_PATH . '/adm');
    include_once(G5_ADMIN_PATH . '/admin.lib.php');
}

auth_check_menu($auth, $sub_menu, 'w');

$g5['title'] = '지도 API 관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');

// Load existing config
$config_file = G5_DATA_PATH . '/map_api_config.php';
$map_config = array();
if (file_exists($config_file)) {
    $map_config = include($config_file);
}

// Defaults
if (!isset($map_config['provider']))
    $map_config['provider'] = 'naver';
if (!isset($map_config['lat']))
    $map_config['lat'] = '37.5665';
if (!isset($map_config['lng']))
    $map_config['lng'] = '126.9780';
if (!isset($map_config['client_id']))
    $map_config['client_id'] = '';
if (!isset($map_config['api_key']))
    $map_config['api_key'] = '';
?>

<form name="fmapapi" id="fmapapi" action="./config_form_update.php" onsubmit="return fmapapi_submit(this);"
    method="post" enctype="multipart/form-data">
    <input type="hidden" name="token" value="<?php echo get_admin_token(); ?>">

    <div class="tbl_frm01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?></caption>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row"><label for="provider">지도 서비스 선택</label></th>
                    <td>
                        <input type="radio" name="provider" value="naver" id="provider_naver" <?php echo ($map_config['provider'] == 'naver') ? 'checked' : ''; ?>>
                        <label for="provider_naver">네이버 지도 (Naver)</label>
                        &nbsp;&nbsp;
                        <input type="radio" name="provider" value="google" id="provider_google" <?php echo ($map_config['provider'] == 'google') ? 'checked' : ''; ?>>
                        <label for="provider_google">구글 지도 (Google)</label>
                        &nbsp;&nbsp;
                        <input type="radio" name="provider" value="kakao" id="provider_kakao" <?php echo ($map_config['provider'] == 'kakao') ? 'checked' : ''; ?>>
                        <label for="provider_kakao">카카오 맵 (Kakao)</label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="client_id">네이버 Client ID</label></th>
                    <td>
                        <input type="text" name="client_id" value="<?php echo $map_config['client_id']; ?>"
                            id="client_id" class="frm_input" size="50">
                        <span class="frm_info">네이버 클라우드 플랫폼에서 발급받은 Client ID를 입력하세요. (네이버 지도 선택 시 필수)</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="api_key">구글/카카오 API Key</label></th>
                    <td>
                        <input type="text" name="api_key" value="<?php echo $map_config['api_key']; ?>" id="api_key"
                            class="frm_input" size="50">
                        <span class="frm_info">구글/카카오 선택 시 API Key 필수. (카카오는 JavaScript 키 입력)</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="lat">기본 위도 (Latitude)</label></th>
                    <td>
                        <input type="text" name="lat" value="<?php echo $map_config['lat']; ?>" id="lat"
                            class="frm_input" required>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="lng">기본 경도 (Longitude)</label></th>
                    <td>
                        <input type="text" name="lng" value="<?php echo $map_config['lng']; ?>" id="lng"
                            class="frm_input" required>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="확인" class="btn_submit" accesskey="s">
    </div>

</form>

<script>
    function fmapapi_submit(f) {
        return true;
    }
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>