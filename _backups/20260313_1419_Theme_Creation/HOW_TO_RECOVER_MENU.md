# HOW_TO_RECOVER_MENU.md

이 문서는 메뉴 체계 개편 작업(`20260309_1316_MenuRestructure`) 중 문제가 발생했을 때 즉각적인 복구를 위해 작성되었습니다.

## 1. 긴급 복구 지침 (1초 복구)
디자인이 깨지거나 파일 저장 오류(고스트 세이브) 등으로 인해 문제가 발생하면 아래 명령어를 PowerShell에 입력하여 원본 상태로 되돌리십시오.

```powershell
$backupDir = "f:\gnuboard\main\판넬\2\_backups\20260309_1316_MenuRestructure"
Copy-Item "$backupDir\index.html" "f:\gnuboard\main\판넬\2\index.html" -Force
Copy-Item "$backupDir\style.css" "f:\gnuboard\main\판넬\2\style.css" -Force
```

## 2. 주요 변경 사항
- **GNB 구조**: 기존 2단 구조에서 **1단(대메뉴) - 2단(카테고리) - 3단(상세 항목)**의 3단계 구조로 개편.
- **메가 메뉴**: 대량의 제품 항목(17종 이상)을 효과적으로 보여주기 위해 **그리드/다단 레이아웃** 적용.
- **저장 방식**: 한글 깨짐 및 고스트 세이브 방지를 위해 **BOM 없는 UTF-8** 형식을 엄수함.

## 3. 기술적 주의사항
- **인코딩**: 모든 수정은 PowerShell의 `[System.IO.File]::WriteAllText` 메서드를 사용하여 `$false`(BOM 없음) 옵션으로 저장해야 함.
- **GNB 링크**: 현재는 `href="#"` 또는 기존 파일명으로 연결되어 있으며, 추후 실제 서비 페이지(카달로그 편집본) 생성 시 링크 수정이 필요함.

## 4. 백업 위치
- `f:\gnuboard\main\판넬\2\_backups\20260309_1316_MenuRestructure`
