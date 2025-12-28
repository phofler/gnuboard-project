<?php
$file = 'config.php';
$content = file_get_contents($file);
if ($content === false) {
    echo "Error reading file";
    exit;
}
$new_content = str_replace("define('G5_DOMAIN', '');", "define('G5_DOMAIN', 'http://localhost');", $content);
if ($content === $new_content) {
    echo "No change needed or string not found";
} else {
    file_put_contents($file, $new_content);
    echo "Fixed G5_DOMAIN";
}
?>