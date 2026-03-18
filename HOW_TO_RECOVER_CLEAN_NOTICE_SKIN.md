# HOW_TO_RECOVER_CLEAN_NOTICE_SKIN.md (깔끔한 공지사항 스킨 복구 지침)

본 문서는 `latest_skin_manager` 플러그인의 새로운 스킨인 `clean_notice` 작업에 대한 복구 지침입니다.

## 1. 긴급 파일 복구 (File Recovery)
작업 전 백업된 스킨 폴더 위치: `C:\gnuboard\_backups\20260316_1048_Clean_Notice_Skin/`

### 복구 방법 (PowerShell)
```powershell
$backupDir = "C:\gnuboard\_backups\20260316_1048_Clean_Notice_Skin\skins"
$targetDir = "C:\gnuboard\plugin\latest_skin_manager\skins"

# 새로운 스킨 폴더 삭제 후 백업본으로 복원
Remove-Item "$targetDir\clean_notice" -Recurse -Force -ErrorAction SilentlyContinue
Copy-Item "$backupDir\*" -Destination $targetDir -Recurse -Force
```

## 2. 작업 내용
- **신규 폴더**: `plugin/latest_skin_manager/skins/clean_notice/`
- **신규 파일**:
  - `skin_info.php`: 스킨 메타데이터 (관리자 스킨 선택용)
  - `latest.skin.php`: 제목/날짜 위주의 깔끔한 리스트 렌더링 로직

## 3. 주요 설정 및 변수
- **디자인 컨셉**: Kukdong Panel 테마와 어울리는 미니멀리즘.
- **표시 항목**: 글제목 (`wr_subject`), 날짜 (`wr_datetime`).
- **연동**: `skin.head.php`를 인클루드하여 공통 타이틀 스타일 사용.

## 4. 장애 현상별 대책
- **관리자 페이지에서 스킨이 안 보임**: `skin_info.php` 파일이 존재하는지, 경로가 정확한지 확인하십시오.
- **날짜 형식이 이상함**: `latest.skin.php` 내의 `date()` 포맷을 수정하십시오.
- **레이아웃 깨짐/상단 공백**: 파일에 **BOM**이 포함되었는지 확인하고, 없으면 BOM 없는 UTF-8로 재저장하십시오.