# HOW TO RECOVER SUB DESIGN

이 문서는 서브 디자인 모듈 작업 중 발생할 수 있는 문제를 진단하고 1초 내에 복구하기 위한 지침입니다.

## 1. 긴급 복구 (1초 복구)
작업 중 오류가 발생하거나 화면이 깨지는 경우, 아래 백업 파일을 원본 경로로 덮어씌우십시오.

*   **백업 위치**: `c:\gnuboard\_backups\20260316_2108_Image_Manager_Fix/`
*   **복구 대상**: 
    *   `write.php` -> `c:\gnuboard\plugin\sub_design\adm\write.php`
    *   `ajax.load_menus.php` -> `c:\gnuboard\plugin\sub_design\adm\ajax.load_menus.php`

## 2. 주요 체크포인트
1.  **BOM 오염 확인**: 수정 후 AJAX 응답이 JSON이 아니거나 `SyntaxError`가 발생하면 파일 처음에 BOM(Byte Order Mark)이 들어갔는지 확인하십시오. (해결: BOM 없는 UTF-8로 다시 저장)
2.  **JS 에러**: 브라우저 콘솔에서 `openImageManager is not defined` 발생 시 `write.php` 하단의 자바스크립트 로직이 누락되었는지 확인하십시오.
3.  **고스트 저장**: 파일 내용이 실제 디스크에 반영되지 않은 경우 PowerShell 스크립트 도구를 사용하여 강제 덮어쓰기를 수행하십시오.

## 3. 관련 파일 및 DB
*   **파일**:
    *   `c:\gnuboard\plugin\sub_design\adm\write.php` (관리자 수정 UI)
    *   `c:\gnuboard\plugin\sub_design\adm\ajax.load_menus.php` (메뉴 목록 로드)
    *   `c:\gnuboard\plugin\sub_design\lib\design.lib.php` (공통 함수)
*   **DB 테이블**:
    *   `g5_plugin_sub_design_groups` (테마/언어별 그룹 설정)
    *   `g5_plugin_sub_design_items` (메뉴별 개별 서브 비주얼 설정)
