# HOW_TO_RECOVER_CATALOG_SEO.md

그라스울 패널 서브페이지(`product_01.html`)의 카달로그 SEO 코딩 작업에 대한 복구 지침입니다.

## 1. 백업 정보
- **백업 일시**: 2026-03-10 12:55:20
- **백업 위치**: `f:\gnuboard\_backups\20260310_125520_Catalog_SEO_Coding/`
- **백업 파일**: `product_01.html`, `style.css`

## 2. 수동 복구 단계
문제가 발생했을 경우 아래 명령어를 PowerShell에 붙여넣어 즉시 복구할 수 있습니다.

```powershell
$backupDir = "f:\gnuboard\_backups\20260310_125520_Catalog_SEO_Coding"
$targetDir = "f:\gnuboard\main\판넬\2"
Copy-Item -Path "$backupDir\product_01.html" -Destination "$targetDir\product_01.html" -Force
Copy-Item -Path "$backupDir\style.css" -Destination "$targetDir\style.css" -Force
Write-Output "Catalog SEO coding recovered to original state."
```

## 3. 수정 사항 요약
1.  **HTML (`product_01.html`)**: 
    - 카달로그 이미지 내의 텍스트와 표 데이터를 HTML 태그(`<table>`, `<ul>`, `<h3>` 등)로 직접 코딩하여 SEO를 강화했습니다.
    - 특장점(Features), 제원(Specifications), 성능 데이터(Performance Data) 섹션을 추가했습니다.
2.  **CSS (`style.css`)**: 
    - `.sub-h4`, `.seo-text-block`, `.performance-list`, `.catalog-viewer` 등 검색 엔진 가독성과 심미성을 위한 스타일을 추가했습니다.

## 4. 주의사항
- 모든 작업물은 **BOM 없는 UTF-8** 형식을 유지해야 합니다 (PowerShell $false 사용).
- 30여 장의 추가 작업 시에도 동일한 클래스 구조를 반복 사용하여 일관성을 유지하십시오.
