# 디자인 토큰 통합 복구 가이드 (HOW_TO_RECOVER_DESIGN_TOKEN.md)

## 🚨 위급 상황 발생 시 (1초 복구 루틴)
만약 `style.css` 수정 후 레이아웃이 깨지거나, PHP 에러(`SyntaxError`, `Undefined variable`)가 발생하면 다음 단계를 즉시 수행하십시오.

### 1단계: 물리 파일 복구
가장 최근의 백업 폴더(`C:\gnuboard\_backups/yyyyMMdd_HHmm_Design_Token_Unification/`)에서 파일을 복사하여 원본 위치에 덮어씌웁니다.

```powershell
# 예시: style.css 복구
Copy-Item "C:\gnuboard\_backups\yyyyMMdd_HHmm_Design_Token_Unification\style.css" "C:\gnuboard\theme\kukdong_panel\style.css" -Force
```

### 2단계: 브라우저 캐시 삭제
CSS 수정 사항이 반영되지 않거나 꼬여 보일 경우 `Ctrl + F5`를 눌러 강력 새로고침을 수행하십시오.

---

## 🛠 수정된 내용 (Checklist)
1. **theme/kukdong_panel/style.css**: 
   - `:root`에 별칭(Alias) 변수 매핑 추가.
   - `--color-text-primary`, `--color-brand` 등 표준 변수와 기존 테마 변수 연결.
2. **plugin/latest_skin_manager/skins/**:
   - `clean_notice`, `works_dark`, `skin.head.php`에서 `!important` 제거.
   - `--primary-dark` 같이 테마에 종속된 변수 대신 `--color-text-primary` 같은 표준 변수 사용.

## 📌 주요 변수 매핑 정보
- `--color-text-primary` ➜ `var(--text-main, #333)`
- `--color-brand` ➜ `var(--edge-color, #c92127)`
- `--color-accent-gold` ➜ `#d4af37`

## ⚠️ 주의 사항
- 모든 파일은 **BOM 없는 UTF-8**로 저장되어야 합니다.
- 수정 후 AJAX 모달이 작동하지 않으면 `BOM` 오염을 의심하십시오.