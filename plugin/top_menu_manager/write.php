<?php
$sub_menu = "950150";
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!$is_admin) {
    alert('관리자만 접근 가능합니다.');
}

$tm_id = isset($_REQUEST['tm_id']) ? $_REQUEST['tm_id'] : '';
$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';

$plugin_path = G5_PLUGIN_PATH . '/top_menu_manager';
$skins_path = $plugin_path . '/skins';

// 1. 기본값 설정
$tm = array(
    'tm_id' => '',
    'tm_theme' => '',
    'tm_lang' => 'kr',
    'tm_custom' => '',
    'tm_skin' => 'basic',
    'tm_menu_table' => '',
    'tm_logo_pc' => '',
    'tm_logo_mo' => ''
);

// 2. 수정 모드일 때 데이터 로드
if ($w == 'u' && $tm_id) {
    $tm = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");
    if (!$tm) alert('존재하지 않는 설정입니다.');
    
    // 이전 데이터(신규 컬럼 도입 전) 복구 로직 (하위 호환성)
    if (!$tm['tm_theme']) {
        $parts = explode('_', $tm['tm_id']);
        if (isset($parts[1]) && in_array($parts[1], array('en', 'jp', 'cn'))) {
            $tm['tm_theme'] = $parts[0];
            $tm['tm_lang'] = $parts[1];
            unset($parts[0], $parts[1]);
            $tm['tm_custom'] = implode('_', $parts);
        } else {
            $tm['tm_theme'] = $parts[0];
            $tm['tm_lang'] = 'kr';
            unset($parts[0]);
            $tm['tm_custom'] = implode('_', $parts);
        }
    }
}

// 3. 스킨 목록 가져오기
$skins = array();
$dir = dir($skins_path);
while ($entry = $dir->read()) {
    if ($entry == '.' || $entry == '..') continue;
    if (is_dir($skins_path . '/' . $entry)) $skins[] = $entry;
}
$dir->close();

$priority_order = array('basic', 'centered', 'modern', 'transparent', 'minimal');
usort($skins, function ($a, $b) use ($priority_order) {
    $pos_a = array_search($a, $priority_order);
    $pos_b = array_search($b, $priority_order);
    if ($pos_a === false) $pos_a = 999;
    if ($pos_b === false) $pos_b = 999;
    return $pos_a - $pos_b;
});

// 라이브러리 로드 (get_top_menu_setting_ui 함수 포함)
include_once($plugin_path . '/lib.php');

$g5['title'] = "상단 메뉴 설정 " . ($w == 'u' ? '수정' : '추가');
include_once(G5_ADMIN_PATH . '/admin.head.php');
?>

<form name="fconfig" method="post" action="./update.php" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="token" value="<?php echo get_admin_token(); ?>">
    <input type="hidden" name="tm_id_org" value="<?php echo $tm['tm_id']; ?>">

    <div class="tbl_frm01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?></caption>
            <colgroup>
                <col width="150">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row">설정 대상 (Theme & Lang)</th>
                    <td>
                        <?php 
                        if (function_exists('get_top_menu_setting_ui')) {
                            echo get_top_menu_setting_ui($tm); 
                        } else {
                            echo '<p style="color:red;">Error: get_top_menu_setting_ui() 함수가 lib.php에 정의되지 않았습니다.</p>';
                        }
                        ?>
                        
                        <div style="margin-top:5px; color:#6b7280; font-size:12px;">
                            연결될 메뉴 데이터: <strong id="display_menu_table_info" style="color:#111827;"><?php echo ($tm['tm_lang']=='kr'?'기본 (Default)':'g5_write_menu_pdc_'.$tm['tm_lang']); ?></strong>
                        </div>
                        <input type="hidden" name="tm_menu_table" id="tm_menu_table" value="<?php echo $tm['tm_menu_table']; ?>">

                        <script>
                        // 추가적인 메핑 정보 동기화 (JS)
                        function sync_menu_table_info() {
                            var lang = document.getElementById('tm_lang').value;
                            var table_info = (lang === 'kr') ? '기본 (Default)' : 'g5_write_menu_pdc_' + lang;
                            document.getElementById('tm_menu_table').value = (lang === 'kr') ? '' : lang;
                            document.getElementById('display_menu_table_info').innerText = table_info;
                        }

                        // lib.php의 generate_tm_id를 확장
                        var org_generate_tm_id = generate_tm_id;
                        generate_tm_id = function() {
                            org_generate_tm_id();
                            sync_menu_table_info();
                        };
                        </script>
                    </td>
                </tr>

                <tr>
                    <th scope="row">스킨 선택</th>
                    <td>
                        <div style="display:flex; flex-wrap:wrap; gap:12px;">
                            <?php foreach ($skins as $skin) {
                                $checked = ($skin == $tm['tm_skin']) ? 'checked' : '';
                                ?>
                                <label style="display:flex; align-items:center; gap:8px; border:1px solid #e5e7eb; padding:8px 12px; border-radius:6px; cursor:pointer; min-width:120px; transition:all 0.2s;" onmouseover="this.style.borderColor='#9ca3af'" onmouseout="this.style.borderColor='#e5e7eb'">
                                    <input type="radio" name="tm_skin" value="<?php echo $skin; ?>" <?php echo $checked; ?> style="width:16px; height:16px;">
                                    <span style="font-weight:600; color:#374151;"><?php echo ucfirst($skin); ?></span>
                                </label>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">PC 로고</th>
                    <td>
                        <input type="file" name="tm_logo_pc" class="frm_input">
                        <?php if ($tm['tm_logo_pc']) {
                            echo '<div style="margin-top:10px; display:flex; align-items:center; gap:15px; padding:10px; background:#f3f4f6; border-radius:6px;">';
                            echo '<img src="' . G5_DATA_URL . '/common/' . $tm['tm_logo_pc'] . '" style="max-height:40px; border:1px solid #ddd; background:#fff;">';
                            echo '<label style="color:#ef4444; font-size:12px; cursor:pointer;"><input type="checkbox" name="del_logo_pc" value="1"> 기존 파일 삭제</label>';
                            echo '</div>';
                        } ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">모바일 로고</th>
                    <td>
                        <input type="file" name="tm_logo_mo" class="frm_input">
                        <?php if ($tm['tm_logo_mo']) {
                            echo '<div style="margin-top:10px; display:flex; align-items:center; gap:15px; padding:10px; background:#f3f4f6; border-radius:6px;">';
                            echo '<img src="' . G5_DATA_URL . '/common/' . $tm['tm_logo_mo'] . '" style="max-height:40px; border:1px solid #ddd; background:#fff;">';
                            echo '<label style="color:#ef4444; font-size:12px; cursor:pointer;"><input type="checkbox" name="del_logo_mo" value="1"> 기존 파일 삭제</label>';
                            echo '</div>';
                        } ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="설정 저장" class="btn_submit" style="padding:10px 25px; font-size:1.1em; font-weight:bold;">
        <button type="button" class="btn btn_03" onclick="view_preview();" style="padding:10px 20px;">미리보기</button>
        <a href="./list.php" class="btn btn_02" style="padding:10px 20px;">목록으로</a>
    </div>
</form>

<script>
    function view_preview() {
        var f = document.fconfig;
        var skin = '';
        var skins = document.getElementsByName("tm_skin");
        for (var i = 0; i < skins.length; i++) {
            if (skins[i].checked) { skin = skins[i].value; break; }
        }
        var menu_table = f.tm_menu_table.value;
        var url = "./preview_style.php?skin=" + skin + "&menu_table=" + menu_table;

        var modal = document.getElementById('preview_modal');
        var frame = document.getElementById('preview_frame');
        frame.src = url;
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function close_preview() {
        var modal = document.getElementById('preview_modal');
        var frame = document.getElementById('preview_frame');
        modal.style.display = 'none';
        frame.src = '';
        document.body.style.overflow = '';
    }
</script>

<div id="preview_modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999;">
    <div style="position:relative; width:95%; height:92%; margin:2.5% auto; background:#fff; border-radius:8px; overflow:hidden;">
        <button type="button" onclick="close_preview()" style="position:absolute; top:15px; right:15px; width:40px; height:40px; border:none; background:#fff; border-radius:50%; font-size:24px; cursor:pointer; color:#000; z-index:10001; line-height:40px; text-align:center; box-shadow:0 0 10px rgba(0,0,0,0.2);">&times;</button>
        <iframe id="preview_frame" name="preview_frame" src="" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<?php include_once(G5_ADMIN_PATH . '/admin.tail.php'); ?>