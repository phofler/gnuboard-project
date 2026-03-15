<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * 플러그인 아이템의 이미지를 DB에서 비우고 물리 파일도 삭제하는 공통 함수
 */
function clear_plugin_item_image($type, $id) {
    global $g5, $config;
    
    $id = (int)$id;
    if (!$id) return false;
    
    $table = "";
    $col = "";
    $pk = "";
    
    switch ($type) {
        case 'main_content':
            $table = "g5_plugin_main_content";
            $col = "mc_image";
            $pk = "mc_id";
            break;
        case 'main_image':
            $table = "g5_plugin_main_image_add";
            $col = "mi_image";
            $pk = "mi_id";
            break;
        default:
            return false;
    }
    
    // 1. 기존 데이터 조회 (파일 삭제를 위해)
    $row = sql_fetch(" select {$col} from {$table} where {$pk} = '{$id}' ");
    if ($row && $row[$col]) {
        $img_path = $row[$col];
        
        // URL 형태인 경우 파일명 추출
        if (preg_match("/^(http|https):/i", $img_path)) {
            $filename = basename($img_path);
            
            // 테마 폴더 포함 여부 확인
            $theme_name = isset($config['cf_theme']) ? $config['cf_theme'] : '';
            
            // 삭제 시도 경로 리스트
            $paths_to_check = array(
                G5_DATA_PATH . '/common_assets/' . $filename,
                G5_DATA_PATH . '/common_assets/' . $theme_name . '/' . $filename,
                G5_DATA_PATH . '/main_visual/' . $filename // Main Image Manager 대응
            );
            
            foreach($paths_to_check as $path) {
                if (file_exists($path)) {
                    @unlink($path);
                }
            }
        } else {
            // 파일명만 있는 경우 (Legacy)
            $filename = $img_path;
            $paths_to_check = array(
                G5_DATA_PATH . '/common_assets/' . $filename,
                G5_DATA_PATH . '/main_visual/' . $filename
            );
            foreach($paths_to_check as $path) {
                if (file_exists($path)) {
                    @unlink($path);
                }
            }
        }
    }
    
    // 2. DB 업데이트
    $sql = " update {$table} set {$col} = '' where {$pk} = '{$id}' ";
    return sql_query($sql);
}
?>