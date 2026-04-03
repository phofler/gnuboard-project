# HOW_TO_RECOVER_THEME_SYNC.md (테마 동기화 복구 지침)

본 문서는 '테마 색상 동기화 및 플러그인 표준화' 작업 중 문제 발생 시 1초 내에 복구하기 위한 지침입니다.

## 1. 긴급 복구 (파일 시스템)

작업 전 생성된 백업 내역을 사용하여 원본으로 되돌립니다.

**백업 위치**: `C:\gnuboard\_backups\20260317_0955_Theme_Sync_Standardization\`

### 복구 방법 (PowerShell)
```powershell
$backupDir = "C:\gnuboard\_backups\20260317_0955_Theme_Sync_Standardization"
$targetDir = "C:\gnuboard"

# 순서대로 덮어씌우기 (필요한 파일만 선택 가능)
Copy-Item "$backupDir\plugin\company_intro\adm\write.php" "C:\gnuboard\plugin\company_intro\adm\write.php" -Force
Copy-Item "$backupDir\plugin\main_content_manager\adm\write.php" "C:\gnuboard\plugin\main_content_manager\adm\write.php" -Force
# ... 기타 나머지 파일들 동일 방식
```

## 2. 데이터베이스 복구

배경색 업데이트 쿼리로 인해 문제가 발생한 경우(예: 화이트 배경이 원치 않는 곳에 적용됨) 다음 쿼리를 실행합니다.

```sql
-- 특정 ID에 대해 수동 복구 (예시)
UPDATE g5_plugin_company_add SET co_bgcolor = '#121212' WHERE co_id = 'kukdong_panel';
```

## 3. 고스트 저장(Ghost Save) 발생 시 대처

만약 수정 사항이 반영되지 않는다면, 다음 스크립트로 강제 기록을 재시도하십시오.

```powershell
$file = '대상파일경로'
$content = Get-Content $file -Raw # 또는 수정하려던 전체 코드 문자열
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
```

---
**주의**: 복구 후 반드시 브라우저 캐시를 삭제하고 확인하십시오.
