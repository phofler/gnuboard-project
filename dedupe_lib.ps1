$file = 'C:\gnuboard\plugin\pro_menu_manager\lib.php'
$content = Get-Content $file -Raw -Encoding UTF8

# Remove duplicate function definitions
$duplicate_start = "// Generate next menu code with sequential (+1) and alphanumeric support"
$parts = $content -split [regex]::Escape($duplicate_start)

if ($parts.Count -gt 2) {
    # Keep up to the first occurrence and add only one function definition
    $new_content = $parts[0] + $duplicate_start + $parts[1]
    # Check for anything after the last duplicate that we might need (though usually it's just `?>`)
    if ($parts[-1].Trim() -eq "?>") {
        $new_content += "`n?>`n"
    }
    
    $utf8NoBom = New-Object System.Text.UTF8Encoding $false
    [System.IO.File]::WriteAllText($file, $new_content.Trim(), $utf8NoBom)
}
