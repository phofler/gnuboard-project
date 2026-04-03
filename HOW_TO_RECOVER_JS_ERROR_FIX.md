# HOW_TO_RECOVER_JS_ERROR_FIX.md

이 문서는 메인 섹션 관리(`adm/write.php`) 페이지의 JavaScript 오류(`openUnsplashPopup is not defined`) 수정 작업 중 문제가 발생했을 때 즉시 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 일시**: 2026-03-18
- **대상 파일**: `C:\gnuboard\plugin\main_content_manager\adm\write.php`
- **백업 위치**: `C:\gnuboard\_backups\20260318_1043_js_error_fix\`

## 2. 복구 절차 (PowerShell)
기존 코드로 원복하려면 아래 명령어를 실행하십시오.

```powershell
chcp 65001
$backupFile = "C:\gnuboard\_backups\20260318_1043_js_error_fix\write.php"
$target = "C:\gnuboard\plugin\main_content_manager\adm\write.php"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
$content = [System.IO.File]::ReadAllText($backupFile)
[System.IO.File]::WriteAllText($target, $content, $utf8NoBom)
```

## 3. 주요 수정 사항
- **전역 헬퍼 함수 정의**: `openUnsplashPopup`, `closeUnsplashModal`, `receiveImageUrl` 함수를 `write.php`의 `<script>` 블록 상단에 추가하여 AJAX로 추가된 항목에서도 정상 작동하도록 했습니다.
- **이미지 핸들링 통일**: `SmartImageManager.open` 직접 호출 방식을 `openUnsplashPopup` 호출 방식으로 통일했습니다.
- **BOM 오염 방지**: PowerShell을 통해 **BOM 없는 UTF-8**로 저장되었습니다.
