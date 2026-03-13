# HOW_TO_RECOVER_MAIN_SLIDER.md

이 문서는 메인 슬라이더 폰트 조정 작업(`20260309_1252_SliderFontFix`) 중 문제 발생 시 1초 만에 최상의 상태로 되돌리기 위한 지침입니다.

## 1. 긴급 복구 방법 (파일 단위)
문제가 발생하면 아래 명령어를 PowerShell에 입력하여 즉시 원상복구하십시오.

```powershell
$backupDir = "f:\gnuboard\main\판넬\2\_backups\20260309_1252_SliderFontFix"
Copy-Item "$backupDir\style.css" "f:\gnuboard\main\판넬\2\style.css" -Force
Copy-Item "$backupDir\index.html" "f:\gnuboard\main\판넬\2\index.html" -Force
```

## 2. 주요 변경 사항 정보
- **파일명**: `f:\gnuboard\main\판넬\2\style.css`
- **변경 목적**: 메인 슬라이더 중앙 텍스트 크기 축소 (가독성 개선)
- **변경 전**: h2 (5rem), p (2rem), margin-bottom (30px)
- **변경 후**: h2 (3.3rem), p (1.3rem), margin-bottom (20px)

## 3. 주의 사항
- 파일 저장 시 **BOM 없는 UTF-8** 형식을 엄수해야 합니다.
- 수정 후 반드시 브라우저 새로고침(F5)을 통해 디자인을 직접 확인하십시오.
- 인코딩이 깨진 경우 위 복구 명령어를 즉시 실행하십시오.