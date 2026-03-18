# 카피라이트 필드 확장 복구 가이드 (HOW_TO_RECOVER_COPYRIGHT_EXPANSION.md)

## 🚨 위급 상황 발생 시 (1초 복구 루틴)
작업 중 데이터 정합성 문제나 UI 깨짐 현상이 발생하면 즉시 수행하십시오.

### 1단계: 물리 파일 복구
백업 폴더(`C:\gnuboard\_backups/20260316_1300_Copyright_Field_Expansion/`)에서 파일을 복구합니다.

```powershell
$backupDir = "C:\gnuboard\_backups\20260316_1300_Copyright_Field_Expansion"
Copy-Item "$backupDir\write.php" "C:\gnuboard\plugin\copyright_manager\adm\write.php" -Force
Copy-Item "$backupDir\write_update.php" "C:\gnuboard\plugin\copyright_manager\adm\write_update.php" -Force
Copy-Item "$backupDir\lib.php" "C:\gnuboard\plugin\copyright_manager\lib.php" -Force
Copy-Item "$backupDir\project_utils.extend.php" "C:\gnuboard\extend\project_utils.extend.php" -Force
```

### 2단계: DB 컬럼 원복 (선택 사항)
만약 DB 에러가 발생한다면 다음 쿼리를 실행하십시오.
```sql
ALTER TABLE `g5_plugin_copyright` 
DROP COLUMN `company_label`, DROP COLUMN `company_val`,
DROP COLUMN `ceo_label`, DROP COLUMN `ceo_val`,
DROP COLUMN `bizno_label`, DROP COLUMN `bizno_val`;
```

---

## 🛠 수정된 내용
1.  **DB 확장**: 상호, 대표자, 사업자번호 필드 전용 컬럼 6개 추가.
2.  **관리자 UI**: Quick Info 영역에 입력 필드 추가 및 저장 로직 연동.
3.  **라이브러리**: `set_pro_skin_context` 및 `{company}` 등 치환자 연동.
4.  **BOM 관리**: 모든 파일은 BOM 없는 UTF-8로 저장됨.