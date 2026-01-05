<?php
include_once('./common.php');

if (!$is_admin) {
    die('관리자만 접근 가능합니다.');
}

echo "<h3>Main Image Manager DB Repair</h3>";

// 1. Column Type Sync
sql_query(" ALTER TABLE `g5_plugin_main_image_add` MODIFY `mi_style` VARCHAR(50) NOT NULL DEFAULT 'basic' ");
echo "<li>mi_style 컬럼 타입을 VARCHAR(50)으로 변경했습니다.</li>";

// 2. Data Migration Mapping
$map = array(
    'A' => 'basic',
    'B' => 'full',
    'C' => 'fade'
);

foreach ($map as $old => $new) {
    $res = sql_query(" UPDATE `g5_plugin_main_image_add` SET mi_style = '{$new}' WHERE mi_style = '{$old}' ");
    $affected = sql_affected_rows();
    echo "<li>데이터 변환: {$old} -> {$new} ({$affected}건 수정됨)</li>";
}

echo "<hr><p>복구가 완료되었습니다. 이제 main.lib.php의 레거시 매핑을 제거하겠습니다.</p>";
?>