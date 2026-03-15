<?php
if (!defined('_GNUBOARD_'))
    exit;

// content.php 요청이면서 co_id가 있을 때 동작
if (isset($_GET['co_id']) && $_GET['co_id']) {
    $current_script = basename($_SERVER['SCRIPT_NAME']);

    // bbs/content.php에 접근했을 때만 체크
    if ($current_script == 'content.php') {
        $check_id = preg_replace('/[^a-z0-9_]/i', '', $_GET['co_id']);

        // 플러그인 테이블 존재 여부 확인 (설치 안됐을 수 있으므로)
        if (defined('G5_TABLE_PREFIX')) {
            $plugin_table = G5_TABLE_PREFIX . 'plugin_company_add';

            // 테이블이 존재하는지 간단히 체크 (불필요한 쿼리 에러 방지)
            // 성능을 위해 show tables 보다는 그냥 try catch 혹은 바로 select가 낫지만,
            // 여기서는 g5_plugin_company_add 테이블이 확실히 있을 때만 실행

            $sql = " select * from {$plugin_table} where co_id = '{$check_id}' ";
            // 에러 억제(@)를 사용해 테이블이 없을 경우를 대비하거나,
            // 더 안전하게는 한번만 체크. 보통은 그냥 쿼리 날림.

            // 주의: 이 파일은 common.php 실행 중에 include 되므로 $g5 등의 변수가 사용 가능.
            if (function_exists('sql_fetch')) {
                $co_row = sql_fetch($sql);

                if ($co_row && $co_row['co_id']) {
                    // 플러그인에 데이터가 있으면 view.php를 로드하고 종료
                    include_once(G5_PLUGIN_PATH . '/company_intro/view.php');
                    exit;
                }
            }
        }
    }
}
?>