$file = 'C:\gnuboard\plugin\pro_menu_manager\update.php'
$content = Get-Content $file -Raw -Encoding UTF8

$search = @'
            } else {
                // Increment
                $last_two = substr($max_code, -2);
                $next_val = intval($last_two) + 10;
                $final_code = $parent . $next_val;
            }
'@.Trim()

$replace = @'
            } else {
                // Increment by 1 instead of 10 to support up to 99 items per level (e.g., 10, 11, 12... 99)
                $last_two = substr($max_code, -2);
                
                if (is_numeric($last_two)) {
                    $next_val = intval($last_two) + 1;
                    if ($next_val > 99) {
                        // Overflow to alphanumeric if needed (a0, a1...)
                        $final_code = $parent . 'a0';
                    } else {
                        $final_code = $parent . sprintf("%02d", $next_val);
                    }
                } else {
                    // Handle alphanumeric increment (a0 -> a1 -> ... -> b0)
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
'@.Trim()

if ($content.Contains($search)) {
    $content = $content.Replace($search, $replace)
}

$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
