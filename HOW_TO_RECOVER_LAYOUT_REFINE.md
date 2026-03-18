# HOW_TO_RECOVER_LAYOUT_REFINE.md

이 문서는 CEO 인사말 페이지 스타일 고도화 작업(`style.css` 수정) 중 문제가 발생했을 때 즉시 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 일시**: 2026-03-18
- **대상 파일**: `C:\gnuboard\theme\kukdong_panel\css\style.css`
- **백업 위치**: `C:\gnuboard\_backups\20260318_1016_style_refinement_v2\`

## 2. 복구 절차 (PowerShell)
기존 스타일로 원복하려면 아래 명령어를 실행하십시오.

```powershell
chcp 65001
$backupFile = "C:\gnuboard\_backups\20260318_1016_style_refinement_v2\style.css"
$target = "C:\gnuboard\theme\kukdong_panel\css\style.css"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
$content = [System.IO.File]::ReadAllText($backupFile)
[System.IO.File]::WriteAllText($target, $content, $utf8NoBom)
```

## 3. 주요 수정 사항 및 주의점
- **`.con_img`**: 이미지가 화면 너비를 초과하지 않도록 `max-width: 100%`를 적용했습니다.
- **`.greeting-lead`**: 글씨 크기를 `1.8rem`(최대)으로 줄이고 `line-height`를 `1.25`로 좁혀 세련미를 더했습니다.
- **BOM 오염 주의**: 수정 후 상단 공백이나 인코딩 문제가 발생하면 즉시 백업본으로 복구하십시오.
