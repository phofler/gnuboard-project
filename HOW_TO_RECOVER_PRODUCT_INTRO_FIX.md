# HOW_TO_RECOVER_PRODUCT_INTRO_FIX.md

이 문서는 메인 페이지 제품 소개(`product_intro`) 섹션의 이미지 크기 불일치 수정 작업 중 문제가 발생했을 때 즉시 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 일시**: 2026-03-18
- **대상 파일**: `C:\gnuboard\plugin\main_content_manager\skins\product_intro\style.css`
- **백업 위치**: `C:\gnuboard\_backups\20260318_1037_product_intro_image_fix\`

## 2. 복구 절차 (PowerShell)
기존 스타일로 원복하려면 아래 명령어를 실행하십시오.

```powershell
chcp 65001
$backupFile = "C:\gnuboard\_backups\20260318_1037_product_intro_image_fix\style.css"
$target = "C:\gnuboard\plugin\main_content_manager\skins\product_intro\style.css"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
$content = [System.IO.File]::ReadAllText($backupFile)
[System.IO.File]::WriteAllText($target, $content, $utf8NoBom)
```

## 3. 주요 수정 사항
- **`.product-text`**: `flex: 1 !important`를 부여하여 텍스트 양에 상관없이 일정한 너비를 유지하도록 했습니다.
- **`.product-img`**: `flex: 1.5 !important`와 `aspect-ratio: 16/9`를 통해 이미지 크기를 고정했습니다.
- **BOM 오염 주의**: 수정 후 레이아웃이 깨지면 즉시 백업본으로 복구하십시오.
