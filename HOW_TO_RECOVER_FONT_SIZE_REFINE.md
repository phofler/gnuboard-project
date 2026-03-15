# HOW_TO_RECOVER_FONT_SIZE_REFINE.md (폰트 크기 전역 변수화 복구 가이드)

## 1. 개요
- **작업명**: 본문 설명(.desc) 폰트 크기 전역 변수화
- **작업 일시**: 2026-03-15 18:11
- **백업 위치**: `C:\gnuboard\_backups\20260315_1811_font_size_refine`

## 2. 복구 대상 파일
1. `C:\gnuboard\theme\kukdong_panel\style.css` (수정)
2. `C:\gnuboard\plugin\main_content_manager\skins\product_intro\style.css` (수정)

## 3. 긴급 복구 명령
```powershell
cp C:\gnuboard\_backups\20260315_1811_font_size_refine\style.css C:\gnuboard\theme\kukdong_panel\style.css -Force
cp C:\gnuboard\_backups\20260315_1811_font_size_refine\style.css C:\gnuboard\plugin\main_content_manager\skins\product_intro\style.css -Force
```
