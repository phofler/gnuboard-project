$file = 'C:\gnuboard\plugin\pro_menu_manager\lib.php'
$content = Get-Content $file -Raw -Encoding UTF8

$function_code = @'
// Generate next menu code with sequential (+1) and alphanumeric support
function get_next_pro_menu_code($parent, $max_code)
{
    if (!$max_code) {
        return $parent . "10"; // Start at 10
    }

    $last_two = substr($max_code, -2);
    
    // Sequential increment (+1) to avoid 90+10=100 overflow
    if (is_numeric($last_two)) {
        $next_val = intval($last_two) + 1;
        if ($next_val > 99) {
            // Alphanumeric fallback (a0, a1...)
            return $parent . "a0";
        } else {
            return $parent . sprintf("%02d", $next_val);
        }
    } else {
        // Alphanumeric increment logic (a0 -> a1 ... -> b0)
        $chars = "0123456789abcdefghijklmnopqrstuvwxyz";
        $c1 = substr($last_two, 0, 1);
        $c2 = substr($last_two, 1, 1);
        
        $pos2 = strpos($chars, $c2);
        if ($pos2 !== false && $pos2 < strlen($chars) - 1) {
            return $parent . $c1 . $chars[$pos2 + 1];
        } else {
            $pos1 = strpos($chars, $c1);
            if ($pos1 !== false && $pos1 < strlen($chars) - 1) {
                return $parent . $chars[$pos1 + 1] . "0";
            }
        }
    }
    
    return $parent . "zz"; // Ultimate fallback
}
'@

# Add before the last closing tag or at the end
if ($content.Contains('?>')) {
    $content = $content.Replace('?>', "`n" + $function_code + "`n?>")
} else {
    $content += "`n" + $function_code
}

$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
