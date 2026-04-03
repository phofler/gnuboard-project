
<?php
$sub_menu = '950190';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');
include_once(G5_PATH . '/lib/theme_css.lib.php');
include_once(G5_PATH . '/extend/project_ui.extend.php');
include_once(G5_PLUGIN_PATH . '/main_content_manager/lib/main_content.lib.php');

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
        'ms_subtitle' => '',
        'ms_show_title' => 1,
        'ms_skin' => 'A',
        'ms_sort' => 0,
        'ms_active' => 1,
        'ms_lang' => 'kr',
        'ms_theme' => 'corporate',
        'ms_key' => '',
        'ms_accent_color' => 'var(--edge-color',
        'ms_content_source' => '',
        'ms_font_mode' => 'serif'
    );
}

$g5['title'] = $html_title;
include_once(G5_ADMIN_PATH . '/admin.head.php');
?>
<script src="<?php echo G5_JS_URL ?>/image_smart_manager.js"></script>
<?php

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

if (count($items) < 1) {
    for ($i = count($items) + 1; $i <= 1; $i++) {
        $items[] = array('mc_id' => 'new_' . time() . '_' . $i, 'mc_image' => '', 'mc_title' => '', 'mc_desc' => '', 'mc_link' => '', 'mc_target' => '', 'img_url' => '', 'mc_tag' => '', 'mc_subtitle' => '', 'mc_link_text' => '');
    }
}

$theme_bg_default = get_theme_css_value($config['cf_theme'], array('--bg-white', '--bg-light', '--color-bg'), '#ffffff');
?>

<div id="preview_modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:9999;">
    <div style="position:relative; width:98%; height:96%; margin:1% auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow: 0 0 40px rgba(0,0,0,0.6);">
        <button type="button" onclick="close_preview()" style="position:absolute; top:20px; right:20px; width:44px; height:44px; border:none; background:#fff; border-radius:50%; font-size:28px; cursor:pointer; color:#333; z-index:10001; box-shadow: 0 4px 15px rgba(0,0,0,0.3); line-height:44px; text-align:center; padding:0;">&times;</button>
        <iframe id="preview_frame" name="preview_frame" src="" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<style>
    #unsplash_modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7); z-index: 9999; justify-content: center; align-items: center; }
    #unsplash_modal_content { width: 98%; max-width: 1800px; height: 96%; max-height: 1200px; background: #fff; position: relative; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); margin: 1% auto; }
    #unsplash_iframe { width: 100%; height: 100%; border: none; }
    .close-modal { position: fixed; top: 20px; right: 20px; font-size: 28px; color: #333; cursor: pointer; z-index: 10000; width: 35px; height: 35px; line-height: 35px; text-align: center; background: rgba(255, 255, 255, 0.9); border-radius: 50%; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); transition: all 0.2s; }
    .close-modal:hover { background: #fff; transform: rotate(90deg); color: #d4af37; }
    
    .img-mgr-btns { display: flex; gap: 5px; margin-top: 10px; }
    .img-mgr-btns .btn { flex: 1; padding: 7px 0; font-size: 11px; }
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
                        <?php
                        if (function_exists('get_theme_lang_select_ui')) {
                            echo get_theme_lang_select_ui(array(
                                'prefix' => 'ms_',
                                'theme' => $ms['ms_theme'],
                                'lang' => $ms['ms_lang'],
                                'custom' => (isset($ms['ms_custom']) ? $ms['ms_custom'] : ''),
                                'id' => $ms['ms_key'],
                                'id_display_id' => 'ms_key_display',
                                'id_input_id' => 'ms_key'
                            ));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ms_title">섹션 메인 제목</label></th>
                    <td>
                        <input type="text" name="ms_title" value="<?php echo get_text($ms['ms_title']); ?>" id="ms_title" class="frm_input" style="width:100%; max-width:400px; font-weight:bold;" placeholder="메인 제목 입력">
                        <label style="margin-left:15px;"><input type="checkbox" name="ms_show_title" value="1" <?php echo $ms['ms_show_title'] ? 'checked' : ''; ?>> 사용자 페이지 제목 출력</label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ms_subtitle">섹션 메인 소제목</label></th>
                    <td>
                        <input type="text" name="ms_subtitle" value="<?php echo get_text($ms['ms_subtitle']); ?>" id="ms_subtitle" class="frm_input" style="width:100%; max-width:600px;" placeholder="메인 제목 아래에 표시될 간단한 설명 입력">
                    </td>
                </tr>
                <tr>
                    <th scope="row">배경 디자인 (Color)</th>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <input type="color" id="ms_bgcolor_picker" value="<?php echo isset($ms['ms_bg_color']) && $ms['ms_bg_color'] ? $ms['ms_bg_color'] : $theme_bg_default; ?>" onchange="$('#ms_bg_color').val(this.value);">
                            <input type="text" name="ms_bg_color" value="<?php echo isset($ms['ms_bg_color']) ? $ms['ms_bg_color'] : ''; ?>" id="ms_bg_color" class="frm_input" size="10" placeholder="기본값 (<?php echo $theme_bg_default; ?>)">
                            <button type="button" class="btn btn_02" onclick="reset_bgcolor()">기본값으로 복원</button>
                        </div>
                        <script>
                            var theme_bg_default = '<?php echo $theme_bg_default; ?>';
                            function reset_bgcolor() { $('#ms_bg_color').val(''); $('#ms_bgcolor_picker').val(theme_bg_default); }
                        </script>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="ms_skin">디자인 스킨</label></th>
                    <td>
                        <?php
                        if (function_exists('get_skin_select_ui')) {
                            echo get_skin_select_ui(array(
                                'name' => 'ms_skin',
                                'selected' => $ms['ms_skin'],
                                'skins_dir' => G5_PLUGIN_PATH . '/main_content_manager/skins',
                                'onclick' => 'update_ui_by_skin'
                            ));
                        }
                        ?>
                        <span id="rec_size_info" style="margin-left:15px; font-weight:bold; color:#e52727;"></span>
                        <div id="company_intro_selector" style="display:none; margin-top:10px; padding:10px; background:#f0f0f0; border:1px solid #ddd;">
                            <label style="font-weight:bold;">회사소개 컨텐츠 선택:</label>
                            <select name="ms_content_source" id="ms_content_source" class="frm_input">
                                <option value="">선택하세요</option>
                                <?php
                                $sql_co = " select co_id, co_subject from " . G5_TABLE_PREFIX . "plugin_company_add order by co_id asc ";
                                $result_co = sql_query($sql_co);
                                while ($row_co = sql_fetch_array($result_co)) {
                                    $selected = ($ms['ms_content_source'] == $row_co['co_id']) ? 'selected' : '';
                                    echo '<option value="' . $row_co['co_id'] . '" ' . $selected . '>' . $row_co['co_subject'] . ' (' . $row_co['co_id'] . ')</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </td>
                </tr>
                <script>
                    function update_ui_by_skin(skin) {
                        var skin_info = <?php 
                            $all_skins = array('A', 'B', 'C', 'D', 'philosophy_light', 'works_dark');
                            $infos = array();
                            foreach($all_skins as $s) $infos[$s] = get_mc_skin_info($s);
                            echo json_encode($infos);
                        ?>;
                        
                        var info = skin_info[skin] || {width: 800, height: 600};
                        var size_text = "(권장: " + info.width + " x " + info.height + " px)";
                        $('#rec_size_info').html(size_text);
                        
                        $('.mc-no-image-placeholder').each(function() {
                            if($(this).find('img').length == 0) {
                                $(this).html('NO IMAGE<br>' + info.width + ' x ' + info.height);
                            }
                        });

                        var is_location = (skin == 'main_loader' || skin == 'philosophy_light');
                        var item_table = $('.tbl_head01');
                        var co_selector = $('#company_intro_selector');
                        if (is_location) { item_table.hide(); co_selector.show(); } else { item_table.show(); co_selector.hide(); }
                    }
                    $(function() { update_ui_by_skin($('input[name="ms_skin"]:checked').val() || '<?php echo $ms["ms_skin"]; ?>'); });
                </script>
                <tr>
                    <th scope="row">노출 설정</th>
                    <td>
                        <input type="number" name="ms_sort" value="<?php echo $ms['ms_sort']; ?>" class="frm_input" size="5"> 순서
                        <label style="margin-left:15px;"><input type="checkbox" name="ms_active" value="1" <?php echo $ms['ms_active'] ? 'checked' : ''; ?>> 섹션 사용 활성화</label>
                        <button type="button" class="btn btn_03" style="margin-left:30px; background:#3498db; color:#fff; border:none; padding:5px 15px;" onclick="view_preview();">실시간 미리보기</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="tbl_head01 tbl_wrap">
        <h2 class="h2_frm">섹션 내부 아이템 관리</h2>
        <table id="main_content_table">
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
                    $info = get_mc_skin_info($ms['ms_skin']);
                    ?>
                    <tr>
                        <td class="td_num text-center">
                            <?php echo $i + 1; ?>
                            <input type="hidden" name="mc_id[]" value="<?php echo $mi_id; ?>">
                        </td>
                        <td class="td_left" style="padding:15px;">
                            <div style="display:flex; gap:20px;">
                                <div style="width:200px;">
                                    <div id="mc_preview_<?php echo $mi_id; ?>" class="mc-no-image-placeholder" style="width:100%; height:120px; background:#f5f5f5; border:1px solid #ddd; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#999; font-size:11px; overflow:hidden; text-align:center;">
                                        <?php if ($row['img_url']) echo '<img src="'.$row['img_url'].'" style="width:100%; height:100%; object-fit:cover;">'; else echo 'NO IMAGE<br>'.$info['width'].' x '.$info['height']; ?>
                                    </div>
                                    <input type="hidden" name="mc_image_url[<?php echo $mi_id; ?>]" id="mc_image_url_<?php echo $mi_id; ?>" value="<?php echo preg_match('/^(http|https):/i', $row['mc_image']) ? $row['mc_image'] : ''; ?>">
                                    <div class="img-mgr-btns">
                                        <button type="button" class="btn btn_03" onclick="openUnsplashPopup('<?php echo $mi_id; ?>');">이미지 변경</button>
                                        <button type="button" class="btn btn_02" style="background:#f1f1f1; border-color:#ccc; color:#666;" onclick="delete_mc_image('<?php echo $mi_id; ?>');">이미지 삭제</button>
                                    </div>
                                </div>
                                <div style="flex:1;">
                                    <div style="margin-bottom:10px; display:flex; gap:10px;">
                                        <input type="text" name="mc_subtitle[<?php echo $mi_id; ?>]" value="<?php echo get_text($row['mc_subtitle']); ?>" class="frm_input" style="flex:1;" placeholder="소제목">
                                        <input type="text" name="mc_tag[<?php echo $mi_id; ?>]" value="<?php echo get_text($row['mc_tag']); ?>" class="frm_input" style="width:100px; text-align:center;" placeholder="태그">
                                    </div>
                                    <input type="text" name="mc_title[<?php echo $mi_id; ?>]" value="<?php echo get_text($row['mc_title']); ?>" class="frm_input" style="width:100%; font-weight:bold; margin-bottom:10px;" placeholder="제목">
                                    
                                    <?php
                                    if (function_exists('get_premium_editor_ui')) {
                                        echo get_premium_editor_ui(array(
                                            'id' => 'mc_desc_' . $mi_id,
                                            'name' => 'mc_desc[' . $mi_id . ']',
                                            'value' => $row['mc_desc'],
                                            'placeholder' => '아이템 상세 설명을 입력하세요...',
                                            'height' => '100px'
                                        ));
                                    } else {
                                        echo '<textarea name="mc_desc[' . $mi_id . ']" id="mc_desc_' . $mi_id . '" class="frm_input" style="width:100%; height:100px;">'.get_text($row['mc_desc']).'</textarea>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td class="td_left" style="width:250px;">
                            <label style="font-size:11px;">연결 링크</label>
                            <input type="text" name="mc_link[<?php echo $mi_id; ?>]" value="<?php echo get_text($row['mc_link']); ?>" class="frm_input" style="width:100%; margin-bottom:10px;">
                            <label style="font-size:11px;">버튼 텍스트</label>
                            <input type="text" name="mc_link_text[<?php echo $mi_id; ?>]" value="<?php echo get_text($row['mc_link_text']); ?>" class="frm_input" style="width:100%; margin-bottom:10px;" placeholder="자세히보기">
                            <select name="mc_target[<?php echo $mi_id; ?>]" class="frm_input" style="width:100%;"><option value="">현재창</option><option value="_blank" <?php echo $row['mc_target']=='_blank'?'selected':''; ?>>새창</option></select>
                            <div style="margin-top:20px; text-align:right;"><button type="button" class="btn btn_02" style="color:red;" onclick="if(confirm('삭제하시겠습니까?')) $(this).closest('tr').remove();">항목 삭제</button></div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div style="text-align:center; padding:15px; border:1px solid #eee; border-top:none;"><button type="button" class="btn btn_03" onclick="addItem();">+ 항목 추가</button></div>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="저장하기" class="btn_submit btn">
        <a href="./list.php" class="btn btn_02">목록으로</a>
    </div>
</form>

<script>
    // SmartImageManager used for opening }
    
    
    // [UNIFIED] Global Image Manager Helpers
    function openUnsplashPopup(id) {
        SmartImageManager.open({
            id: 'mc_preview_' + id,
            mi_id: id,
            index: -1,
            callback: function(url) { receiveImageUrl(url, id); }
        });
    }

    function closeUnsplashModal() {
        $('#unsplash_modal').fadeOut(200);
    }

    function receiveImageUrl(url, id) {
        $('#mc_image_url_' + id).val(url);
        $('#mc_preview_' + id).html('<img src="' + url + '" style="width:100%; height:100%; object-fit:cover;">');
    }

    function delete_mc_image(id) {
        if(!confirm('이미지를 삭제하시겠습니까?')) return;
        
        var is_new = id.toString().indexOf('new_') > -1;
        
        if (is_new) {
            // New items are not in DB, just clear UI
            $('#mc_image_url_' + id).val('');
            var skin = $('input[name="ms_skin"]:checked').val() || 'A';
            update_ui_by_skin(skin); 
        } else {
            // [UNIFIED] Global AJAX Deletion
            $.post('<?php echo G5_ADMIN_URL; ?>/ajax.unified_image_delete.php', {
                type: 'main_content',
                id: id,
                token: $('#fmaincontent input[name="token"]').val()
            }, function(res) {
                if (res.success) {
                    $('#mc_image_url_' + id).val('');
                    var skin = $('input[name="ms_skin"]:checked').val() || 'A';
                    update_ui_by_skin(skin); 
                } else {
                    alert('삭제 중 오류가 발생했습니다: ' + (res.error || '알 수 없는 오류'));
                }
            }, 'json').fail(function() {
                alert('서버와 통신하는 중 오류가 발생했습니다.');
            });
        }
    }

    function addItem() { var count = $('#main_content_table tbody tr').length; $.ajax({ url: './ajax.add_item.php', type: 'post', data: { ms_id: '<?php echo $ms_id; ?>', count: count }, success: function(data) { $('#main_content_table tbody').append(data); var skin = $('input[name="ms_skin"]:checked').val() || 'A'; update_ui_by_skin(skin); } }); }
</script>

<?php include_once(G5_ADMIN_PATH . '/admin.tail.php'); ?>