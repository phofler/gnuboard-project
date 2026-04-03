# HOW_TO_RECOVER_IMAGE_PROPAGATION_FIX.md

이 문서는 이미지 매니저에서 선택한 이미지가 폼에 적용되지 않던 문제(mi_id 누락) 수정 작업 중 문제가 발생했을 때 즉시 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 일시**: 2026-03-18
- **대상 파일**: 
  1. `C:\gnuboard\js\image_smart_manager.js`
  2. `C:\gnuboard\plugin\main_content_manager\adm\write.php`
- **백업 위치**: `C:\gnuboard\_backups\20260318_1056_image_propagation_fix\`

## 2. 복구 절차 (PowerShell)
기존 코드로 원복하려면 아래 명령어를 실행하십시오.

```powershell
chcp 65001
$backupDir = "C:\gnuboard\_backups\20260318_1056_image_propagation_fix"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false

# 1. JS 라이브러리 복구
$jsContent = [System.IO.File]::ReadAllText("$backupDir\image_smart_manager.js")
[System.IO.File]::WriteAllText("C:\gnuboard\js\image_smart_manager.js", $jsContent, $utf8NoBom)

# 2. 관리자 페이지 복구
$phpContent = [System.IO.File]::ReadAllText("$backupDir\write.php")
[System.IO.File]::WriteAllText("C:\gnuboard\plugin\main_content_manager\adm\write.php", $phpContent, $utf8NoBom)
```

## 3. 주요 수정 사항
- **JS 라이브러리 (`image_smart_manager.js`)**:
  - `SmartImageManager` 객체에 `mi_id` 속성 추가.
  - `open()` 함수에서 `mi_id`를 옵션으로 받아 저장하도록 수정.
  - `openPopup()` 함수에서 URL 생성을 할 때 `&mi_id=` 쿼리 스트링을 추가하여 대상 항목 정보를 전달.
- **관리자 페이지 (`write.php`)**:
  - `openUnsplashPopup(id)` 호출 시 `mi_id: id`를 명시적으로 전달하도록 수정.
- **공통**: PowerShell을 통해 **BOM 없는 UTF-8**로 저장되었습니다.
