# HOW TO RECOVER: Section Subtitle & Image Management Enhancement

이 문서는 섹션 소제목 추가 및 이미지 삭제 기능 고도화 작업 중 오류 발생 시 즉시 복구하기 위한 지침입니다.

## 1. 파일 복구 (File Restoration)

### 백업 위치
`C:/gnuboard/_backups/20260315_1618_Section_Subtitle_Image_Cleanup`

### 복구 명령 (PowerShell)
```powershell
$backupDir = "C:/gnuboard/_backups/20260315_1618_Section_Subtitle_Image_Cleanup"
Copy-Item "$backupDir/main_content.lib.php" -Destination "C:/gnuboard/plugin/main_content_manager/lib/main_content.lib.php" -Force
Copy-Item "$backupDir/write.php" -Destination "C:/gnuboard/plugin/main_content_manager/adm/write.php" -Force
Copy-Item "$backupDir/ajax.add_item.php" -Destination "C:/gnuboard/plugin/main_content_manager/adm/ajax.add_item.php" -Force
Copy-Item "$backupDir/update.php" -Destination "C:/gnuboard/plugin/main_content_manager/adm/update.php" -Force
```

## 2. DB 복구 (Database Recovery)
추가된 `ms_subtitle` 컬럼이 문제를 일으킬 경우 (드문 경우), 아래 명령으로 삭제할 수 있습니다.
```sql
ALTER TABLE g5_plugin_main_content_sections DROP COLUMN ms_subtitle;
```

## 3. 인코딩 확인
모든 PHP 파일은 **UTF-8 No-BOM** 형식으로 저장되어야 합니다. 수정 후 AJAX 오류나 화면 깨짐이 발생하면 인코딩을 즉시 재검토하십시오.
