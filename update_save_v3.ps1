$file = 'C:\gnuboard\plugin\sub_design\adm\update.php'
$content = Get-Content $file -Raw -Encoding UTF8

# Define search and replace as literal here-strings
$search1 = @'
$sd_breadcrumb_skin = isset($_POST['sd_breadcrumb_skin']) ? clean_xss_tags($_POST['sd_breadcrumb_skin']) : 'dropdown';
'@.Trim()

$replace1 = @'
$sd_breadcrumb_skin = isset($_POST['sd_breadcrumb_skin']) ? clean_xss_tags($_POST['sd_breadcrumb_skin']) : 'dropdown';
$sd_menu_table = isset($_POST['sd_menu_table']) ? clean_xss_tags($_POST['sd_menu_table']) : '';
'@.Trim()

$search2 = @'
                    sd_breadcrumb_skin = '{$sd_breadcrumb_skin}' ";
'@.Trim()

$replace2 = @'
                    sd_breadcrumb_skin = '{$sd_breadcrumb_skin}',
                    sd_menu_table = '{$sd_menu_table}' ";
'@.Trim()

# String.Replace handles literals safely
if ($content.Contains($search1)) {
    $content = $content.Replace($search1, $replace1)
} else {
    Write-Error "Could not find Search1"
}

if ($content.Contains($search2)) {
    $content = $content.Replace($search2, $replace2)
} else {
    Write-Error "Could not find Search2"
}

$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
