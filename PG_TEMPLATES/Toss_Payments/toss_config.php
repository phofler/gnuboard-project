<?php
if (!defined('_GNUBOARD_'))
    exit;

/*******************************************************************************
 * [토스페이먼츠(Toss Payments) 설정 파일 템플릿]
 *
 * 사용법:
 * 1. 이 값을 shop/toss/toss_config.php 등에 복사하거나
 *    관리자 페이지 > 쇼핑몰관리 > 결제설정 > 토스페이먼츠 설정에 입력하세요.
 * 2. 개발자센터(https://developers.tosspayments.com)에서 키를 발급받으세요.
 *******************************************************************************/

// [수정 할 곳] 클라이언트 키 (Client Key)
$default['de_toss_client_key'] = 'test_ck_D5GePWvyJnrK0W0k6q8gLzN97Eoq'; // 테스트용 키

// [수정 할 곳] 시크릿 키 (Secret Key)
$default['de_toss_secret_key'] = 'test_sk_zXLkKEypNArWmo50nX3lmeaxYG5R'; // 테스트용 키

// -----------------------------------------------------------------------------
// [연동 팁]
// 토스페이먼츠는 별도의 모바일 패치가 필요 없습니다. (반응형 지원)
// 결제창 호출 함수: requestPayment(클라이언트키, 결제정보객체)
// -----------------------------------------------------------------------------

echo "<script>console.log('PG Configuration Loaded: Toss Payments');</script>";
?>