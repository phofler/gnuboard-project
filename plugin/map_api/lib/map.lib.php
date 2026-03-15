<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Map Display Function
 * @param string $width  Width (e.g., 100%, 500px)
 * @param string $height Height (e.g., 400px)
 * @param string $map_id Optional specific Map ID (e.g. 'corporate_busan')
 */
function display_map_api($width = '100%', $height = '400px', $map_id = '')
{
    global $g5, $config;

    // 1. Load Shared Header (Standardization)
    include_once(G5_PLUGIN_PATH . '/map_api/skin.head.php');

    $map_title = isset($config['cf_title']) && $config['cf_title'] ? $config['cf_title'] : 'Location';
    // Split title for display
    $map_title_display = str_replace('환경디자인', '<br><span style="font-weight:normal;">환경디자인', $map_title);
    if (strpos($map_title_display, '환경디자인') !== false) {
        $map_title_display .= '</span>';
    }
    $map_title_js = addslashes($map_title_display);

    // [PATTERN A] Dynamic Config Loading
    $table_name = G5_TABLE_PREFIX . 'plugin_map_api';
    $map_config = false;

    // 1. Try Specific ID if provided
    if ($map_id) {
        $map_config = sql_fetch(" SELECT * FROM {$table_name} WHERE ma_id = '{$map_id}' ");
    }

    // 2. Auto-Detection (Context Aware) if no specific ID or specific ID not found
    if (!$map_config) {
        $theme_id = isset($config['cf_theme']) ? $config['cf_theme'] : 'default';
        $lang = isset($_GET['lang']) ? $_GET['lang'] : (defined('G5_LANG') ? G5_LANG : 'kr');

        // Unified Lang: ko and kr are treated the same for detection
        $is_korean = ($lang == 'kr' || $lang == 'ko');
        $target_id = $theme_id . ($is_korean ? '' : '_' . $lang);

        $map_config = sql_fetch(" SELECT * FROM {$table_name} WHERE ma_id = '{$target_id}' ");

        // Fallback: If not found and it's Korean, try searching with _ko or _kr suffix (Old Style)
        if (!$map_config && $is_korean) {
            $map_config = sql_fetch(" SELECT * FROM {$table_name} WHERE ma_id = '{$theme_id}_ko' ");
            if (!$map_config) {
                $map_config = sql_fetch(" SELECT * FROM {$table_name} WHERE ma_id = '{$theme_id}_kr' ");
            }
        }

        if (!$map_config) {
            $map_config = sql_fetch(" SELECT * FROM {$table_name} WHERE ma_id = '{$theme_id}' ");
        }
        if (!$map_config) {
            $map_config = sql_fetch(" SELECT * FROM {$table_name} WHERE ma_id = 'default' ");
        }
    }

    // 3. Backward Compatibility (File-based)
    if (!$map_config) {
        $config_file = G5_DATA_PATH . '/map_api_config.php';
        if (file_exists($config_file)) {
            $file_config = include($config_file);
            if ($file_config) {
                $map_config = array(
                    'ma_provider' => $file_config['provider'],
                    'ma_lat' => $file_config['lat'],
                    'ma_lng' => $file_config['lng'],
                    'ma_api_key' => $file_config['api_key'],
                    'ma_client_id' => $file_config['client_id']
                );
            }
        }
    }

    // Fallback UI
    if (!$map_config) {
        return '<div class="map-api-wrapper" style="padding:40px; text-align:center;">Map API setup required via Admin.</div>';
    }

    if (!$map_config['ma_api_key'] && !$map_config['ma_client_id']) {
        return '<div class="map-api-wrapper" style="padding:40px; text-align:center;">API Key missing.</div>';
    }

    $provider = isset($map_config['ma_provider']) ? $map_config['ma_provider'] : 'naver';
    $lat = isset($map_config['ma_lat']) ? $map_config['ma_lat'] : '37.5665';
    $lng = isset($map_config['ma_lng']) ? $map_config['ma_lng'] : '126.9780';
    $api_key = isset($map_api_key) ? trim($map_api_key) : (isset($map_config['ma_api_key']) ? trim($map_config['ma_api_key']) : '');
    $client_id = isset($map_client_id) ? trim($map_client_id) : (isset($map_config['ma_client_id']) ? trim($map_config['ma_client_id']) : '');

    // Standardized Wrapper & Container
    $html = '<div class="map-api-wrapper" style="width:' . $width . '; height:' . $height . ';">';
    $html .= '<div id="map_api_container" class="map-api-container"></div>';
    $html .= '</div>';

    // Info Window Template (Standardized)
    $iw_html = '<div class="map-api-info-window"><strong>' . $map_title_js . '</strong></div>';

    if ($provider == 'naver') {
        $html .= '<script type="text/javascript" src="https://oapi.map.naver.com/openapi/v3/maps.js?ncpClientId=' . $client_id . '"></script>';
        $html .= '<script>
        window.addEventListener("load", function() {
            if (typeof naver === "undefined") return;
            var center = new naver.maps.LatLng(' . $lat . ', ' . $lng . ');
            var map = new naver.maps.Map("map_api_container", { center: center, zoom: 17 });
            var marker = new naver.maps.Marker({ position: center, map: map });
            var infowindow = new naver.maps.InfoWindow({
                content: \'' . $iw_html . '\',
                borderWidth: 0,
                disableAnchor: true,
                backgroundColor: "transparent"
            });
            infowindow.open(map, marker);
            window.addEventListener("resize", function() { map.setCenter(center); });
        });
        </script>';
    } else if ($provider == 'google') {
        $html .= '<script src="https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&callback=initMap" async defer></script>';
        $html .= '<script>
        function initMap() {
            if (typeof google === "undefined") return;
            var location = {lat: ' . $lat . ', lng: ' . $lng . '};
            var map = new google.maps.Map(document.getElementById("map_api_container"), { zoom: 17, center: location });
            var marker = new google.maps.Marker({ position: location, map: map });
            var infowindow = new google.maps.InfoWindow({ content: \'' . $iw_html . '\' });
            infowindow.open(map, marker);
            window.addEventListener("resize", function() { map.setCenter(location); });
        }
        </script>';
    } else if ($provider == 'kakao') {
        $html .= '<script type="text/javascript" src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=' . $api_key . '&libraries=services"></script>';
        $html .= '<script>
        window.addEventListener("load", function() {
            if (typeof kakao === "undefined") return;
            var container = document.getElementById("map_api_container");
            var pos = new kakao.maps.LatLng(' . $lat . ', ' . $lng . ');
            var map = new kakao.maps.Map(container, { center: pos, level: 3 });
            var marker = new kakao.maps.Marker({ position: pos });
            marker.setMap(map);
            var infowindow = new kakao.maps.InfoWindow({ position : pos, content : \'' . $iw_html . '\', removable : false });
            infowindow.open(map, marker);
            window.addEventListener("resize", function() { map.relayout(); map.setCenter(pos); });
        });
        </script>';
    }

    return $html;
}
?>