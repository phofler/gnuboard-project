<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// [CUSTOM] Redirect to List Page (Filtered by Category)
// Update $qstr to include the NEW category
// $qstr already contains the old query string. We need to replace or append the new sca.

// Remove existing category/search params from $qstr to prevent conflicts
$qstr = preg_replace("/&amp;(sca|sfl|stx)=[^&]*/", "", $qstr);
$qstr = preg_replace("/&(sca|sfl|stx)=[^&]*/", "", $qstr);

if ($ca_name) {
    // Normalize spacing for DB matching (Policy 29-B, 30-B)
    $ca_name = preg_replace('/\s*>\s*/', ' > ', trim($ca_name));
    // [FIX] Use SEARCH mode (stx) for robustness, matching list.skin.php strategy
    $qstr .= '&sfl=ca_name&stx=' . urlencode($ca_name);
}

// me_code propagation
if (isset($_REQUEST['me_code'])) {
    if (strpos($qstr, 'me_code') === false) {
        $qstr .= '&amp;me_code=' . urlencode($_REQUEST['me_code']);
    }
}

// Re-construct the redirect URL to point to board.php (List) instead of view
// Global $redirect_url is used by bbs/write_update.php at the very end.
// We overwrite it here.

// Redirect to Board List (instead of View)
// We must echo or goto_url directly because bbs/write_update.php overwrites $redirect_url later.
$redirect_url = G5_HTTP_BBS_URL . '/board.php?bo_table=' . $bo_table . str_replace('&amp;', '&', $qstr) . '#bo_cate';

// If file upload message exists, use alert.
if ($file_upload_msg) {
    alert($file_upload_msg, $redirect_url);
} else {
    goto_url($redirect_url);
}
exit; // Prevent further execution in bbs/write_update.php
?>