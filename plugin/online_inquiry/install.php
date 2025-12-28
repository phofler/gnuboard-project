<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * 플러그인 자동 설치 스크립트
 * - 테이블이 없을 경우 자동으로 생성합니다.
 */

// 테이블명 (common.php에서 정의됨)
$plugin_table = G5_PLUGIN_ONLINE_INQUIRY_TABLE;

// 테이블 존재 여부 확인
$row = sql_fetch(" SHOW TABLES LIKE '{$plugin_table}' ");
if (!isset($row[0])) {

    // 테이블 생성 쿼리 (Strict Mode 호환)
    $sql = " CREATE TABLE IF NOT EXISTS `{$plugin_table}` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(50) NOT NULL DEFAULT '',
        `contact` varchar(50) NOT NULL DEFAULT '',
        `email` varchar(100) NOT NULL DEFAULT '',
        `subject` varchar(255) NOT NULL DEFAULT '',
        `content` text NOT NULL,
        `ip` varchar(255) NOT NULL DEFAULT '',
        `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `admin_memo` text NOT NULL,
        `state` varchar(20) NOT NULL DEFAULT '접수', 
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";

    // 테이블 생성 실행
    sql_query($sql);
}
?>