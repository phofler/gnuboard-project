# 상단 메뉴 전역 라이브러리(Extend) 회복 지침서

## 1. 개요
많은 페이지에서 공통으로 사용되는 상단 메뉴 설정 및 로고 연동 로직을 `extend` 라이브러리로 추출하였습니다. 이 문서에는 해당 기능의 구성 요소와 문제 발생 시 복구 방법을 기술합니다.

## 2. 핵심 구성 요소
- **핵심 라이브러리**: `C:\gnuboard\extend\user_top_menu.extend.php` (전역 자동 로드)
- **설정 식별코드**: `kukdong_panel` (top_menu_manager 플러그인용)
- **주요 전역 변수**:
    - `$logo_url`: 관리자 페이지에서 설정한 PC 로고 경로 (없을 경우 테마 기본 로고)
    - `G5_PRO_MENU_TABLE`: 관리자 페이지에서 설정한 메뉴 소스 테이블 명

## 3. 작동 원리
1. 그누보드 실행 시 `extend/*.php` 파일들을 자동으로 인클루드합니다.
2. `user_top_menu.extend.php`가 실행되며 DB에서 `kukdong_panel` 설정을 조회합니다.
3. 설정된 로고 이미지 명을 확인하여 `$logo_url` 변수를 생성합니다.
4. 설정된 메뉴 테이블 명에 따라 `G5_PRO_MENU_TABLE` 상수를 정의합니다.
5. 테마의 `head.php` 스타일 파일 등에서 해당 전역 변수와 상수를 사용하여 메뉴를 출력합니다.

## 4. 장애 및 복구 방법
- **상황 1: 상단 메뉴가 나오지 않거나 에러 발생 시**
    - `C:\gnuboard\extend\user_top_menu.extend.php` 파일이 존재하고 구문 오류(Syntax Error)가 없는지 확인합니다.
    - `top_menu_manager` 플러그인이 정상 설치되어 있는지 확인합니다.
- **상황 2: 로고 이미지가 엑박으로 나올 때**
    - 관리자 페이지 [상단 메뉴 설정 관리]에서 로고를 다시 업로드하거나 식별코드가 `kukdong_panel`인지 확인합니다.
- **상황 3: 메뉴 데이터가 맞지 않을 때**
    - [상단 메뉴 설정 관리]에서 '메뉴 소스' 테이블 설정이 올바른지 확인합니다.

## 5. 최종 회복 스크립트 (PowerShell)
문제가 해결되지 않을 경우 아래 스크립트를 관리자 권한으로 실행하여 초기 상태로 되돌립니다.
```powershell
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
$extendFile = "C:\gnuboard\extend\user_top_menu.extend.php"
$content = "<?php if (!defined('_GNUBOARD_')) exit; include_once(G5_PLUGIN_PATH.'/top_menu_manager/lib.php'); ?>"
[System.IO.File]::WriteAllText($extendFile, $content, $utf8NoBom)
```