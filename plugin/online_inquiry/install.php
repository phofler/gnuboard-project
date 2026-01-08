<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * 플러그인 자동 설치 스크립트
 * - 테이블이 없을 경우 자동으로 생성합니다.
 */

// 테이블명 (common.php에서 정의됨)
// 테이블명 (common.php에서 정의됨)
$plugin_table = G5_PLUGIN_ONLINE_INQUIRY_TABLE;
$config_table = G5_TABLE_PREFIX . 'plugin_online_inquiry_config';

// 1. Config Table Creation & Upgrade to Pattern A
if (!sql_query(" DESCRIBE {$config_table} ", false)) {
    $sql = " CREATE TABLE IF NOT EXISTS `{$config_table}` (
                `oi_id` varchar(50) NOT NULL DEFAULT '',
                `theme` varchar(50) NOT NULL DEFAULT '',
                `lang` varchar(10) NOT NULL DEFAULT '',
                `skin` varchar(50) NOT NULL DEFAULT 'basic',
                `subject` varchar(255) NOT NULL DEFAULT '',
                `content` longtext NOT NULL,
                `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`oi_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";
    sql_query($sql, true);
} else {
    // Check if we need to migrate from 'id' to 'oi_id'
    $check_old = sql_fetch(" SHOW COLUMNS FROM `{$config_table}` LIKE 'id' ");
    if ($check_old) {
        // Step 1: Add oi_id column if it doesn't exist
        $check_new = sql_fetch(" SHOW COLUMNS FROM `{$config_table}` LIKE 'oi_id' ");
        if (!$check_new) {
            sql_query(" ALTER TABLE `{$config_table}` ADD `oi_id` varchar(50) NOT NULL DEFAULT '' FIRST ");
        }

        // Step 2: Fill oi_id with a default value based on theme/lang if possible
        sql_query(" UPDATE `{$config_table}` SET `oi_id` = CONCAT(theme, '_', lang) WHERE `oi_id` = '' AND theme != '' ");
        sql_query(" UPDATE `{$config_table}` SET `oi_id` = CAST(id AS CHAR) WHERE `oi_id` = '' ");

        // Step 3: Remove AUTO_INCREMENT from 'id' first (CRITICAL FIX)
        // MySQL does not allow an AUTO_INCREMENT column to exist without being a key.
        sql_query(" ALTER TABLE `{$config_table}` MODIFY `id` INT(11) NOT NULL ");

        // Step 4: Remove old primary key and id column
        sql_query(" ALTER TABLE `{$config_table}` DROP PRIMARY KEY ");
        sql_query(" ALTER TABLE `{$config_table}` DROP COLUMN `id` ");
        sql_query(" ALTER TABLE `{$config_table}` ADD PRIMARY KEY (`oi_id`) ");
    }
}

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

// 2. Upgrade Main Table (Add Theme/Lang columns)
$row = sql_fetch(" SHOW COLUMNS FROM `{$plugin_table}` LIKE 'theme' ");
if (!$row) {
    sql_query(" ALTER TABLE `{$plugin_table}` ADD `theme` varchar(50) NOT NULL DEFAULT '' AFTER `state` ");
    sql_query(" ALTER TABLE `{$plugin_table}` ADD `lang` varchar(10) NOT NULL DEFAULT '' AFTER `theme` ");
}

// 4. Upgrade Config Table (Add Label Configuration for Pattern A)
$row = sql_fetch(" SHOW COLUMNS FROM `{$config_table}` LIKE 'label_name' ");
if (!$row) {
    sql_query(" ALTER TABLE `{$config_table}` ADD `label_name` varchar(100) NOT NULL DEFAULT 'Name' AFTER `content` ");
    sql_query(" ALTER TABLE `{$config_table}` ADD `label_phone` varchar(100) NOT NULL DEFAULT 'Phone' AFTER `label_name` ");
    sql_query(" ALTER TABLE `{$config_table}` ADD `label_msg` varchar(100) NOT NULL DEFAULT 'Message' AFTER `label_phone` ");
    sql_query(" ALTER TABLE `{$config_table}` ADD `label_submit` varchar(100) NOT NULL DEFAULT 'Submit' AFTER `label_msg` ");
}
// 5. Upgrade Config Table (Add Background Color)
$row = sql_fetch(" SHOW COLUMNS FROM `{$config_table}` LIKE 'oi_bgcolor' ");
if (!$row) {
    sql_query(" ALTER TABLE `{$config_table}` ADD `oi_bgcolor` varchar(20) NOT NULL DEFAULT '' AFTER `skin` ");
}
?>