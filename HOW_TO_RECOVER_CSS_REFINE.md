# HOW_TO_RECOVER_CSS_REFINE.md (CSS 및 스킨 정제 작업 복구 가이드)

본 문서는 CSS 중복 제거, 누락 변수 추가, 그리고 Product Introduction 스킨 디자인 정제 작업 중 문제 발생 시 복구하기 위한 지침입니다.

## 1. 개요
- **작업명**: CSS 중복 제거 및 Product Introduction 스킨 강화
- **작업 일시**: 2026-03-15 18:05
- **백업 위치**: `C:\gnuboard\_backups\20260315_1805_css_refine`

## 2. 복구 대상 파일
1. `C:\gnuboard\theme\kukdong_panel\style.css` (수정)
2. `C:\gnuboard\plugin\main_content_manager\skins\product_intro\style.css` (수정)

## 3. 긴급 복구 명령 (Emergency Recovery)

PowerShell에서 아래 명령을 실행하여 원본 상태로 즉시 복구할 수 있습니다.

```powershell
# 1. 테마 CSS 복구
cp C:\gnuboard\_backups\20260315_1805_css_refine\style.css C:\gnuboard\theme\kukdong_panel\style.css -Force

# 2. 스킨 CSS 복구
cp C:\gnuboard\_backups\20260315_1805_css_refine\style.css C:\gnuboard\plugin\main_content_manager\skins\product_intro\style.css -Force
```

## 4. 체크리스트
- **인코딩 확인**: 복구 후 사이트의 한글이 깨진다면, 파일이 `UTF-8 (BOM 없음)` 형식인지 확인하십시오.
- **캐시 문제**: CSS 수정 사항이 반영되지 않으면 브라우저에서 `Ctrl + F5`를 눌러 강력 새로고침을 수행하십시오.
