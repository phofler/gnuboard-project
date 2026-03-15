# HOW_TO_RECOVER_MENU_ICONS.md

이 문서는 메가 메뉴 아이콘 추가 작업에 대한 성실한 복구 지침입니다.

## 1. 파일 정보
- **대상 파일**: 
  - `f:\gnuboard\main\판넬\2\index.html`
  - `f:\gnuboard\main\판넬\2\style.css`
- **백업 위치**: `f:\gnuboard\_backups/` 내 최신 `[날짜_시간_Enhancing_Menu_With_Icons]` 폴더
- **인코딩**: UTF-8 (BOM 없음)

## 2. 복구 방법 (1초 복구)
문제가 발생하면 백업 폴더의 파일을 각각 원래 위치(`f:\gnuboard\main\판넬\2/`)로 즉시 덮어씌우십시오.

## 3. 수정 사항
- **아이콘 추가**:
  - 회사소개: `fa-building-columns` 아이콘 적용
  - 제품소개: `fa-boxes-stacked` 아이콘 적용
  - 부자재: `fa-screwdriver-wrench` 아이콘 적용
- **스타일링**:
  - `menu-icon-bg` 클래스를 사용하여 배경에 대형 반투명 아이콘 배치
  - `dep2Img` 영역에 공간감 부여

---
**주의**: 고스트 세이브/BOM 오염 방지를 위해 반드시 PowerShell `$utf8NoBom = New-Object System.Text.UTF8Encoding $false` 방식을 사용하여 저장되었습니다.
