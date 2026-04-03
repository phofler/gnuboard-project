<?php
if (!defined("_GNUBOARD_")) exit;

/**
 * [Standardization] Global Skin Context (pro_skin)
 * 모든 프리미엄 스킨이 공유하는 "Source of Truth" 전역 변수 구조
 */
global $pro_skin;
$pro_skin = array(
    'title'     => '',    // $txt_title (매뉴얼 표준)
    'desc'      => '',    // $txt_desc (매뉴얼 표준)
    'more_url'  => '',    // $more_url (매뉴얼 표준)
    'skin_cls'  => '',    // $skin_cls (레이아웃 클래스)
    'items'     => array(), // 데이터 리스트
    'options'   => array()  // 기타 설정
);

/**
 * 각 모듈의 데이터를 프리미엄 스킨 표준 변수($txt_title 등)로 매핑 및 전역화
 */
function set_pro_skin_context($data = array()) {
    global $pro_skin, $txt_title, $txt_desc, $more_url, $skin_cls, $list;

    // 1. 전역 배열 업데이트 (데이터가 있는 경우만)
    foreach ($data as $key => $val) {
        if (array_key_exists($key, $pro_skin)) {
            $pro_skin[$key] = $val;
        }
    }

    // 2. [테마스킨.md] 매뉴얼 표준 개별 전역 변수로 추출 (값이 제공된 경우만 업데이트)
    if (isset($data['title']))    $txt_title = $data['title'];
    if (isset($data['desc']))     $txt_desc  = $data['desc'];
    if (isset($data['more_url'])) $more_url  = $data['more_url'];
    if (isset($data['skin_cls'])) $skin_cls  = $data['skin_cls'];
    if (isset($data['items']))    $list      = $data['items'];
}

/**
 * 프로젝트 자산(이미지, 파일 등)의 절대 URL을 반환하는 통합 함수
 */
function get_project_asset_url($filename) {
    if (!$filename) return "";
    if (preg_match("/^(http|https):/i", $filename)) return $filename;

    $search_paths = array(
        array("path" => G5_DATA_PATH . "/common_assets", "url" => G5_DATA_URL . "/common_assets"),
        array("path" => G5_DATA_PATH . "/main_visual", "url" => G5_DATA_URL . "/main_visual"),
    );

    foreach ($search_paths as $search) {
        if (file_exists($search["path"] . "/" . $filename)) {
            return $search["url"] . "/" . $filename;
        }
    }
    return G5_DATA_URL . "/common_assets/" . $filename;
}

/**
 * 메인 비주얼 등 UI 컴포넌트의 표준 스타일 속성(CSS 변수 포함)을 생성하는 함수
 */
function get_visual_style_attrs($config = array()) {
    $attrs = array();
    if (isset($config["height"])) $attrs[] = "--hero-height: " . $config["height"];
    if (isset($config["overlay"])) $attrs[] = "--overlay-opacity: " . $config["overlay"];
    if (empty($attrs)) return "";
    return " style=\"" . implode("; ", $attrs) . ";\"";
}