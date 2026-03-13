# HOW_TO_RECOVER_MOBILE_MENU_HEADER.md

이 문서는 모바일 메뉴 헤더 개선 작업(`20260313_1235_MobileMenuHeaderImprovement`) 중 문제 발생 시 즉각 복구하기 위한 지침입니다.

## 1. 긴급 복구 방법 (PowerShell)
문제가 발생하면 아래 명령어를 PowerShell에 입력하여 파일을 원상복구하십시오. (BOM 없는 UTF-8 형식 유지)

```powershell
$backupDir = "F:\gnuboard\main\판넬\2\_backups\20260313_1235_MobileMenuHeaderImprovement"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false

# index.html 복구
$content1 = [System.IO.File]::ReadAllText("$backupDir\index.html")
[System.IO.File]::WriteAllText("F:\gnuboard\main\판넬\2\index.html", $content1, $utf8NoBom)

# style.css 복구
$content2 = [System.IO.File]::ReadAllText("$backupDir\style.css")
[System.IO.File]::WriteAllText("F:\gnuboard\main\판넬\2\style.css", $content2, $utf8NoBom)
```

## 2. 주요 변경 사항
- **index.html**: `.m-menu-wrap` 내부에 `.m-menu-header` (로고, 전화, 이메일 아이콘) 추가
- **style.css**: 
    - `.m-menu-wrap`의 상단 패딩 축소 (80px -> 30px)
    - `.m-menu-header` 및 관련 아이콘 버튼 스타일 정의

## 3. 주의 사항
- 파일 수정 시 반드시 **BOM 없는 UTF-8** 형식을 사용해야 합니다.
- 수정 후 모바일 뷰에서 디자인이 깨지거나 버튼이 겹칠 경우 즉시 위 복구 명령어를 실행하십시오.