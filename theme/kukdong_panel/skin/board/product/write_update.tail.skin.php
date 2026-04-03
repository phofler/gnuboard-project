<?php
if (!defined('_GNUBOARD_'))
    exit;

// Only for product board and update/new mode
if ($bo_table === 'product' && ($w === '' || $w === 'u')) {

    // Use G5_HTTP_BBS_URL equivalent or get_pretty_url base
    // We want to go to the View page (board.php? ... wr_id=...)

    // Base params
    $param = 'bo_table=' . $bo_table;

    // Explicitly handle 'cate' parameter
    // Priority: 1. REQUEST['cate'], 2. wr_1 (Active Category Code)
    $cate_val = '';
    if (isset($_REQUEST['cate']) && $_REQUEST['cate']) {
        $cate_val = $_REQUEST['cate'];
    } elseif (isset($wr_1) && $wr_1) {
        $cate_val = $wr_1;
    }

    if ($cate_val) {
        $param .= '&cate=' . urlencode($cate_val);
    }

    // Add qstr (includes search params, page, etc.)
    // Note: qstr might duplicate 'cate' if the extend hook works, but let's be safe.
    // If qstr already has cate, we might get double, but it's better than none. 
    // Usually qstr starts with '&', so we append it directly.
    if (isset($qstr) && $qstr) {
        // Filter out cate from qstr if we manually added it to avoid duplication?
        // simple approach: just append qstr. 
        // If duplication is an issue, we can clean qstr.
        // But browsers handle last param usually, or G5 handles it.
        $param .= $qstr;
    }

    // Force highlight_wr_id to current wr_id
    // Note: If $qstr already has it, this appends another one. 
    // PHP $_GET usually takes the last occurrence, which is what we want (this update).
    $param .= '&highlight_wr_id=' . $wr_id;

    // Construct URL
    $url = G5_BBS_URL . '/board.php?' . $param . '#page_start';

    // Redirect immediately
    goto_url($url);
}
?>