# HOW_TO_RECOVER_RESOLUTION_FIX.md

이 문서는 이미지 흐릿함(해상도 저하) 문제 수정 작업 중 문제가 발생했을 때 즉시 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 일시**: 2026-03-18
- **대상 파일**: 
  1. `C:\gnuboard\js\image_smart_manager.js`
  2. `C:\gnuboard\plugin\main_content_manager\adm\write.php`
- **백업 위치**: `C:\gnuboard\_backups\20260318_1112_resolution_fix\`

## 2. 복구 절차 (PowerShell)
기존 코드로 원복하려면 아래 명령어를 실행하십시오.

```powershell
chcp 65001
$backupDir = "C:\gnuboard\_backups\20260318_1112_resolution_fix"
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
  - `open()` 함수에 `forceW`, `forceH` 옵션을 추가하여, 화면상의 미리보기 크기가 아닌 실제 저장될 고해상도 크기를 강제로 지정할 수 있게 했습니다.
- **관리자 페이지 (`write.php`)**:
  - `openUnsplashPopup(id)` 함수에서 PHP의 `get_mc_skin_info()`를 호출하여 스킨별 권장 해상도(800px~1200px)를 JS 변수로 가져오고, 이를 이미지 매니저에 전달하도록 수정했습니다.
- **BOM 오염 방지**: PowerShell을 통해 **BOM 없는 UTF-8**로 저장되었습니다.
