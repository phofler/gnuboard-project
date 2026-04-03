# HOW_TO_RECOVER_UNLOCK_RATIO.md

이 문서는 이미지 매니저의 크롭 비율 해제(Unlock Aspect Ratio) 기능 추가 작업 중 문제가 발생했을 때 즉시 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 일시**: 2026-03-18
- **대상 파일**: `C:\gnuboard\plugin\main_content_manager\adm\image_manager.php`
- **백업 위치**: `C:\gnuboard\_backups\20260318_1104_unlock_ratio_feature\`

## 2. 복구 절차 (PowerShell)
기존 코드로 원복하려면 아래 명령어를 실행하십시오.

```powershell
chcp 65001
$backupFile = "C:\gnuboard\_backups\20260318_1104_unlock_ratio_feature\image_manager.php"
$target = "C:\gnuboard\plugin\main_content_manager\adm\image_manager.php"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
$content = [System.IO.File]::ReadAllText($backupFile)
[System.IO.File]::WriteAllText($target, $content, $utf8NoBom)
```

## 3. 주요 수정 사항
- **UI 추가**: 크롭 인터페이스 하단(`crop-footer`)에 '비율 해제' 및 '비율 고정'을 토글할 수 있는 버튼(`btn_toggle_ratio`)과 상태 표시용 `span#ratio_info`를 추가했습니다.
- **로직 구현**: `toggleAspectRatio()` 함수를 통해 Cropper 인스턴스의 `aspectRatio`를 스킨 권장값과 `NaN`(자유 비율) 사이에서 전환하도록 했습니다.
- **BOM 오염 방지**: PowerShell을 통해 **BOM 없는 UTF-8**로 저장되었습니다.
