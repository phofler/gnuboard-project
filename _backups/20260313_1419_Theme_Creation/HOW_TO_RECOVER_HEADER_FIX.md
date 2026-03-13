# HOW_TO_RECOVER_HEADER_FIX.md

서브페이지(`product_01.html`)의 헤더 시인성 문제 해결을 위한 복구 지침입니다.

## 1. 백업 정보
- **백업 일시**: 2026-03-10 12:32:16
- **백업 위치**: `f:\gnuboard\_backups\20260310_123216_Subpage_Header_Fix/`
- **백업 파일**: `product_01.html`, `style.css`

## 2. 수동 복구 단계
문제가 발생했을 경우 아래 명령어를 PowerShell에 붙여넣어 즉시 복구할 수 있습니다.

```powershell
$backupDir = "f:\gnuboard\_backups\20260310_123216_Subpage_Header_Fix"
$targetDir = "f:\gnuboard\main\판넬\2"
Copy-Item -Path "$backupDir\product_01.html" -Destination "$targetDir\product_01.html" -Force
Copy-Item -Path "$backupDir\style.css" -Destination "$targetDir\style.css" -Force
Write-Output "Header fix recovered to original state."
```

## 3. 수정 사항 요약
1.  **HTML (`product_01.html`)**: `<body>` 태그에 `sub-page` 클래스 추가.
    - `<body class="sub-page">`
2.  **CSS (`style.css`)**: `.sub-page` 선택자를 사용하여 헤더 배경을 흰색(`#fff`)으로 강제 고정하고 로고 필터 반전 제거.
    - 주요 타겟: `.sub-page header .gnbWrapBg`, `.sub-page header .logo img`, `.sub-page .gnb > li > a` 등.

## 4. 주의사항
- 모든 작업물은 **BOM 없는 UTF-8** 형식을 유지해야 합니다.
- 수정 후 메인 페이지(`index.html`)의 투명 헤더 효과가 정상 작동하는지 반드시 확인하십시오.
