<?php
include_once('./_common.php');

$bo_table = isset($_GET['bo_table']) ? trim($_GET['bo_table']) : 'Portfolio'; // Default to Portfolio

if (!$bo_table)
    die("bo_table is required");

echo "<h1>Category Sync Tool for: {$bo_table}</h1>";

// 1. Get Root Code
$sql_root = " SELECT tc_code FROM g5_tree_category_add WHERE (tc_link LIKE '%bo_table={$bo_table}%' OR tc_link = '{$bo_table}') ORDER BY tc_code ASC LIMIT 1 ";
$root_row = sql_fetch($sql_root);

if (!$root_row) {
    die("Error: No linked category found in Tree table for board '{$bo_table}'. Please check Tree Menu setup.");
}

$root_code = $root_row['tc_code'];
echo "Found Root Code: {$root_code}<br>";

// 2. Fetch All Descendants
$sql = " SELECT * FROM g5_tree_category_add WHERE tc_code LIKE '{$root_code}%' ORDER BY tc_code ASC ";
$result = sql_query($sql);

$nodes = [];
while ($row = sql_fetch_array($result)) {
    $nodes[$row['tc_code']] = $row;
}
echo "Found " . count($nodes) . " nodes.<br>";

// 3. Build Full Paths (Parent > Child)
$paths = [];

foreach ($nodes as $code => $node) {
    // Traverse up to Root
    $parts = [];
    $curr = $code;

    // Safety break
    $limit = 10;
    while ($limit-- > 0) {
        if (!isset($nodes[$curr]))
            break;

        // Prepend name
        array_unshift($parts, $nodes[$curr]['tc_name']);

        // Move to parent
        $p_len = strlen($curr) - 2;
        if ($p_len < strlen($root_code))
            break; // Don't go above root
        if ($p_len <= 0)
            break;

        $curr = substr($curr, 0, $p_len);
    }

    // Determine format
    // Strategy: Include "Unwrapped" versions if needed?
    // Usually Gnuboard category list is flat.
    // If we use "Portfolio > 기업" and also "기업" ?
    // Standard practice: "Portfolio > 기업" (Full Path).
    // BUT `category_cascade.js` unwrap logic might try to send "기업" if it unwraps usage.
    // Let's stick to "Root > Child" ? 
    // Wait, document says "Root Unwrap".
    // If Root is "Portfolio", and it's unwrapped, the dropdown shows "기업", "개인".
    // User selects "기업". JS sends "기업".
    // So the valid category in DB MUST be "기업".

    // Root Unwrap Check
    $full_path_str = implode(" > ", $parts);

    // If the first part is the Root Name (e.g. Portfolio), we might need to remove it?
    // Let's assume the board is configured to use the Leaf name if unwrap happens.
    // Actually, `category_cascade.js` tries BOTH `pathSpace` (Child) and `Root > Child`.

    // To be safe, we should add BOTH? No, bo_category_list usually strictly enumerated.
    // Let's follow the standard: If Root is "Portfolio", categories are usually "Category 1", "Category 2".
    // i.e., strict sub-categories.

    // Loop through parts starting from index 1 (removing root)?
    // If I have "Portfolio > Mobile > Case".
    // Do I want "Mobile > Case"?

    // Let's add the FULL PATH first.
    // AND if unwrap is likely, add the partial path? No that makes duplicates.

    // Decision based on `category_cascade.js` line 48:
    // "If treeData.length === 1 ... hiddenRootName = treeData[0].name"
    // Meaning correct usage is to HIDE the root name from the dropdown.
    // If hidden, user selects 'Child'. 
    // JS sends 'Child'.
    // BUT JS also checks if `Root > Child` is valid.

    // Best Approach: 
    // If depth > 0 (children of root), add "Parent > Child" WITHOUT Root Name?
    // Example: Root="Portfolio". Child="Corporate".
    // Full Path: "Portfolio > Corporate".
    // If hidden, user sees "Corporate". Selects "Corporate".
    // If DB has "Corporate", it works.
    // If DB has "Portfolio > Corporate", JS must send that.

    // `category_cascade.js` line 183: `withRoot = hiddenRootName + " > " + pathSpace`.
    // If validCategories has "Portfolio > Corporate", JS sends it!
    // So we should save FULL PATH "Portfolio > Corporate".
    // Because that is unique. "Corporate" might be ambiguous if multiple roots.

    $paths[] = $full_path_str;
}

// Filter out the Root itself if logic dictates?
// Usually the Root folder itself is not a category one posts to?
// But let's keep it just in case.

$final_list = implode("|", $paths);

// Update DB
$sql_up = " UPDATE {$g5['board_table']} SET bo_category_list = '" . sql_real_escape_string($final_list) . "' WHERE bo_table = '{$bo_table}' ";
sql_query($sql_up);

echo "<hr>";
echo "<strong>Updated bo_category_list:</strong><br>";
echo "<textarea style='width:100%; height:200px;'>{$final_list}</textarea>";
echo "<br><br>Done. Please try writing again.";
?>