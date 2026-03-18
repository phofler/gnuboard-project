# HOW_TO_RECOVER_CSS_FILTER.md

이 문서는 제품 소개 섹션의 이미지 선명화 필터(CSS Sharpen Filter) 작업 중 문제가 발생했을 때 즉시 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 일시**: 2026-03-18
- **대상 파일**: `C:\gnuboard\plugin\main_content_manager\skins\product_intro\style.css`
- **백업 위치**: `C:\gnuboard\_backups\20260318_1128_css_sharpen_filter\`

## 2. 복구 절차 (PowerShell)
기존 코드로 원복하려면 아래 명령어를 실행하십시오.

```powershell
chcp 65001
$backupFile = "C:\gnuboard\_backups\20260318_1128_css_sharpen_filter\style.css"
$target = "C:\gnuboard\plugin\main_content_manager\skins\product_intro\style.css"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
$content = [System.IO.File]::ReadAllText($backupFile)
[System.IO.File]::WriteAllText($target, $content, $utf8NoBom)
```

## 3. 주요 수정 사항
- **필터 적용**: `.product-img img` 선택자에 `image-rendering: -webkit-optimize-contrast` 및 `filter: contrast(1.1) brightness(1.03)`를 추가하여 선명도를 높였습니다.
- **인터랙션 추가**: 마우스 호버 시(`:hover`) 대비가 더 높아지는 효과를 추가했습니다.
- **BOM 오염 방지**: PowerShell을 통해 **BOM 없는 UTF-8**로 저장되었습니다.
