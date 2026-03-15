<?php
include_once('./_common.php');
echo '<meta charset="utf-8">';

// 1. Check Tree Category Mapping for 101040
include_once(G5_PLUGIN_PATH . '/tree_category/lib.php');
$all_cats = get_tree_categories();
echo "<h3>Tree Category Check</h3>";
echo "Looking for code 101040:<br>";
$found_name = "NOT FOUND";
foreach ($all_cats as $cat) {
    if ($cat['tc_code'] == '101040') {
        echo "Code: " . $cat['tc_code'] . " => Name: [" . $cat['tc_name'] . "]<br>";
        $found_name = $cat['tc_name'];
    }
}

// 2. Check Product Table Data
echo "<h3>DB Product Table Check (g5_write_product)</h3>";
$sql = " select wr_id, wr_subject, ca_name from g5_write_product order by wr_id desc limit 10 ";
$result = sql_query($sql);
echo "<table border=1><tr><th>wr_id</th><th>Subject</th><th>ca_name (Category)</th></tr>";
while ($row = sql_fetch_array($result)) {
    $highlight = ($row['ca_name'] == $found_name) ? 'style="background:yellow"' : '';
    echo "<tr $highlight><td>{$row['wr_id']}</td><td>{$row['wr_subject']}</td><td>[{$row['ca_name']}]</td></tr>";
}
echo "</table>";
?>