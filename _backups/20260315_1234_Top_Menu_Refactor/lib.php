<?php
if (!defined("_GNUBOARD_"))
    exit;

/**
 * 상단 메뉴 매니저 공통 라이브러리
 */

/**
 * 설정 대상 (Theme & Lang) 관리 UI 생성 함수 (공통 함수 래퍼)
 */
function get_top_menu_setting_ui($tm = array()) {
    if (function_exists("get_theme_lang_select_ui")) {
        return get_theme_lang_select_ui(array(
            "prefix" => "tm_",
            "theme" => isset($tm["tm_theme"]) ? $tm["tm_theme"] : "",
            "lang" => isset($tm["tm_lang"]) ? $tm["tm_lang"] : "kr",
            "custom" => isset($tm["tm_custom"]) ? $tm["tm_custom"] : "",
            "id" => isset($tm["tm_id"]) ? $tm["tm_id"] : ""
        ));
    }
    return "<p style=\"color:red;\">Error: get_theme_lang_select_ui() function not found.</p>";
}

/**
 * 상단 메뉴 출력 함수 (테마에서 호출)
 */
function display_top_menu()
{
    global $g5, $is_member, $is_admin, $config;

    $plugin_path = G5_PLUGIN_PATH . "/top_menu_manager";
    $skins_path = $plugin_path . "/skins";

    // 1. 설정 식별코드(ID) 결정
    // G5_TOP_MENU_ID 상수가 정의되어 있으면 우선 사용, 없으면 현재 테마명 사용
    $tm_id = defined("G5_TOP_MENU_ID") ? G5_TOP_MENU_ID : (isset($config["cf_theme"]) ? trim($config["cf_theme"]) : "kukdong_panel");

    // 다국어 처리 (익스텐션 라이브러리 설정을 따름)
    if (defined("G5_LANG") && G5_LANG != "kr" && !defined("G5_TOP_MENU_ID")) {
        $tm_id .= "_" . G5_LANG;
    }

    // 2. DB에서 설정 로드
    $tm = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");

    // 명시적인 테마명으로 재시도 (fallback)
    if (!$tm && isset($config["cf_theme"])) {
        $fallback_id = trim($config["cf_theme"]);
        $tm = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$fallback_id}' ");
    }

    if ($tm) {
        $top_menu_skin = $tm["tm_skin"] ? $tm["tm_skin"] : "basic";

        // Pro Menu Manager 테이블 정의
        if ($tm["tm_menu_table"] && !defined("G5_PRO_MENU_TABLE")) {
            define("G5_PRO_MENU_TABLE", "g5_write_menu_pdc_" . $tm["tm_menu_table"]);
        }

        // 로고 전역 변수 설정 (스킨에서 사용)
        $top_logo_pc = $tm["tm_logo_pc"] ? G5_DATA_URL . "/common/" . $tm["tm_logo_pc"] : "";
        $top_logo_mo = $tm["tm_logo_mo"] ? G5_DATA_URL . "/common/" . $tm["tm_logo_mo"] : "";

    } else {
        $top_menu_skin = "basic";
    }

    $skin_path = $skins_path . "/" . $top_menu_skin;
    $skin_url = G5_PLUGIN_URL . "/top_menu_manager/skins/" . $top_menu_skin;

    if (!file_exists($skin_path . "/menu.skin.php")) {
        return;
    }

    // 메뉴 데이터 추출 (Pro Menu Manager 연동)
    $menu_datas = array();
    $pro_menu_lib = G5_PLUGIN_PATH . "/pro_menu_manager/lib.php";
    if (file_exists($pro_menu_lib)) {
        include_once($pro_menu_lib);

        if (function_exists("get_pro_menu_list") && function_exists("build_pro_menu_tree")) {
            $raw_menus = get_pro_menu_list();
            $menu_tree = build_pro_menu_tree($raw_menus);

            foreach ($menu_tree as $root) {
                $root_mapped = array(
                    "me_name" => $root["ma_name"],
                    "me_link" => $root["ma_link"],
                    "me_target" => $root["ma_target"],
                    "me_code" => $root["ma_code"],
                    "sub" => array()
                );

                if (!empty($root["sub"])) {
                    foreach ($root["sub"] as $child) {
                        $child_mapped = array(
                            "me_name" => $child["ma_name"],
                            "me_link" => $child["ma_link"],
                            "me_target" => $child["ma_target"],
                            "me_code" => $child["ma_code"],
                            "sub" => array()
                        );

                        if (!empty($child["sub"])) {
                            foreach ($child["sub"] as $grand) {
                                $child_mapped["sub"][] = array(
                                    "me_name" => $grand["ma_name"],
                                    "me_link" => $grand["ma_link"],
                                    "me_target" => $grand["ma_target"],
                                    "me_code" => $grand["ma_code"]
                                );
                            }
                        }
                        $root_mapped["sub"][] = $child_mapped;
                    }
                }
                $menu_datas[] = $root_mapped;
            }
        }
    }

    // 스킨 스타일 로드
    if (file_exists($skin_path . "/style.css")) {
        echo "<link rel=\"stylesheet\" href=\"" . $skin_url . "/style.css?ver=" . G5_TIME_YMDHIS . "\">" . PHP_EOL;
    }

    include($skin_path . "/menu.skin.php");
}