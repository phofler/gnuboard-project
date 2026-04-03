# HOW_TO_RECOVER_WIDGET_CONN.md (메인페이지 위젯 연결 복구 지침)

본 문서는 `kukdong_panel` 테마의 메인 페이지에 최근글 위젯을 연결하는 작업 중 발생할 수 있는 문제를 해결하기 위한 지침입니다.

## 1. 긴급 파일 복구 (File Recovery)
작업 전 백업된 원본 파일 위치: `C:\gnuboard\_backups\20260316_1025_Widget_Connection/`

### 복구 방법 (PowerShell)
```powershell
$backupDir = "C:\gnuboard\_backups\20260316_1025_Widget_Connection"
$targetFile = "C:\gnuboard\theme\kukdong_panel\index.php"

# 원본 파일 복원
Copy-Item "$backupDir\index.php" -Destination $targetFile -Force
```

## 2. 작업 내용
- **대상 파일**: `theme/kukdong_panel/index.php`
- **변경 사항**: 
  - 하단 `bottom-links` 섹션의 하드코딩된 `latest()` 호출을 `latest_widget(5)`로 교체.
  - 상단에 `latest_skin_manager/lib/latest_skin.lib.php` 라이브러리 추가 호출.

## 3. 장애 현상별 대책
- **메인 페이지 로딩 실패 (White Screen)**: `include_once` 경로에 오류가 있는지 확인하십시오.
- **위젯 출력 오류**: 관리자 페이지의 `보드최근글스킨관리`에서 식별코드 `5`번 위젯이 실존하는지 확인하십시오.
- **BOM 오염**: 레이아웃이 깨지거나 상단에 공백이 생기면 파일의 BOM 존재 여부를 확인하십시오.