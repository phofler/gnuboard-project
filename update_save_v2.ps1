$file = 'C:\gnuboard\plugin\sub_design\adm\update.php'
$content = Get-Content $file -Raw -Encoding UTF8

# 1. Add variable definition
$old1 = '$sd_breadcrumb_skin = isset($_POST[''sd_breadcrumb_skin'']) ? clean_xss_tags($_POST[''sd_breadcrumb_skin'']) : ''dropdown'';'
$new1 = "`$sd_breadcrumb_skin = isset(`$_POST['sd_breadcrumb_skin']) ? clean_xss_tags(`$_POST['sd_breadcrumb_skin']) : 'dropdown';`r`n`$sd_menu_table = isset(`$_POST['sd_menu_table']) ? clean_xss_tags(`$_POST['sd_menu_table']) : '';"
$content = $content.Replace($old1, $new1)

# 2. Add to sql_common
$old2 = "sd_breadcrumb_skin = '{\$sd_breadcrumb_skin}' \";"
$new2 = "sd_breadcrumb_skin = '{\$sd_breadcrumb_skin}',`r`n                    sd_menu_table = '{\$sd_menu_table}' \";"
$content = $content.Replace($old2, $new2)

# Save using UTF8 No BOM
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
