<?php
include_once(dirname(__FILE__) . '/../../../common.php');
include_once(dirname(__FILE__) . '/../lib/design.lib.php');
if (!defined('G5_IS_ADMIN')) define('G5_IS_ADMIN', true);

$lang = isset($_POST['lang']) ? clean_xss_tags($_POST['lang']) : 'kr';
$sd_id = isset($_POST['sd_id']) ? clean_xss_tags($_POST['sd_id']) : '';

if (!defined('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_items');
}

$menu_table = "g5_write_menu_pdc";
if ($lang != 'kr') $menu_table = "g5_write_menu_pdc_" . $lang;

$check = sql_fetch(" SHOW TABLES LIKE '$menu_table' ");
$col_prefix = 'ma';
if (!$check) {
    $menu_table = $g5['menu_table'];
    $col_prefix = 'me';
}

$code_col = $col_prefix . '_code';
$name_col = $col_prefix . '_name';

$sql = " SELECT $code_col as me_code, $name_col as me_name FROM $menu_table 
         WHERE length($code_col) IN (2, 4, 6) 
         ORDER BY $code_col ";
$result = sql_query($sql);

$menus = array();
$min_len = 99;
while ($row = sql_fetch_array($result)) {
    $menus[] = $row;
    $l = strlen($row['me_code']);
    if ($l < $min_len) $min_len = $l;
}

if (file_exists(G5_PLUGIN_PATH . '/tree_category/lib.php')) {
    include_once(G5_PLUGIN_PATH . '/tree_category/lib.php');
    $tree_cats = get_tree_categories();
    $injected_menus = array();
    foreach ($menus as $m) {
        $injected_menus[] = $m;
        $m_name = trim($m['me_name']);
        foreach ($tree_cats as $tc) {
            if ($tc['tc_name'] === $m_name && strlen($tc['tc_code']) == 2) {
                foreach ($tree_cats as $sub_tc) {
                    if (strpos($sub_tc['tc_code'], $tc['tc_code']) === 0 && $sub_tc['tc_code'] !== $tc['tc_code']) {
                        $injected_menus[] = array('me_code' => 'TC' . $sub_tc['tc_code'], 'me_name' => $sub_tc['tc_name']);
                    }
                }
                break;
            }
        }
    }
    $menus = $injected_menus;
}

for ($i = 0; $i < count($menus); $i++) {
    $row = $menus[$i];
    $me_code = $row['me_code'];
    $me_name = $row['me_name'];

    $sd_item = array('sd_main_text' => '', 'sd_sub_text' => '', 'sd_tag' => '', 'sd_visual_img' => '', 'sd_visual_url' => '', 'sd_effect' => '');
    if ($sd_id) {
        $found = sql_fetch(" SELECT * FROM " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " WHERE sd_id = '$sd_id' AND me_code = '$me_code' ");
        if ($found) $sd_item = $found;
    }

    // Effect data parsing (JSON)
    $effect = json_decode($sd_item['sd_effect'], true);
    if (!$effect) {
        $effect = array(
            'tag' => array('type' => 'fade-down', 'delay' => '200', 'duration' => '1000'),
            'main' => array('type' => 'fade-up', 'delay' => '400', 'duration' => '1000'),
            'sub' => array('type' => 'fade-up', 'delay' => '600', 'duration' => '1000')
        );
    }

    $depth = (strlen($me_code) - $min_len) / 2;
    $indent_px = $depth * 25;
    $indent = 'style="padding-left:' . $indent_px . 'px; text-align:left; ' . ($depth > 0 ? 'font-weight:normal;' : 'font-weight:bold;') . '"';
    $display_name = ($depth > 0) ? '└ ' . $me_name : $me_name;

    $sd_img_url = get_sub_design_image_url($sd_item);
    $thumb = '';
    if ($sd_img_url) {
        $thumb = '<img src="' . $sd_img_url . '" style="height:50px; border:1px solid #ddd; object-fit:cover; width:80px;">';
    }
    ?>
    <tr style="border-bottom:1px solid #eee;">
        <td class="text-center" style="font-size:11px; color:#999;">
            <?php echo $me_code; ?>
            <input type="hidden" name="me_code[]" value="<?php echo $me_code; ?>">
            <input type="hidden" name="me_name[]" value="<?php echo $me_name; ?>">
        </td>
        <td <?php echo $indent; ?>>
            <?php echo $display_name; ?>
        </td>
        <td style="padding:5px;">
            <input type="text" name="sd_main_text[]" value="<?php echo get_text($sd_item['sd_main_text']); ?>"
                class="frm_input" style="width:100% !important; box-sizing: border-box;" placeholder="MAIN TEXT">
            
            <div style="margin-top:10px; padding:8px; background:#f8f9fa; border:1px solid #e9ecef; border-radius:4px;">
                <div style="font-size:11px; font-weight:bold; margin-bottom:5px; color:#666;"><i class="fa fa-magic"></i> TEXT EFFECTS & ORDER</div>
                
                <div style="display:flex; gap:10px; align-items:center; margin-bottom:5px;">
                    <span style="width:50px; font-size:11px; color:#888;">TAG</span>
                    <select name="sd_eff_tag_type[]" class="frm_input" style="font-size:11px; height:24px; padding:0 5px;">
                        <option value="none" <?php echo $effect['tag']['type'] == 'none' ? 'selected' : ''; ?>>None</option>
                        <option value="fade-up" <?php echo $effect['tag']['type'] == 'fade-up' ? 'selected' : ''; ?>>Fade Up</option>
                        <option value="fade-down" <?php echo $effect['tag']['type'] == 'fade-down' ? 'selected' : ''; ?>>Fade Down</option>
                        <option value="zoom-in" <?php echo $effect['tag']['type'] == 'zoom-in' ? 'selected' : ''; ?>>Zoom In</option>
                        <option value="flip-left" <?php echo $effect['tag']['type'] == 'flip-left' ? 'selected' : ''; ?>>Flip Left</option>
                    </select>
                    <input type="text" name="sd_eff_tag_delay[]" value="<?php echo $effect['tag']['delay']; ?>" class="frm_input" style="width:40px; font-size:11px; height:24px; padding:0 5px;" placeholder="Delay">
                </div>

                <div style="display:flex; gap:10px; align-items:center; margin-bottom:5px;">
                    <span style="width:50px; font-size:11px; color:#888;">MAIN</span>
                    <select name="sd_eff_main_type[]" class="frm_input" style="font-size:11px; height:24px; padding:0 5px;">
                        <option value="none" <?php echo $effect['main']['type'] == 'none' ? 'selected' : ''; ?>>None</option>
                        <option value="fade-up" <?php echo $effect['main']['type'] == 'fade-up' ? 'selected' : ''; ?>>Fade Up</option>
                        <option value="fade-down" <?php echo $effect['main']['type'] == 'fade-down' ? 'selected' : ''; ?>>Fade Down</option>
                        <option value="zoom-in" <?php echo $effect['main']['type'] == 'zoom-in' ? 'selected' : ''; ?>>Zoom In</option>
                    </select>
                    <input type="text" name="sd_eff_main_delay[]" value="<?php echo $effect['main']['delay']; ?>" class="frm_input" style="width:40px; font-size:11px; height:24px; padding:0 5px;" placeholder="Delay">
                </div>

                <div style="display:flex; gap:10px; align-items:center;">
                    <span style="width:50px; font-size:11px; color:#888;">SUB</span>
                    <select name="sd_eff_sub_type[]" class="frm_input" style="font-size:11px; height:24px; padding:0 5px;">
                        <option value="none" <?php echo $effect['sub']['type'] == 'none' ? 'selected' : ''; ?>>None</option>
                        <option value="fade-up" <?php echo $effect['sub']['type'] == 'fade-up' ? 'selected' : ''; ?>>Fade Up</option>
                        <option value="zoom-in" <?php echo $effect['sub']['type'] == 'zoom-in' ? 'selected' : ''; ?>>Zoom In</option>
                    </select>
                    <input type="text" name="sd_eff_sub_delay[]" value="<?php echo $effect['sub']['delay']; ?>" class="frm_input" style="width:40px; font-size:11px; height:24px; padding:0 5px;" placeholder="Delay">
                </div>
            </div>
        </td>
        <td style="padding:5px;">
            <input type="text" name="sd_tag[]" value="<?php echo get_text($sd_item['sd_tag']); ?>"
                class="frm_input" style="width:100% !important; box-sizing: border-box; background:#fffcf0; border-color:#f1e6b2; margin-bottom:5px;"
                placeholder="TAG (ex: WHO WE ARE)">

            <input type="text" name="sd_sub_text[]" value="<?php echo get_text($sd_item['sd_sub_text']); ?>"
                class="frm_input" style="width:100% !important; box-sizing: border-box;" placeholder="SUB TEXT">
        </td>
        <td class="text-center" style="padding:5px;">
            <div style="display:flex; flex-direction:column; align-items:center; gap:4px;">
                <div class="visual-preview-box" id="preview_<?php echo $i; ?>" style="width:80px; height:50px; background:#f9f9f9; border:1px solid #eee; overflow:hidden;">
                    <?php if ($thumb) { echo $thumb; } else { echo '<div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#ccc; font-size:16px;"><i class="fa fa-picture-o"></i></div>'; } ?>
                </div>
                <div style="display:flex; gap:2px; width:100%;">
                    <button type="button" class="btn_03 btn" onclick="openImageManager(<?php echo $i; ?>)" style="flex:1; font-size:10px; padding:3px 0;">관리</button>
                    <button type="button" class="btn_02 btn" onclick="removeUrl(<?php echo $i; ?>)" style="width:24px; padding:3px 0;" title="삭제"><i class="fa fa-trash-o"></i></button>
                </div>
                <input type="hidden" name="sd_visual_url[]" id="sd_visual_url_<?php echo $i; ?>" value="<?php echo get_text($sd_item['sd_visual_url']); ?>">
            </div>
        </td>
    </tr>
<?php } ?>
<?php if ($i == 0) echo '<tr><td colspan="5" class="empty_table">해당 언어의 메뉴 데이터가 없습니다.</td></tr>'; ?>