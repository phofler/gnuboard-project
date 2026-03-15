# 🚨 긴급 복구 매뉴얼: 상단 메뉴(Top Menu Manager) 공통 함수화 롤백

**목적:** `display_top_menu()` 함수화 및 스킨(`basic`, `transparent`) 분리 작업 중 문제가 발생했을 때, 단 1초 만에 작업 이전의 안정적인 상태로 되돌리기 위한 지침서입니다.

## 📌 1. 백업 데이터 위치
**백업 디렉토리:** `C:\gnuboard\_backups\20260315_1234_Top_Menu_Refactor\`

이 폴더에는 다음 수정 전 원본 파일들이 보관되어 있습니다.
1. `head.php` (하드코딩된 원본 헤더 HTML 포함)
2. `style.css` (테마 원래 스타일)
3. `lib.php` (파라미터 변경 전 원본 라이브러리)
4. `skins/` (기존 모든 상단 메뉴 스킨 폴더)

---

## 🛠 2. 1초 복구 (즉시 롤백) 방법

### 방법 A: PowerShell (권장 - 가장 빠르고 확실함)
관리자 권한의 Windows PowerShell을 열고 아래 스크립트를 그대로 복사하여 실행하세요. (BOM 오염을 방지하고 정확하게 원본을 덮어씌웁니다)

```powershell
$backupDir = "C:\gnuboard\_backups\20260315_1234_Top_Menu_Refactor"
$targetTheme = "C:\gnuboard\theme\kukdong_panel"
$targetPlugin = "C:\gnuboard\plugin\top_menu_manager"

Write-Output "1. 테마 파일 복구 중..."
Copy-Item -Path "$backupDir\head.php" -Destination "$targetTheme\head.php" -Force
Copy-Item -Path "$backupDir\style.css" -Destination "$targetTheme\style.css" -Force

Write-Output "2. 플러그인 로직 복구 중..."
Copy-Item -Path "$backupDir\lib.php" -Destination "$targetPlugin\lib.php" -Force

Write-Output "3. 스킨 폴더 원본 복구 중..."
Copy-Item -Path "$backupDir\skins\*" -Destination "$targetPlugin\skins\" -Recurse -Force

Write-Output "✅ 복구 완료! 브라우저 캐시를 지우고 새로고침(F5) 하세요."
```

### 방법 B: 수동 파일 덮어쓰기 (탐색기 이용)
명령어 사용이 익숙하지 않거나 권한 문제가 있다면, 다음 순서로 직접 복사하여 덮어쓰기를 진행하십시오.

1. 파일 탐색기에서 `C:\gnuboard\_backups\20260315_1234_Top_Menu_Refactor\` 폴더를 엽니다.
2. `head.php`와 `style.css`를 복사하여 `C:\gnuboard\theme\kukdong_panel\` 폴더 안에 붙여넣고 덮어쓰기 합니다.
3. `lib.php`를 복사하여 `C:\gnuboard\plugin\top_menu_manager\` 폴더 안에 붙여넣고 덮어쓰기 합니다.
4. `skins` 폴더 내부의 모든 폴더(`basic`, `transparent` 등)를 복사하여 `C:\gnuboard\plugin\top_menu_manager\skins\` 내부에 덮어쓰기 합니다.

---

## 🔎 3. 복구 후 필수 자가 진단 체크리스트
복구 후 사이트(메인, 템플릿 포함) 접속 시 다음 사항을 확인하세요:
- [ ] 브라우저 개발자 도구 (F12) 콘솔 탭에 빨간색 Syntax 에러가 뜨지 않는가?
- [ ] 상단 메뉴 바가 예전의 투명 또는 하얀색 디자인으로 정상 출력되는가?
- [ ] 모바일(화면 좁힘) 환경에서 햄버거 메뉴를 눌렀을 때 검은색 전체 화면 메뉴가 정상적으로 슬라이드 다운되는가?
- [ ] 사이트 최상단이나 공백 영역에 알 수 없는 쓰레기 문자(BOM 흔적)가 출력되지 않는가?

만약 여전히 문제가 남는다면, 즉시 AI 에이전트나 코워커에게 `HOW_TO_RECOVER` 문서를 제시하며 롤백 성공 여부를 확인 요청하세요.
