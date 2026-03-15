<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// 테이블명 명명 규칙: g5_plugin_company_add
$table_name = G5_TABLE_PREFIX . 'plugin_company_add';

// 테이블 존재 여부 확인 (SHOW TABLES 사용)
$row = sql_fetch(" SHOW TABLES LIKE '{$table_name}' ");
if (!$row) {
    $sql = " CREATE TABLE IF NOT EXISTS `{$table_name}` (
                `co_id` varchar(100) NOT NULL DEFAULT '',
                `co_subject` varchar(255) NOT NULL DEFAULT '',
                `co_content` mediumtext NOT NULL,
                `co_skin` varchar(50) NOT NULL DEFAULT '',
                `co_bgcolor` varchar(20) NOT NULL DEFAULT '',
                `co_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`co_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";

    sql_query($sql, true);

    // 초기 데이터 예시 (선택사항)
    // sql_query(" insert into `{$table_name}` set co_id = 'greeting', co_subject = 'CEO 인사말', co_content = '', co_datetime = '".G5_TIME_YMDHIS."' ", false);
} else {
    // 테이블이 이미 존재한다면 컬럼 추가 확인
    $row = sql_fetch(" SHOW COLUMNS FROM `{$table_name}` LIKE 'co_bgcolor' ");
    if (!$row) {
        sql_query(" ALTER TABLE `{$table_name}` ADD `co_bgcolor` varchar(20) NOT NULL DEFAULT '#000000' AFTER `co_skin` ", true);
    }
}
?>