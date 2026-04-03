$file = 'C:\gnuboard\plugin\sub_design\adm\ajax.load_menus.php'
$content = Get-Content $file -Raw -Encoding UTF8

# 1. Add sd_menu_table retrieval
$search1 = @'
$sd_id = isset($_POST['sd_id']) ? clean_xss_tags($_POST['sd_id']) : '';
'@.Trim()

$replace1 = @'
$sd_id = isset($_POST['sd_id']) ? clean_xss_tags($_POST['sd_id']) : '';
$sd_menu_table = isset($_POST['sd_menu_table']) ? clean_xss_tags($_POST['sd_menu_table']) : '';
'@.Trim()

# 2. Add logic to use sd_menu_table
$search2 = @'
$menu_table = "g5_write_menu_pdc";
if ($lang != 'kr') $menu_table = "g5_write_menu_pdc_" . $lang;
'@.Trim()

$replace2 = @'
$menu_table = "g5_write_menu_pdc";
if ($sd_menu_table) {
    if ($sd_menu_table != 'default') $menu_table = "g5_write_menu_pdc_" . $sd_menu_table;
} else if ($lang != 'kr') {
    $menu_table = "g5_write_menu_pdc_" . $lang;
}
'@.Trim()

# String.Replace
if ($content.Contains($search1)) {
    $content = $content.Replace($search1, $replace1)
}
if ($content.Contains($search2)) {
    $content = $content.Replace($search2, $replace2)
}

$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
