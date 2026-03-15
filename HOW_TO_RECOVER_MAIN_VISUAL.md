# 🆘 긴급 복구 매뉴얼: 메인 비주얼 모바일 지원 및 리팩토링 (Phase 2)

이 문서는 Phase 2 작업 중 예기치 못한 오류가 발생했을 때, 시스템을 **1초 만에 최상의 상태로 되돌리기 위한** 지침입니다.

## 1. 개요
- **작업명**: 메인 비주얼 모바일 전용 세로형 이미지 필드 추가 및 코드 리팩토링
- **백업 일시**: 2026-03-15 13:30
- **백업 위치**: `C:\gnuboard\_backups\20260315_1330_Main_Visual_Mobile_Refactor\`

## 2. 파일 복구 (Rollback Files)
터미널(PowerShell)에서 아래 명령어를 실행하여 원본 파일을 즉시 복원할 수 있습니다.

```powershell
$backupDir = "C:\gnuboard\_backups\20260315_1330_Main_Visual_Mobile_Refactor"
$targetDir = "C:\gnuboard"

# 파일 복사 (덮어쓰기)
Copy-Item "$backupDir\main.lib.php" "$targetDir\plugin\main_image_manager\lib\main.lib.php" -Force
Copy-Item "$backupDir\image_manager.php" "$targetDir\plugin\main_image_manager\adm\image_manager.php" -Force
Copy-Item "$backupDir\write.php" "$targetDir\plugin\main_image_manager\adm\write.php" -Force
Copy-Item "$backupDir\update.php" "$targetDir\plugin\main_image_manager\adm\update.php" -Force
Copy-Item "$backupDir\ajax.upload.php" "$targetDir\plugin\main_image_manager\adm\ajax.upload.php" -Force
Copy-Item "$backupDir\project_ui.extend.php" "$targetDir\extend\project_ui.extend.php" -Force
Copy-Item "$backupDir\index.php" "$targetDir\theme\kukdong_panel\index.php" -Force

Write-Output "모든 파일이 성공적으로 복구되었습니다."
```

## 3. 데이터베이스 복구 (Rollback DB)
추가된 `mi_image_mobile` 컬럼을 삭제하여 DB 스키마를 원상태로 돌립니다.

```sql
ALTER TABLE g5_plugin_main_image_add DROP COLUMN mi_image_mobile;
```

## 4. 체크리스트 (심각한 상황 시)
1. 상단 메뉴가 깨지거나 메인 비주얼이 나오지 않는 경우: 위 파일 복구 스크립트 실행.
2. 관리자 페이지에서 이미지 업로드 시 SQL 에러가 발생하는 경우: DB 컬럼 추가 여부 확인 또는 삭제.
3. 화면에 한글이 깨져서 나오는 경우: 파일 인코딩이 **UTF-8 No BOM**인지 재확인 (Rule 7 참조).

---
**주의**: 모든 복구 작업 후에는 브라우저 캐시를 반드시 새로고침(Ctrl + Shift + R)하십시오.
