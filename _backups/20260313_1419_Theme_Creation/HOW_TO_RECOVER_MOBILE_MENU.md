# HOW TO RECOVER: Mobile Menu Implementation

모바일 메뉴 구현 중 문제가 발생했을 때 즉각 복구하기 위한 지침입니다.

## 1. 개요
- **작업 내용**: 모바일 햄버거 버튼 활성화 및 사이드 메뉴(Drawer) 구현
- **수정 파일**: `index.html`, `style.css`
- **백업 위치**: `f:\gnuboard\_backups\20260309_1507_MobileMenuFix`

## 2. 복구 방법

### 방법 A: 파일 덮어쓰기 (강력 권장)
문제가 발생하면 아래 명령어를 PowerShell에 입력하여 백업 시점으로 되돌립니다.
```powershell
$backupDir = "f:\gnuboard\_backups\20260309_1507_MobileMenuFix"
Copy-Item "$backupDir\index.html" -Destination ".\index.html" -Force
Copy-Item "$backupDir\style.css" -Destination ".\style.css" -Force
```

### 방법 B: 코드 체크포인트
- **HTML**: `header` 태그 아래에 `<div class="m-menu-wrap">`이 정상적으로 삽입되었는지 확인.
- **JS**: 하단 스크립트에 `$('.btnAllmenu').on('click', ...)` 로직이 포함되어 있는지 확인.
- **CSS**: `@media (max-width: 1024px)` 섹션에서 `.btnAllmenu`의 `display: block` 여부 확인.

## 3. 주의 사항
- 모든 파일은 반드시 **BOM 없는 UTF-8** 형식을 유지해야 합니다.
- 수정 후 한글이 깨진다면 백업 파일을 다시 복사하십시오.