<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * [Theme Standard] Post-Write Redirect Strategy
 */

$qstr_target = '';

if (isset($page) && $page)
    $qstr_target .= '&page=' . urlencode($page);

if (isset($qstr) && $qstr)
    $qstr_target .= $qstr;

// 2. Category Strategy: Use Search-based Filtering (sfl/stx)
if (isset($ca_name) && $ca_name) {
    $qstr_target = preg_replace('/&sca=[^&]*/i', '', $qstr_target);
    $qstr_target = preg_replace('/&sfl=[^&]*/i', '', $qstr_target);
    $qstr_target = preg_replace('/&stx=[^&]*/i', '', $qstr_target);

    $qstr_target .= '&sfl=ca_name&stx=' . urlencode($ca_name);
}

// 3. Menu Code (me_code)
if (isset($_REQUEST['me_code']) && $_REQUEST['me_code']) {
    $qstr_target .= '&me_code=' . urlencode($_REQUEST['me_code']);
}

// 4. Redirect with Anchor
$redirect_url = G5_BBS_URL . '/board.php?bo_table=' . $bo_table . $qstr_target . '#bo_cate';

goto_url($redirect_url);
?>