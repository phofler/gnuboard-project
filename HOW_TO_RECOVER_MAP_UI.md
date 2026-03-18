# HOW_TO_RECOVER_MAP_UI.md

이 문서는 지도 위 '극동판넬(주)' 박스(InfoWindow) 디자인 수정 작업 중 문제가 발생했을 때 즉시 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 일시**: 2026-03-18
- **대상 파일**: 
  1. `C:\gnuboard\plugin\map_api\skin.head.php`
- **백업 위치**: `C:\gnuboard\_backups\20260318_1144_map_ui_beautify\`

## 2. 복구 절차 (PowerShell)
기존 코드로 원복하려면 아래 명령어를 실행하십시오.

```powershell
chcp 65001
$backupFile = "C:\gnuboard\_backups\20260318_1144_map_ui_beautify\skin.head.php"
$target = "C:\gnuboard\plugin\map_api\skin.head.php"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
$content = [System.IO.File]::ReadAllText($backupFile)
[System.IO.File]::WriteAllText($target, $content, $utf8NoBom)
```

## 3. 주요 수정 사항
- **디자인 개선**: `.map-api-info-window`에 `border-radius: 8px`, `box-shadow`, 그리고 하단 화살표(`::after`)를 추가하여 세련된 팝업 스타일로 변경했습니다.
- **폰트 및 색상**: 텍스트를 더 굵게(`font-weight: 800`) 하고 기업 이미지에 맞는 블루 컬러를 적용했습니다.
- **BOM 오염 방지**: PowerShell을 통해 **BOM 없는 UTF-8**로 저장되었습니다.
