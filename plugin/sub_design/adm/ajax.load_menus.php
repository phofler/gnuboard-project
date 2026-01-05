<?php
include_once(dirname(__FILE__) . '/../../../common.php');
if (!defined('G5_IS_ADMIN'))
    define('G5_IS_ADMIN', true);

$lang = isset($_POST['lang']) ? clean_xss_tags($_POST['lang']) : 'kr';
$sd_id = isset($_POST['sd_id']) ? clean_xss_tags($_POST['sd_id']) : '';

if (!defined('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_items');
}

// Determine Menu Table (Pro Menu Manager uses g5_write_menu_pdc)
$menu_table = "g5_write_menu_pdc";
if ($lang != 'kr') {
    $menu_table = "g5_write_menu_pdc_" . $lang;
}

// Check if table exists, fallback to default g5_menu if not
$check = sql_fetch(" SHOW TABLES LIKE '$menu_table' ");
$col_prefix = 'ma';
if (!$check) {
    $menu_table = $g5['menu_table'];
    $col_prefix = 'me';
}

$code_col = $col_prefix . '_code';
$name_col = $col_prefix . '_name';

// Fetch Menus (Up to 3 depths: 2, 4, 6 chars)
$sql = " SELECT $code_col as me_code, $name_col as me_name FROM $menu_table 
         WHERE length($code_col) IN (2, 4, 6) 
         ORDER BY $code_col ";
$result = sql_query($sql);

$menus = array();
$min_len = 99;
while ($row = sql_fetch_array($result)) {
    $menus[] = $row;
    $l = strlen($row['me_code']);
    if ($l < $min_len)
        $min_len = $l;
}

// Tree Category Injection Logic
if (file_exists(G5_PLUGIN_PATH . '/tree_category/lib.php')) {
    include_once(G5_PLUGIN_PATH . '/tree_category/lib.php');
    $tree_cats = get_tree_categories(); // Already filters tc_use=1, tc_menu_use=1

    $injected_menus = array();
    foreach ($menus as $m) {
        $injected_menus[] = $m;

        // Match by name for injection (only for depth 0/1 usually, but let's follow names)
        $m_name = trim($m['me_name']);
        foreach ($tree_cats as $tc) {
            // If name matches AND it's a root category (len=2), inject its subtree
            if ($tc['tc_name'] === $m_name && strlen($tc['tc_code']) == 2) {
                foreach ($tree_cats as $sub_tc) {
                    if (strpos($sub_tc['tc_code'], $tc['tc_code']) === 0 && $sub_tc['tc_code'] !== $tc['tc_code']) {
                        $injected_menus[] = array(
                            'me_code' => 'TC' . $sub_tc['tc_code'],
                            'me_name' => $sub_tc['tc_name']
                        );
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

    // Fetch existing design for this group + code
    $sd_item = array('sd_main_text' => '', 'sd_sub_text' => '', 'sd_visual_img' => '', 'sd_visual_url' => '');
    if ($sd_id) {
        $found = sql_fetch(" SELECT * FROM " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " WHERE sd_id = '$sd_id' AND me_code = '$me_code' ");
        if ($found)
            $sd_item = $found;
    }

    $depth = (strlen($me_code) - $min_len) / 2;
    $indent_px = $depth * 25;
    $indent = 'style="padding-left:' . $indent_px . 'px; ' . ($depth > 0 ? 'font-weight:normal;' : 'font-weight:bold;') . '"';
    $display_name = ($depth > 0) ? '└ ' . $me_name : $me_name;

    $thumb = '';
    if ($sd_item['sd_visual_img']) {
        $thumb = '<img src="' . G5_DATA_URL . '/sub_visual/' . $sd_item['sd_visual_img'] . '" style="height:60px; border:1px solid #ddd; object-fit:cover; width:100px;">';
    } else if ($sd_item['sd_visual_url']) {
        $thumb = '<img src="' . $sd_item['sd_visual_url'] . '" style="height:60px; border:1px solid #ddd; object-fit:cover; width:100px;">';
    }
    ?>
    <tr>
        <td class="td_num">
            <?php echo $me_code; ?>
            <input type="hidden" name="me_code[]" value="<?php echo $me_code; ?>">
        </td>
        <td <?php echo $indent; ?>>
            <?php echo $display_name; ?>
        </td>
        <td>
            <input type="text" name="sd_main_text[]" value="<?php echo get_text($sd_item['sd_main_text']); ?>"
                class="frm_input frm_input_full" placeholder="MAIN TEXT">
        </td>
        <td>
            <input type="text" name="sd_sub_text[]" value="<?php echo get_text($sd_item['sd_sub_text']); ?>"
                class="frm_input frm_input_full" placeholder="SUB TEXT">
        </td>
        <td>
            <div style="display:flex; flex-direction:column; align-items:center; gap:5px;">
                <div class="visual-preview-box" id="preview_<?php echo $i; ?>">
                    <?php if ($thumb) {
                        echo $thumb;
                    } else {
                        echo '<div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#ccc; font-size:20px;"><i class="fa fa-picture-o"></i></div>';
                    } ?>
                </div>

                <div style="display:flex; gap:4px; width:140px;">
                    <button type="button" class="btn-img-manage" onclick="openImageManager(<?php echo $i; ?>)"
                        style="flex:1;">
                        <i class="fa fa-refresh"></i> 이미지 변경 / 관리
                    </button>
                    <button type="button" class="btn-url-remove" onclick="removeUrl(<?php echo $i; ?>)" title="삭제">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>

                <input type="hidden" name="sd_visual_url[]" id="sd_visual_url_<?php echo $i; ?>"
                    value="<?php echo get_text($sd_item['sd_visual_url']); ?>">
                <!-- Keep hidden input for visual_img if file upload is still needed, or hide it -->
                <input type="file" name="sd_visual_img_<?php echo $i; ?>" style="display:none;">
            </div>
        </td>
    </tr>
<?php } ?>
<?php if ($i == 0)
    echo '<tr><td colspan="5" class="empty_table">해당 언어의 메뉴 데이터가 없습니다. 먼저 메뉴를 등록해주세요.</td></tr>'; ?>