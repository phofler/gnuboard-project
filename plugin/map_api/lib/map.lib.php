<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Map Display Function
 * @param string $width  Width (e.g., 100%, 500px)
 * @param string $height Height (e.g., 400px)
 */
function display_map_api($width = '100%', $height = '400px')
{
    global $config;
    $map_title = isset($config['cf_title']) && $config['cf_title'] ? $config['cf_title'] : 'Location';
    // Split title for display
    $map_title_display = str_replace('환경디자인', '<br><span style="font-weight:normal;">환경디자인', $map_title);
    if (strpos($map_title_display, '환경디자인') !== false) {
        $map_title_display .= '</span>';
    }
    $map_title_js = addslashes($map_title_display);

    $config_file = G5_DATA_PATH . '/map_api_config.php';
    if (!file_exists($config_file)) {
        return '<div style="background:#eee; padding:20px; text-align:center;">Map API setup required.</div>';
    }

    $map_config = include($config_file);

    if (!$map_config['api_key'] && !$map_config['client_id']) {
        return '<div style="background:#eee; padding:20px; text-align:center;">API Key missing.</div>';
    }

    $provider = isset($map_config['provider']) ? $map_config['provider'] : 'naver';
    $lat = isset($map_config['lat']) ? $map_config['lat'] : '37.5665';
    $lng = isset($map_config['lng']) ? $map_config['lng'] : '126.9780';
    $api_key = isset($map_config['api_key']) ? trim($map_config['api_key']) : ''; // Trim whitespace
    $client_id = isset($map_config['client_id']) ? trim($map_config['client_id']) : '';

    $html = '<div id="map" style="width:' . $width . '; height:' . $height . ';"></div>';

    if ($provider == 'naver') {
        // Naver Map
        $html .= '<script type="text/javascript" src="https://oapi.map.naver.com/openapi/v3/maps.js?ncpClientId=' . $client_id . '"></script>';
        $html .= '<script>
        window.addEventListener("load", function() {
            if (typeof naver === "undefined") { console.error("Naver Maps SDK not loaded."); return; }
            var mapOptions = {
                center: new naver.maps.LatLng(' . $lat . ', ' . $lng . '),
                zoom: 17
            };
            var map = new naver.maps.Map("map", mapOptions);
            var center = new naver.maps.LatLng(' . $lat . ', ' . $lng . ');
            var marker = new naver.maps.Marker({
                position: center,
                map: map
            });
            var contentString = [
                "<div style=\"padding:10px 15px;min-width:180px;text-align:center;font-size:14px;line-height:1.5;font-family:sans-serif;color:#000;\">",
                "   <strong style=\"font-size:15px;font-weight:bold;letter-spacing:-0.5px;\">' . $map_title_js . '</strong>",
                "</div>"
            ].join("");

            var infowindow = new naver.maps.InfoWindow({
                content: contentString,
                borderWidth: 1,
                anchorSkew: true
            });
            infowindow.open(map, marker);

            // Re-center on resize
            window.addEventListener("resize", function() {
                map.setCenter(center);
            });
        });
        </script>';
    } else if ($provider == 'google') {
        // Google Map
        $html .= '<script src="https://maps.googleapis.com/maps/api/js?key=' . $api_key . '&callback=initMap" async defer></script>';
        $html .= '<script>
        function initMap() {
            if (typeof google === "undefined") { console.error("Google Maps SDK not loaded."); return; }
            var location = {lat: ' . $lat . ', lng: ' . $lng . '};
            var map = new google.maps.Map(document.getElementById("map"), {
                zoom: 17,
                center: location
            });
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });

            var infowindow = new google.maps.InfoWindow({
                content: "<div style=\"padding:10px 15px;min-width:140px;text-align:center;font-size:14px;line-height:1.5;font-family:sans-serif;color:#000;\"><strong style=\"font-size:15px;font-weight:bold;\">' . $map_title_js . '</strong></div>"
            });
            infowindow.open(map, marker);

            // Re-center on resize
            window.addEventListener("resize", function() {
                map.setCenter(location);
            });
        }
        </script>';
    } else if ($provider == 'kakao') {
        // Kakao Map (Forcing HTTPS)
        $html .= '<script type="text/javascript" src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=' . $api_key . '&libraries=services" onerror="alert(\'Failed to load Kakao Map SDK.\');"></script>';
        $html .= '<script>
        window.addEventListener("load", function() {
            if (typeof kakao === "undefined") { 
                console.error("Kakao Maps SDK not loaded. Check API Key or Network."); 
                document.getElementById("map").innerHTML = "<div style=\'padding:20px; text-align:center;\'>Kakao Map Failed to Load.<br>Check Console for details.</div>";
                return; 
            }
            var container = document.getElementById("map");
            var options = {
                center: new kakao.maps.LatLng(' . $lat . ', ' . $lng . '),
                level: 3
            };
            var map = new kakao.maps.Map(container, options);
            // Create Marker
            var markerPosition  = new kakao.maps.LatLng(' . $lat . ', ' . $lng . '); 
            var marker = new kakao.maps.Marker({
                position: markerPosition
            });
            marker.setMap(map);

            // InfoWindow
            var iwContent = \'<div style="padding:10px 15px; text-align:center; min-width:140px; font-size:14px; line-height:1.5; font-family:sans-serif; color:#000 !important;"><strong style="font-size:16px; font-weight:800; letter-spacing:-0.5px; color:#000;">' . $map_title_js . '</strong></div>\';
            var infowindow = new kakao.maps.InfoWindow({
                position : markerPosition, 
                content : iwContent
            });
            infowindow.open(map, marker);

            // Re-center on resize
            window.addEventListener("resize", function() {
                map.relayout();
                map.setCenter(markerPosition);
            });
        });
        </script>';
    }

    return $html;
}
?>