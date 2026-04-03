# HOW TO RECOVER BREADCRUMB (LNB)

본 문서는 브레드크럼(LNB) 위치 및 스타일 수정 작업 중 문제가 발생했을 때 1초 만에 최상의 상태로 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 내용**: 브레드크럼을 히어로 섹션 내부에서 외부(하단 화이트 바)로 이동 및 스킨 스타일 수정
- **백업 일시**: 2026-03-16 21:32
- **백업 위치**: `c:\gnuboard\_backups\20260316_2132_breadcrumb_refactor`

## 2. 복구 대상 파일 리스트
작업 중 레이아웃이 깨지거나 SQL 에러 발생 시 아래 파일들을 백업 폴더에서 원본 위치로 덮어씌우십시오.

1. `theme/kukdong_panel/head.php` (LNB 위치 제어)
2. `plugin/sub_design/breadcrumb_skins/dropdown/main.skin.php` (LNB 구조)
3. `plugin/sub_design/breadcrumb_skins/dropdown/style.css` (LNB 스타일)
4. `plugin/sub_design/skins/standard/main.skin.php` (기본 히어로 스킨)
5. `plugin/sub_design/skins/cinema/main.skin.php` (시네마 히어로 스킨)

## 3. 복구 명령어 (PowerShell)
문제가 발생하면 아래 명령어를 복사하여 PowerShell에 실행하십시오.

```powershell
$backupDir = 'c:\gnuboard\_backups\20260316_2132_breadcrumb_refactor'
Copy-Item "$backupDir\head.php" -Destination 'c:\gnuboard\theme\kukdong_panel\head.php' -Force
Copy-Item "$backupDir\main.skin.php" -Destination 'c:\gnuboard\plugin\sub_design\breadcrumb_skins\dropdown\main.skin.php' -Force
Copy-Item "$backupDir\style.css" -Destination 'c:\gnuboard\plugin\sub_design\breadcrumb_skins\dropdown\style.css' -Force
Copy-Item "$backupDir\main.skin.php" -Destination 'c:\gnuboard\plugin\sub_design\skins\standard\main.skin.php' -Force
Copy-Item "$backupDir\main.skin.php" -Destination 'c:\gnuboard\plugin\sub_design\skins\cinema\main.skin.php' -Force
```

## 4. 주요 체크포인트
- **BOM 체크**: 수정 후 AJAX 응답이 깨지거나 화면에 이상한 공백이 생기면 반드시 BOM 없는 UTF-8인지 확인하십시오.
- **SQL 에러**: 브레드크럼 영역에 `SELECT * FROM WHERE ...` 에러가 보이면 `design.lib.php`의 전역 변수 설정과 스킨의 테이블 이름 인식 로직을 재점검하십시오.
- **중복 출력**: 히어로 섹션 내부와 하단 바에 브레드크럼이 동시에 나오면 `skins/` 내의 개별 스킨 파일에서 `display_breadcrumb()` 호출이 제거되었는지 확인하십시오.
