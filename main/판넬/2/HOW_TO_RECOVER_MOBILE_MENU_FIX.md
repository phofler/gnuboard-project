# HOW_TO_RECOVER_MOBILE_MENU_FIX.md

이 문서는 모바일 메뉴의 아코디언 기능 및 왼쪽 슬라이드 방향 수정 작업에 대한 복구 지침입니다.

## 1. 전용 백업 저장소
- **백업 위치**: `f:\gnuboard\_backups/20260310_110000_Mobile_Menu_Fix/` (최신 날짜 확인)
- **대상 파일**: `index.html`, `style.css`

## 2. 복구 방법 (1초 복구)
문제가 발생하면 백업 폴더의 파일을 원래 위치(`f:\gnuboard\main\판넬\2/`)로 즉시 복사하십시오.

## 3. 주요 수정 사항
- **방향**: 메뉴가 오른쪽(`right`)이 아닌 왼쪽(`left`)에서 나오도록 수정.
- **아코디언**: 모바일에서 대메뉴 클릭 시 서브메뉴가 펼쳐지고 다시 클릭하면 닫히는 기능 적용.
- **텍스트**: 메뉴명이 길 경우 말줄임표(`...`) 처리.
- **인코딩**: BOM 없는 UTF-8 ($false) 준수.

---
**주의**: 고스트 세이브/BOM 오존 방지를 위해 반드시 PowerShell `$utf8NoBom = New-Object System.Text.UTF8Encoding $false` 방식을 유지해야 합니다.
