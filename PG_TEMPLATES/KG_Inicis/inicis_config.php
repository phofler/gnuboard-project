<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/*******************************************************************************
 * [KG이니시스 설정 파일 템플릿]
 *
 * 사용법:
 * 1. 이 파일을 shop/inicis/inicis_config.php 위치로 복사하거나 내용을 덮어씌웁니다.
 * 2. 아래 $default['de_inicis_mid'] 와 $default['de_inicis_admin_key'] 를 수정합니다.
 *******************************************************************************/

// [수정 할 곳] 상점 아이디 (MID)
// 테스트용 MID: INIpayTest
$default['de_inicis_mid'] = 'INIpayTest'; 

// [수정 할 곳] 웹결제 사인키 (SignKey)
// 이니시스 관리자 페이지(https://iniweb.inicis.com) -> 상점정보 -> 계약정보 -> 전송정보설정 에서 확인
// 테스트용 키: SU5JTGl0ZV90cmlwbGVkZXNfa2V5c3Ry
$default['de_inicis_admin_key'] = 'SU5JTGl0ZV90cmlwbGVkZXNfa2V5c3Ry';

// 기타 결제 옵션 (필요시 변경)
$default['de_inicis_use_card']  = 1; // 신용카드 사용
$default['de_inicis_use_bank']  = 1; // 계좌이체 사용
$default['de_inicis_use_vbank'] = 1; // 가상계좌 사용

echo "<script>console.log('PG Configuration Loaded: KG Inicis');</script>";
?>
