<?php
include_once('./_common.php');

// Check g5_content table
$sql = " select * from {$g5['content_table']} ";
$result = sql_query($sql);

echo "<h3>[g5_content] Table content:</h3>";
echo "<table border='1'><tr><th>co_id</th><th>co_subject</th><th>co_skin</th></tr>";
while ($row = sql_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['co_id'] . "</td>";
    echo "<td>" . $row['co_subject'] . "</td>";
    echo "<td>" . $row['co_skin'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Check if file exists in theme
echo "<h3>Skin Check:</h3>";
echo "Theme Dir: " . G5_THEME_PATH . "<br>";
$check_path = G5_THEME_PATH . '/skin/content/intro/content.skin.php';
if (file_exists($check_path)) {
    echo "Theme Skin Found: " . $check_path . "<br>";
} else {
    echo "Theme Skin NOT Found: " . $check_path . "<br>";
}

// Check if file exists in global skin
$global_path = G5_PATH . '/skin/content/intro/content.skin.php';
if (file_exists($global_path)) {
    echo "Global Skin Found: " . $global_path . "<br>";
} else {
    echo "Global Skin NOT Found: " . $global_path . "<br>";
}

// Check current config theme
echo "Current Config Theme: " . $config['cf_theme'];
?>