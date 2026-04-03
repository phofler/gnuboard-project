# HOW_TO_RECOVER_LAYOUT_REFINE_V4.md

이 문서는 CEO 인사말 페이지 스타일 3차 고도화 작업(섹션 패딩 수정) 중 문제가 발생했을 때 즉시 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 일시**: 2026-03-18
- **대상 파일**: `C:\gnuboard\theme\kukdong_panel\css\style.css`
- **백업 위치**: `C:\gnuboard\_backups\20260318_1026_style_padding_refine\`

## 2. 복구 절차 (PowerShell)
기존 스타일로 원복하려면 아래 명령어를 실행하십시오.

```powershell
chcp 65001
$backupFile = "C:\gnuboard\_backups\20260318_1026_style_padding_refine\style.css"
$target = "C:\gnuboard\theme\kukdong_panel\css\style.css"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
$content = [System.IO.File]::ReadAllText($backupFile)
[System.IO.File]::WriteAllText($target, $content, $utf8NoBom)
```

## 3. 주요 수정 사항 (v3)
- **`.greeting-section`**: 패딩을 `clamp(10px, 5vw, 40px) 0`으로 대폭 축소하여 상하 여백을 줄였습니다.
- **BOM 오염 주의**: 수정 후 상단 공백이나 인코딩 문제가 발생하면 즉시 백업본으로 복구하십시오.
