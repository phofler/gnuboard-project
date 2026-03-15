# HOW_TO_RECOVER_HEADER.md

이 문서는 헤더 반응형 수정 작업 중 문제가 발생했을 때 1초 만에 복구하기 위해 작성되었습니다.

## 1. 개요
- **작업 내용**: 모바일/태블릿(1024px 이하)에서 GNB 및 CONTACT 버튼 숨김 처리.
- **작업 일시**: 2026-03-09 16:25

## 2. 복구 방법 (Emergency Recovery)

### 방법 1: 백업 파일 덮어쓰기
문제가 발생하면 아래 명령어를 PowerShell에 입력하십시오.
```powershell
$backupDir = "f:\gnuboard\_backups\20260309_1625_HeaderRefine"
Copy-Item "$backupDir\style.css" -Destination "f:\gnuboard\main\판넬\2\style.css" -Force
Copy-Item "$backupDir\index.html" -Destination "f:\gnuboard\main\판넬\2\index.html" -Force
# 루트 파일도 동기화한 경우
Copy-Item "$backupDir\style.css" -Destination "f:\gnuboard\style.css" -Force
Copy-Item "$backupDir\index.html" -Destination "f:\gnuboard\index.html" -Force
```

### 방법 2: Git 되돌리기
```bash
git checkout style.css
git checkout index.html
```

## 3. 주요 수정 파일
- [style.css](file:///f:/gnuboard/main/판넬/2/style.css)
- [index.html](file:///f:/gnuboard/main/판넬/2/index.html)
