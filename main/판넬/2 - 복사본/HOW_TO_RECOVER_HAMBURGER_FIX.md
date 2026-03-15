# HOW_TO_RECOVER_HAMBURGER_FIX.md

이 문서는 햄버거 메뉴 가시성 수정 작업 중 문제가 발생했을 때 복구하기 위해 작성되었습니다.

## 1. 개요
- **작업 내용**: 모바일/태블릿 환경에서 햄버거 메뉴 아이콘이 보이지 않는 문제 해결.
- **작업 일시**: 2026-03-09 16:36

## 2. 복구 방법

### 방법 1: 백업 파일 복원
```powershell
$backupDir = "f:\gnuboard\_backups\20260309_1636_HamburgerFix"
Copy-Item "$backupDir\style.css" -Destination "f:\gnuboard\main\판넬\2\style.css" -Force
Copy-Item "$backupDir\index.html" -Destination "f:\gnuboard\main\판넬\2\index.html" -Force
```

## 3. 수정 파일
- [style.css](file:///f:/gnuboard/main/판넬/2/style.css)
- [index.html](file:///f:/gnuboard/main/판넬/2/index.html)
