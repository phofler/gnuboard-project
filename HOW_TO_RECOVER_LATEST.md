# HOW_TO_RECOVER_LATEST.md (보드 최근글 관리 복구 지침)

본 문서는 `latest_skin_manager` 모듈 수정 작업 중 예기치 못한 오류나 데이터 손상이 발생했을 때, 1초 만에 최상의 상태로 복구하기 위한 가이드입니다.

## 1. 긴급 파일 복구 (File Recovery)
작업 전 백업된 원본 파일 위치: `C:\gnuboard\_backups\20260316_0952_Latest_Modularization/`

### 복구 방법 (PowerShell)
```powershell
$backupDir = "C:\gnuboard\_backups\20260316_0952_Latest_Modularization"
$targetDir = "C:\gnuboard\plugin\latest_skin_manager"

# 원본 파일 복원
Copy-Item "$backupDir\latest_skin.lib.php" -Destination "$targetDir\lib\latest_skin.lib.php" -Force
Copy-Item "$backupDir\write.php" -Destination "$targetDir\adm\write.php" -Force
Copy-Item "$backupDir\update.php" -Destination "$targetDir\adm\update.php" -Force
```

## 2. DB 정보 (Database)
- **테이블**: `g5_plugin_latest_skin_config`
- **핵심 컬럼**: 
  - `ls_id`: 식별 코드 (예: `kukdong_panel`, `corporate_en_sub`)
  - `ls_skin`: 스킨 경로 (`theme/`, `plugin/` 접두어 포함)
  - `ls_bo_table`: 연동 게시판 ID

## 3. 주요 로직 포인트
- **라이브러리**: `LATEST_SKIN_TABLE` 상수는 상단에서 정의됨.
- **연동**: `project_ui.extend.php`의 공통 UI 함수들을 사용하여 `ls_id` 및 스킨 선택을 제어함.

## 4. 장애 현상별 대책
- **AJAX 오류/메뉴 파손**: PHP 파일의 **BOM(Byte Order Mark)** 조사를 실시하십시오. (정상: BOM 없는 UTF-8)
- **Fatal Error**: `get_theme_lang_select_ui()` 함수가 없는 경우 `extend/project_ui.extend.php` 파일 존재 여부를 확인하십시오.
- **Ghost Save**: 파일 수정 후 변경사항이 반영되지 않으면 PowerShell 강제 쓰기 방식을 사용하십시오.