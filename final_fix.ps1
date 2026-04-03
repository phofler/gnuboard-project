$file = 'C:\gnuboard\plugin\pro_menu_manager\update.php'
$content = @'
<?php
include_once('./_common.php');

if (!$is_admin) {
    alert('관리자만 접근 가능합니다.');
}

$menu_set = isset($_REQUEST['menu_set']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['menu_set']) : '';
$table_suffix = $menu_set ? '_' . $menu_set : '';
$table_name = "g5_write_menu_pdc" . $table_suffix;

// [NUCLEAR OPTION] Delete Process
// Standard GnuBoard pattern: Delete All -> Re-Insert All
sql_query(" delete from {$table_name} ");

// [NEW] Save Skin Setting
if (isset($_POST['top_menu_skin']) && $_POST['top_menu_skin']) {
    $new_skin = trim($_POST['top_menu_skin']);
    $setting_file = G5_PLUGIN_PATH . '/top_menu_manager/setting.php';

    // Create or Update setting.php
    $content_skin = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$top_menu_skin = '{$new_skin}';\n?>";

    $fp = fopen($setting_file, 'w');
    if ($fp) {
        fwrite($fp, $content_skin);
        fclose($fp);
    }
}

// Check if any data was submitted
if (isset($_POST['ma_name']) && is_array($_POST['ma_name'])) {
    $ma_name = $_POST['ma_name'];
    $count = count($ma_name);

    $ma_code = isset($_POST['ma_code']) ? $_POST['ma_code'] : array();
    $ma_parent_code = isset($_POST['ma_parent_code']) ? $_POST['ma_parent_code'] : array();
    $ma_link = isset($_POST['ma_link']) ? $_POST['ma_link'] : array();
    $ma_target = isset($_POST['ma_target']) ? $_POST['ma_target'] : array();
    $ma_order = isset($_POST['ma_order']) ? $_POST['ma_order'] : array();
    $ma_use = isset($_POST['ma_use']) ? $_POST['ma_use'] : array();
    $ma_mobile_use = isset($_POST['ma_mobile_use']) ? $_POST['ma_mobile_use'] : array();
    $ma_menu_use = isset($_POST['ma_menu_use']) ? $_POST['ma_menu_use'] : array();

    for ($i = 0; $i < $count; $i++) {
        $name = strip_tags(trim($ma_name[$i]));
        if (!$name)
            continue;

        $code = isset($ma_code[$i]) ? trim($ma_code[$i]) : '';
        $parent = isset($ma_parent_code[$i]) ? trim($ma_parent_code[$i]) : '';
        $link = isset($ma_link[$i]) ? trim($ma_link[$i]) : '';
        $target = isset($ma_target[$i]) ? trim($ma_target[$i]) : '';
        $order = isset($ma_order[$i]) ? (int) trim($ma_order[$i]) : 0;
        $use = isset($ma_use[$i]) ? (int) trim($ma_use[$i]) : 0;
        $mobile_use = isset($ma_mobile_use[$i]) ? (int) trim($ma_mobile_use[$i]) : 0;
        $menu_use = isset($ma_menu_use[$i]) ? (int) trim($ma_menu_use[$i]) : 0;

        // Determine Code Logic
        if ($code) {
            $final_code = $code;
        } else {
            // New Item: Generate Code based on Parent
            $len = strlen($parent) + 2;
            $like = $parent . "__";

            $sql = " select max(ma_code) as max_code from {$table_name} where ma_code like '{$like}' and length(ma_code) = {$len} ";
            $row = sql_fetch($sql);

            $max_code = $row['max_code'];
            if (!$max_code) {
                $final_code = $parent . "10"; // Start at 10
            } else {
                // Sequential increment (+1) instead of (+10) to avoid 90+10=100 overflow
                $last_two = substr($max_code, -2);
                if (is_numeric($last_two)) {
                    $next_val = intval($last_two) + 1;
                    if ($next_val > 99) {
                        // Alphanumeric fallback (a0, a1...)
                        $final_code = $parent . "a0";
                    } else {
                        $final_code = $parent . sprintf("%02d", $next_val);
                    }
                } else {
                    // Alphanumeric increment logic (a0 -> a1 ... -> b0)
                    $chars = "0123456789abcdefghijklmnopqrstuvwxyz";
                    $c1 = substr($last_two, 0, 1);
                    $c2 = substr($last_two, 1, 1);
                    $pos2 = strpos($chars, $c2);
                    if ($pos2 < strlen($chars) - 1) {
                        $final_code = $parent . $c1 . $chars[$pos2 + 1];
                    } else {
                        $pos1 = strpos($chars, $c1);
                        $final_code = $parent . $chars[$pos1 + 1] . "0";
                    }
                }
            }
        }

        $sql = " insert into {$table_name}
                    set ma_code = '{$final_code}',
                        ma_name = '{$name}',
                        ma_link = '{$link}',
                        ma_target = '{$target}',
                        ma_order = '{$order}',
                        ma_use = '{$use}',
                        ma_mobile_use = '{$mobile_use}',
                        ma_menu_use = '{$menu_use}',
                        ma_regdt = '" . G5_TIME_YMDHIS . "' ";

        sql_query($sql);
    }
}

$qstr = $menu_set ? "?menu_set=" . $menu_set : "";
alert("성공적으로 업데이트 되었습니다.", "./admin.php" . $qstr);
?>
'@
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
