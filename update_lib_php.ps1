$file = 'C:\gnuboard\plugin\sub_design\lib\design.lib.php'
$content = Get-Content $file -Raw -Encoding UTF8

# 1. Add logic to get_sub_design to define G5_PRO_MENU_TABLE
$search1 = @'
    $res = array_merge($sd, (array)$item);
    $res['active_me_code'] = $me_code;
    
    return $res;
}
'@.Trim()

$replace1 = @'
    $res = array_merge($sd, (array)$item);
    $res['active_me_code'] = $me_code;

    // Define Pro Menu Table if set in sub_design group
    if (isset($res['sd_menu_table']) && $res['sd_menu_table'] && !defined('G5_PRO_MENU_TABLE')) {
        $suffix = ($res['sd_menu_table'] == 'default') ? '' : '_' . $res['sd_menu_table'];
        define('G5_PRO_MENU_TABLE', 'g5_write_menu_pdc' . $suffix);
    }
    
    return $res;
}
'@.Trim()

if ($content.Contains($search1)) {
    $content = $content.Replace($search1, $replace1)
}

$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
