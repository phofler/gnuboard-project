# HOW_TO_RECOVER_APPLE_FONT.md (애플 폰트 작업 복구 가이드)

본 문서는 애플 폰트(Pretendard) 모듈화 작업 중 문제 발생 시, 시스템을 1초 내에 최상 상태로 복구하기 위한 지침입니다.

## 1. 개요
- **작업명**: 애플 폰트(Pretendard) 라이브러리화 및 적용
- **작업 일시**: 2026-03-15 17:45
- **백업 위치**: `C:\gnuboard\_backups\20260315_1745_apple_font`

## 2. 복구 대상 파일
작업 중 수정되거나 생성된 파일 목록입니다.
1. `C:\gnuboard\extend\font_manager.extend.php` (신규 생성)
2. `C:\gnuboard\theme\kukdong_panel\head.sub.php` (수정)
3. `C:\gnuboard\theme\kukdong_panel\style.css` (수정)

## 3. 긴급 복구 명령 (Emergency Recovery)

문제가 발생하면 PowerShell을 열고 다음 명령어를 실행하십시오. (백업본 덮어쓰기)

```powershell
# 1. 수정된 파일 원복
cp C:\gnuboard\_backups\20260315_1745_apple_font\head.sub.php C:\gnuboard\theme\kukdong_panel\head.sub.php -Force
cp C:\gnuboard\_backups\20260315_1745_apple_font\style.css C:\gnuboard\theme\kukdong_panel\style.css -Force

# 2. 생성된 신규 파일 제거
rm C:\gnuboard\extend\font_manager.extend.php -ErrorAction SilentlyContinue
```

## 4. 체크리스트 (심화 복구)
- **화면 깨짐**: `head.sub.php`의 인코딩이 UTF-8 With BOM으로 저장되었는지 확인하십시오. (반드시 BOM 없음이어야 함)
- **폰트 미적용**: 브라우저 콘솔에서 CDN 로드 오류 여부를 확인하십시오.
- **PHP 에러**: `extend/font_manager.extend.php`의 문법 오류를 확인하십시오.

## 5. 원본 파일 상태 기록
- `head.sub.php`: Google Fonts(Inter, Noto Sans KR) 하드코딩 상태
- `style.css`: `font-family: 'Inter', 'Noto Sans KR', sans-serif;` 하드코딩 상태
