<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Product Category Filtering Hook
 * Maps 'cate' parameter (Tree Category Code) to 'sca' parameter (Board Category Name)
 */

// Check if this is the product board
if (isset($_REQUEST['bo_table']) && $_REQUEST['bo_table'] === 'product') {

    $cate_param = '';
    if (isset($_REQUEST['cate']) && $_REQUEST['cate']) {
        $cate_param = trim($_REQUEST['cate']);
    }

    if ($cate_param) {
        // [GLOBAL] Append to qstr for ALL pages (list, view, write, update)
        // This ensures redirects (like after write_update) keep the parameter.
        global $qstr;
        if (isset($qstr)) {
            $qstr .= '&cate=' . urlencode($cate_param);

            // Persist highlight_wr_id if present (User Request)
            if (isset($_REQUEST['highlight_wr_id']) && $_REQUEST['highlight_wr_id']) {
                $qstr .= '&highlight_wr_id=' . urlencode($_REQUEST['highlight_wr_id']);
            }

            // Note: Anchors (#page_start) are client-side and cannot be persisted via PHP redirects easily 
            // without Javascript or specific redirect URL manipulation in write_update. 
            // However, just having the ID allows the list skin to highlight it.
        }

        // [BOARD LIST ONLY] Apply Filtering Logic (wr_1 search)
        if (basename($_SERVER['SCRIPT_NAME']) === 'board.php') {
            global $sca, $stx, $sfl, $sop;

            // Force Search Mode searching in wr_1
            $sfl = 'wr_1';
            $stx = $cate_param;
            $sop = 'and';

            $_GET['sfl'] = 'wr_1';
            $_GET['stx'] = $cate_param;
            $_GET['sop'] = 'and';

            // Disable Native Category Logic
            $sca = '';
            $_GET['sca'] = '';
            $_REQUEST['sca'] = '';
        }
    }
}
?>