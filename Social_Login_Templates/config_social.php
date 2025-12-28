<?php
if (!defined('_GNUBOARD_'))
    exit;

/*******************************************************************************
 * [소셜 로그인(Social Login) 설정 파일 템플릿]
 *
 * 사용법: 
 * 1. 이 코드를 extend/social_config.extend.php 로 저장하거나 config.php 하단에 추가
 * 2. 각 포털 개발자센터에서 Client ID / Secret 발급 필요
 *******************************************************************************/

// =============================================================================
// 1. 네이버 아이디로 로그인 (Naver Login)
// 개발자센터: https://developers.naver.com/apps/#/register
// =============================================================================
$config['cf_naver_clientid'] = 'YOUR_NAVER_CLIENT_ID';
$config['cf_naver_secret'] = 'YOUR_NAVER_CLIENT_SECRET';
// Callback URL 예시: http://도메인/plugin/social/register_member.php?provider=naver

// =============================================================================
// 2. 카카오 로그인 (Kakao Login)
// 개발자센터: https://developers.kakao.com/console/app
// =============================================================================
$config['cf_kakao_rest_key'] = 'YOUR_KAKAO_REST_API_KEY';
// JavaScript Key는 스킨단에서 필요할 수 있음
$config['cf_kakao_js_apikey'] = 'YOUR_KAKAO_JAVASCRIPT_KEY';
// Redirect URI 설정 필수: http://도메인/plugin/social/register_member.php?provider=kakao

// =============================================================================
// 3. 구글 로그인 (Google Login)
// 개발자센터: https://console.cloud.google.com/apis/credentials
// =============================================================================
$config['cf_google_clientid'] = 'YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com';
$config['cf_google_secret'] = 'YOUR_GOOGLE_CLIENT_SECRET';

// [옵션] 소셜 로그인 사용 여부 강제 활성화
$config['cf_social_login_use'] = 1;

echo "<script>console.log('Social Login Configuration Loaded');</script>";
?>