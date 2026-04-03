# HOW_TO_RECOVER_LAYOUT_REFINE_V3.md

이 문서는 CEO 인사말 페이지 스타일 2차 고도화 작업(`style.css` 수정) 중 문제가 발생했을 때 즉시 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 일시**: 2026-03-18
- **대상 파일**: `C:\gnuboard\theme\kukdong_panel\css\style.css`
- **백업 위치**: `C:\gnuboard\_backups\20260318_1022_style_refinement_v3\`

## 2. 복구 절차 (PowerShell)
기존 스타일로 원복하려면 아래 명령어를 실행하십시오.

```powershell
chcp 65001
$backupFile = "C:\gnuboard\_backups\20260318_1022_style_refinement_v3\style.css"
$target = "C:\gnuboard\theme\kukdong_panel\css\style.css"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
$content = [System.IO.File]::ReadAllText($backupFile)
[System.IO.File]::WriteAllText($target, $content, $utf8NoBom)
```

## 3. 주요 수정 사항 (v2)
- **`.con_img`**: 매진-바텀(margin-bottom)을 `40px`에서 `20px`로 절반 축소하여 이미지와 텍스트 사이의 이격을 줄였습니다.
- **`.greeting-lead`**: 글씨 크기를 `1.5rem`(최대)으로 추가 축소하여 더 밀도 있고 고급스러운 디자인을 구현했습니다.
- **`.greeting-section`**: 내부 요소 간 간격(gap)을 `10px~15px`로 좁혀 전체적인 레이아웃 정합성을 높였습니다.
