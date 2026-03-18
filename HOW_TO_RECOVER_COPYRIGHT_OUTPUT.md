# 카피라이트 출력 누락 해결 복구 가이드 (HOW_TO_RECOVER_COPYRIGHT_OUTPUT.md)

## 🚨 위급 상황 발생 시 (1초 복구 루틴)
작업 중 사이트 접속이 안 되거나 푸터 에러가 발생하면 즉시 수행하십시오.

### 1단계: 물리 파일 복구
백업 폴더(`C:\gnuboard\_backups/yyyyMMdd_HHmm_Copyright_Output_Fix/`)에서 파일을 복구합니다.

```powershell
# 00_load_plugins.php 복구
Copy-Item "C:\gnuboard\_backups\yyyyMMdd_HHmm_Copyright_Output_Fix\00_load_plugins.php" "C:\gnuboard\extend\00_load_plugins.php" -Force

# 신규 생성 파일 삭제 (선택 사항)
Remove-Item "C:\gnuboard\plugin\copyright_manager\hook.php" -ErrorAction SilentlyContinue
```

### 2단계: 브라우저 캐시 삭제
`Ctrl + F5`를 눌러 새로고침하십시오.

---

## 🛠 수정된 내용
1. **00_load_plugins.php**: `$active_plugins` 배열에 `'copyright_manager'`를 추가하여 플러그인 활성화.
2. **hook.php (신규)**: 플러그인 로드 시 `lib.php`를 자동으로 호출하도록 연동.
3. **BOM 관리**: 모든 파일은 BOM 없는 UTF-8로 저장됨.

## 📌 주의사항
- 플러그인 활성화 후에도 출력이 되지 않는다면, 관리자 페이지 [카피라이트 관리]에서 테마 ID(`kukdong_panel`) 데이터가 정상적으로 저장되어 있는지 확인하십시오.