<?php
if (!defined("_GNUBOARD_")) exit;

/**
 * 프로젝트 자산(이미지, 파일 등)의 절대 URL을 반환하는 통합 함수
 * data/common_assets, data/main_visual 등을 우선순위에 따라 검색
 */
function get_project_asset_url($filename) {
    if (!$filename) return "";
    
    // 외부 URL인 경우 그대로 반환
    if (preg_match("/^(http|https):/i", $filename)) {
        return $filename;
    }

    // 파일 탐색 우선순위 정의
    $search_paths = array(
        array("path" => G5_DATA_PATH . "/common_assets", "url" => G5_DATA_URL . "/common_assets"),
        array("path" => G5_DATA_PATH . "/main_visual", "url" => G5_DATA_URL . "/main_visual"),
    );

    foreach ($search_paths as $search) {
        if (file_exists($search["path"] . "/" . $filename)) {
            return $search["url"] . "/" . $filename;
        }
    }

    // 기본값 (G5_DATA_URL/common_assets 하위로 가정)
    return G5_DATA_URL . "/common_assets/" . $filename;
}

/**
 * 메인 비주얼 등 UI 컴포넌트의 표준 스타일 속성(CSS 변수 포함)을 생성하는 함수
 */
function get_visual_style_attrs($config = array()) {
    $attrs = array();
    
    // 높이 설정
    if (isset($config["height"])) {
        $attrs[] = "--hero-height: " . $config["height"];
    }
    
    // 오버레이 불투명도
    if (isset($config["overlay"])) {
        $attrs[] = "--overlay-opacity: " . $config["overlay"];
    }

    if (empty($attrs)) return "";

    return " style=\"" . implode("; ", $attrs) . ";\"";
}
