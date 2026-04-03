# HOW_TO_RECOVER_CATALOG_LINK.md

이 문서는 헤더의 'CONTACT' 버튼을 '카다로그 다운로드'로 교체하는 작업 중 문제가 발생했을 때 즉시 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 일시**: 2026-03-18
- **대상 파일**: 
  1. `C:\gnuboard\plugin\top_menu_manager\skins\centered\menu.skin.php`
  2. `C:\gnuboard\plugin\top_menu_manager\skins\basic\menu.skin.php`
  3. `C:\gnuboard\plugin\top_menu_manager\skins\transparent\menu.skin.php`
- **백업 위치**: `C:\gnuboard\_backups\20260318_1136_catalog_link_replacement\`

## 2. 복구 절차 (PowerShell)
기존 코드로 원복하려면 아래 명령어를 실행하십시오.

```powershell
chcp 65001
$backupDir = "C:\gnuboard\_backups\20260318_1136_catalog_link_replacement"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false

# 1. Centered 스킨 복구
$c1 = [System.IO.File]::ReadAllText("$backupDir\centered_menu.skin.php")
[System.IO.File]::WriteAllText("C:\gnuboard\plugin\top_menu_manager\skins\centered\menu.skin.php", $c1, $utf8NoBom)

# 2. Basic 스킨 복구
$c2 = [System.IO.File]::ReadAllText("$backupDir\basic_menu.skin.php")
[System.IO.File]::WriteAllText("C:\gnuboard\plugin\top_menu_manager\skins\basic\menu.skin.php", $c2, $utf8NoBom)

# 3. Transparent 스킨 복구
$c3 = [System.IO.File]::ReadAllText("$backupDir\transparent_menu.skin.php")
[System.IO.File]::WriteAllText("C:\gnuboard\plugin\top_menu_manager\skins\transparent\menu.skin.php", $c3, $utf8NoBom)
```

## 3. 주요 수정 사항
- **PC 헤더 링크 변경**: 데스크탑 화면에서 'CONTACT' 버튼을 클릭하면 `data/about/catalog.pdf` 파일이 다운로드되도록(새 창 열기) 수정했습니다.
- **모바일 유지**: 모바일의 전화 가기 아이콘은 원래대로 유지했습니다.
- **BOM 오염 방지**: PowerShell을 통해 **BOM 없는 UTF-8**로 저장되었습니다.
