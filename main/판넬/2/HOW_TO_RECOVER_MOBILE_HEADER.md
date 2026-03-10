# HOW_TO_RECOVER_MOBILE_HEADER.md

모바일 헤더 레이아웃(좌: 햄버커, 중: 로고, 우: 전화) 작업 중 문제 발생 시 복구 가이드입니다.

## 1. 개요
- **작업 내용**: 모바일 헤더 구성 요소를 성우패널시스템 스타일로 재배치.
- **작업 일시**: 2026-03-09 16:42

## 2. 복구 방법 (Emergency)

### 방법 1: 백업 복원 (PowerShell)
```powershell
$backupDir = "f:\gnuboard\_backups\20260309_1642_MobileHeaderLayout"
Copy-Item "$backupDir\style.css" -Destination "f:\gnuboard\main\판넬\2\style.css" -Force
Copy-Item "$backupDir\index.html" -Destination "f:\gnuboard\main\판넬\2\index.html" -Force
# 로컬 루트 동기화
Copy-Item "$backupDir\style.css" -Destination "f:\gnuboard\style.css" -Force
Copy-Item "$backupDir\index.html" -Destination "f:\gnuboard\index.html" -Force
```

## 3. 주요 수정 사항
- [style.css](file:///f:/gnuboard/main/판넬/2/style.css): `@media (max-width: 1024px)` 내 레이아웃 로직.
- [index.html](file:///f:/gnuboard/main/판넬/2/index.html): 로고 및 버튼 순서/아이콘.
