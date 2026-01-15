<?php
if (!defined('_GNUBOARD_'))
    exit;

// Force redirect to List with Anchor
$redirect_url = G5_HTTP_BBS_URL . '/board.php?bo_table=' . $bo_table . '&page=' . $page . $qstr;

// Preserve me_code (Context)
if (isset($_GET['me_code']) && $_GET['me_code']) {
    $redirect_url .= '&me_code=' . urlencode($_GET['me_code']);
}

// Add Anchor
$redirect_url .= '#bo_list';

// Execute Redirect
goto_url($redirect_url);
?>