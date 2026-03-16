# 카피라이트 모듈 표준화 복구 가이드 (HOW_TO_RECOVER_COPYRIGHT.md)

## 🚨 위급 상황 발생 시 (1초 복구 루틴)
작업 중 푸터 영역이 사라지거나 레이아웃이 깨지면 즉시 수행하십시오.

### 1단계: 물리 파일 복구
백업 폴더(`C:\gnuboard\_backups/yyyyMMdd_HHmm_Copyright_Standardization/`)에서 파일을 복구합니다.

```powershell
# lib.php 복구
Copy-Item "C:\gnuboard\_backups\yyyyMMdd_HHmm_Copyright_Standardization\lib.php" "C:\gnuboard\plugin\copyright_manager\lib.php" -Force

# style_a 스킨 복구 (예시)
Copy-Item "C:\gnuboard\_backups\yyyyMMdd_HHmm_Copyright_Standardization\footer.skin.php" "C:\gnuboard\plugin\copyright_manager\skins\style_a\footer.skin.php" -Force
Copy-Item "C:\gnuboard\_backups\yyyyMMdd_HHmm_Copyright_Standardization\style.css" "C:\gnuboard\plugin\copyright_manager\skins\style_a\style.css" -Force
```

### 2단계: 브라우저 캐시 삭제
`Ctrl + F5`를 눌러 새로고침하십시오.

---

## 🛠 수정된 내용 (표준화 핵심)
1. **lib.php**: `copyright_widget($cp_id)` 함수 추가 및 `set_pro_skin_context()` 연동.
2. **Skins**: 하드코딩된 색상을 테마 디자인 토큰(`--color-brand`, `--color-accent` 등)으로 대체.
3. **BOM 관리**: 모든 파일은 BOM 없는 UTF-8로 저장됨.

## 📌 위젯 설정 안내
- 푸터 출력이 되지 않을 경우, 관리자 페이지 [카피라이트 관리]에서 테마 ID가 현재 활성화된 테마 명칭과 일치하는지 확인하십시오.