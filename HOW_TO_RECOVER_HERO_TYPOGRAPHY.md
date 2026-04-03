# HOW TO RECOVER HERO TYPOGRAPHY STANDARDIZATION

본 문서는 히어로 비주얼의 서체(폰트 색상, 크기) 표준화 작업 중 문제가 발생했을 때 1초 만에 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 내용**: 히어로 비주얼(Tag, Main, Sub) 폰트 크기/색상 표준화 및 CSS 변수 통합
- **백업 일시**: 2026-03-16 22:00
- **백업 위치**: `c:\gnuboard\_backups\20260316_2200_hero_typography`

## 2. 복구 대상 파일 리스트
작업 중 히어로 영역의 폰트가 깨지거나 디자인이 무너질 경우 아래 파일을 덮어씌우십시오.

1. `plugin/sub_design/lib/design.lib.php` (CSS 포함 로직)
2. `plugin/sub_design/skins/standard/main.skin.php` (스킨 스타일)
3. `plugin/sub_design/skins/cinema/main.skin.php` (스킨 스타일)

## 3. 복구 명령어 (PowerShell)
```powershell
chcp 65001
$backupDir = 'c:\gnuboard\_backups\20260316_2200_hero_typography'
Copy-Item "$backupDir\design.lib.php" -Destination 'c:\gnuboard\plugin\sub_design\lib\design.lib.php' -Force
Copy-Item "$backupDir\main.skin.php" -Destination 'c:\gnuboard\plugin\sub_design\skins\standard\main.skin.php' -Force
Copy-Item "$backupDir\main.skin.php" -Destination 'c:\gnuboard\plugin\sub_design\skins\cinema\main.skin.php' -Force
```

## 4. 예외 상황 대응
- **변수 충돌**: `style.css`의 기존 변수명과 충돌하여 디자인이 의도치 않게 변할 수 있습니다. 이 경우 `typography.css`에서 해당 변수를 직접 값으로 할당하거나 변수명을 변경하십시오.
- **BOM 오염**: 수정 후 상단 레이아웃에 공백이 생기면 BOM 없는 UTF-8 인코딩을 재수행하십시오.
