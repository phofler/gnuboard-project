# 카피라이트 스킨 라이브러리(B~D) 표준화 복구 가이드 (HOW_TO_RECOVER_COPYRIGHT_SKINS_LIBRARY.md)

## 🚨 위급 상황 발생 시 (1초 복구 루틴)
작업 중 푸터 스킨 선택 시 레이아웃이 깨지거나 스타일이 비정상적이면 즉시 수행하십시오.

### 1단계: 물리 파일 복구
백업 폴더(`C:\gnuboard\_backups/20260316_1220_Copyright_Skins_Library_Standardization/`)에서 파일을 복구합니다.

```powershell
# 모든 스킨(B, C, D) 일괄 복구
$skins = @("style_b", "style_c", "style_d")
$backupDir = "C:\gnuboard\_backups\20260316_1220_Copyright_Skins_Library_Standardization"
foreach ($skin in $skins) {
    Copy-Item "$backupDir\$skin\*" "C:\gnuboard\plugin\copyright_manager\skins\$skin\" -Force
}
```

### 2단계: 브라우저 캐시 삭제
`Ctrl + F5`를 눌러 새로고침하십시오.

---

## 🛠 수정된 내용
1. **Style B, C, D (PHP)**: `$cp` 직접 참조에서 `$txt_addr`, `$txt_tel` 등 표준 공유 변수 체계로 리팩토링.
2. **Style B, C, D (CSS)**: 하드코딩된 색상/폰트 스타일을 `--color-brand`, `--color-accent` 등 테마 전역 변수와 연동.
3. **BOM 관리**: 모든 파일은 BOM 없는 UTF-8로 저장됨.

## 📌 주의사항
- 스킨을 변경할 때 레이아웃이 즉시 반영되지 않으면 `style.css`에 캐시 넘버링(`ver=time()`)이 적용되어 있는지 확인하십시오.