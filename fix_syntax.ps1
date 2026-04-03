$file = 'C:\gnuboard\plugin\sub_design\adm\write.php'
$content = Get-Content $file -Raw -Encoding UTF8

$old = "$row = array('sd_id' => '', 'sd_theme' => '', 'sd_lang' => 'kr', 'sd_skin' => 'standard', 'sd_layout' => 'full', 'sd_breadcrumb' => 0,, 'sd_breadcrumb_skin' => 'dropdown', 'sd_menu_table' => '');"
$new = "$row = array('sd_id' => '', 'sd_theme' => '', 'sd_lang' => 'kr', 'sd_skin' => 'standard', 'sd_layout' => 'full', 'sd_breadcrumb' => 0, 'sd_breadcrumb_skin' => 'dropdown', 'sd_menu_table' => '');"

$content = $content.Replace($old, $new)

$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
