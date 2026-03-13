# HOW_TO_RECOVER_MENU_SY.md

이 문서는 SY World 스타일 메뉴 개편 작업(`20260309_1324_MenuSY`) 도중 문제가 발생할 경우 즉각 복구하기 위한 지침입니다.

## 1. 1초 원상복구 명령어 (PowerShell)
문제가 발생하면 즉시 아래 명령어를 실행하십시오.

```powershell
$backupDir = "f:\gnuboard\main\판넬\2\_backups\20260309_1324_MenuSY"
Copy-Item "$backupDir\index.html" "f:\gnuboard\main\판넬\2\index.html" -Force
Copy-Item "$backupDir\style.css" "f:\gnuboard\main\판넬\2\style.css" -Force
```

## 2. 주요 작업 내용
- **GNB & Mega Menu**: `syworld.kr`의 HTML/CSS 구조(Left Panel + Right Content)를 이식.
- **레이아웃**: `dep2Wrap` (GNB 하단 전체), `dep2Img` (왼쪽 설명), `dep2` (오른쪽 메뉴 그리드).
- **데이터**: 사용자가 요청한 성우첨단패널 전용 제품군 17종 이상을 카테고리별로 배치.

## 3. 핵심 준수 사항
- **BOM 없는 UTF-8**: 한글 깨짐 및 PHP 로딩 오류 방지.
- **고스트 세이브 방지**: 에이전트 도구 대신 PowerShell 직접 기록 방식 사용.

## 4. 백업 파일 위치
- `f:\gnuboard\main\판넬\2\_backups\20260309_1324_MenuSY`
