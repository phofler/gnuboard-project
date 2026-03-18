$file = 'C:\gnuboard\plugin\sub_design\adm\update.php'
$content = Get-Content $file -Raw -Encoding UTF8

# Add sd_menu_table to the array cleaning logic
$content = $content -replace "\s*'sd_breadcrumb' => clean_xss_tags\(\\\$_POST\['sd_breadcrumb'\]\),", "`n    'sd_breadcrumb' => clean_xss_tags(\$_POST['sd_breadcrumb']),`n    'sd_menu_table' => clean_xss_tags(\$_POST['sd_menu_table']),"

# Save using UTF8 No BOM
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
