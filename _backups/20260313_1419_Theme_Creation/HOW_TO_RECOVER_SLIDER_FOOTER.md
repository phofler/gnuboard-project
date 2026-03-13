# HOW_TO_RECOVER_SLIDER_FOOTER.md

## 1. 개요
메인 페이지 슬라이더의 첫 번째 이미지를 삭제하고 하단 카피라이트 문구를 두 줄로 변경하였습니다.

## 2. 파일 정보
- **대상 파일**: `f:\gnuboard\main\판넬\2\index.html`
- **백업 위치**: `f:\gnuboard\_backups\2026-03-10_14-20_slider_footer_update\index.html.bak`

## 3. 변경 사항
- **메인 슬라이더**: 첫 번째 슬라이드(`factory.jpg`) 삭제 후 두 번째 슬라이드를 `active`로 설정.
- **하단 카피라이트**: `ALL RIGHTS RESERVED.` 앞에 `<br>` 태그를 추가하여 두 줄로 표시되도록 수정.
- **JavaScript**: 슬라이드가 여러 개일 때만 전환 로직이 작동하도록 조건문 추가.

## 4. 복구 방법
문제가 발생할 경우 아래 명령어를 사용하여 원본 파일로 복구할 수 있습니다.
```powershell
cp "f:\gnuboard\_backups\2026-03-10_14-20_slider_footer_update\index.html.bak" "f:\gnuboard\main\판넬\2\index.html"
```
