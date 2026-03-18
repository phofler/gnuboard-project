# HOW TO RECOVER HERO VISUAL ENHANCEMENT (Order & Effects)

본 문서는 히어로 비주얼의 텍스트 배치 순서 및 애니메이션 효과 고도화 작업 중 문제가 발생했을 때 1초 만에 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 내용**: 텍스트 레이어 순서 변경 (Tag -> Main -> Sub) 및 AOS 애니메이션 설정 기능 추가
- **백업 일시**: 2026-03-16 21:46
- **백업 위치**: `c:\gnuboard\_backups\20260316_2146_hero_enhancement`

## 2. 복구 대상 파일 리스트
작업 중 관리자 페이지가 안 열리거나 히어로 영역 디자인이 무너질 경우 아래 파일을 덮어씌우십시오.

1. `plugin/sub_design/adm/write.php` (관리자 UI)
2. `plugin/sub_design/lib/design.lib.php` (라이브러리 로직)
3. `plugin/sub_design/skins/standard/main.skin.php` (기본 스킨)
4. `plugin/sub_design/skins/cinema/main.skin.php` (시네마 스킨)

## 3. 복구 명령어 (PowerShell)
```powershell
$backupDir = 'c:\gnuboard\_backups\20260316_2146_hero_enhancement'
Copy-Item "$backupDir\write.php" -Destination 'c:\gnuboard\plugin\sub_design\adm\write.php' -Force
Copy-Item "$backupDir\design.lib.php" -Destination 'c:\gnuboard\plugin\sub_design\lib\design.lib.php' -Force
Copy-Item "$backupDir\main.skin.php" -Destination 'c:\gnuboard\plugin\sub_design\skins\standard\main.skin.php' -Force
Copy-Item "$backupDir\main.skin.php" -Destination 'c:\gnuboard\plugin\sub_design\skins\cinema\main.skin.php' -Force
```

## 4. 예외 상황 대응
- **DB 컬럼 누락**: `sd_tag` 등의 신규 컬럼을 사용하도록 코드를 수정했으나 DB에 없을 경우 SQL 에러가 날 수 있습니다. 이 경우 `design.lib.php`에서 해당 필드 사용 부분을 주석 처리하거나 DB에 컬럼을 추가하십시오.
- **BOM 오염**: 수정 후 관리자 페이지 하단에 공백이 생기거나 기능이 멈추면 반드시 BOM 없는 UTF-8인지 재확인하십시오.
