# GnuBoard Project: 작업 지침 및 동기화 가이드 (C: 직접 Git 연동판)

이 문서는 `C:\gnuboard`를 직접 Git 저장소로 사용하는 환경에서의 작업 및 동기화 지침을 담고 있습니다.

## 🚨 0. 절대 수칙 (Golden Rules) - 필수 준수

### [Rule 0] 작업 전 백업 필수
- 모든 수정 작업 전, 반드시 `C:\gnuboard\_backups/` 폴더 내에 원본 파일을 복사하십시오.

### [Rule 7] 고스트 저장 및 인코딩 방지
- **파일 저장**: 반드시 PowerShell 스크립트를 통해 저장하며, **BOM 없는 UTF-8 ($false)** 형식을 사용합니다.
- **검증**: 수정 후에는 반드시 에디터나 브라우저를 통해 실제 디스크 기록 여부를 확인하십시오.

---

## 1. 사무실/집 작업 동기화 (Git & DB Sync)

### [A. 작업 마무리 및 업로드]
이제 `C:\gnuboard`에서 직접 Push할 수 있습니다.
1. **DB 백업**:
   ```powershell
   # 파워쉘 원라인 명령어 (복사해서 붙여넣으세요)
   $d = get-date -f yyyyMMdd; $f = "backup/gnuboard5_backup_$d.sql"; $i = 1; while (Test-Path $f) { $f = "backup/gnuboard5_backup_${d}_$i.sql"; $i++ }; mysqldump -u root --default-character-set=utf8mb4 --hex-blob --skip-extended-insert --result-file="$f" gnuboard5
   ```
2. **Git Commit & Push**:
   ```powershell
   git add .
   git commit -m "작업 내용 요약"
   git push origin main
   ```

### [B. 집/사무실에서 작업 시작]
1. **최신 소스 가져오기**: `git pull origin main`
2. **DB 복구**:
   ```powershell
   # 윈도우 type 명령어로 인코딩 오류 방지
   cmd /c "type backup\gnuboard5_backup_{날짜}.sql | mysql -u root --default-character-set=utf8mb4 gnuboard5"
   ```

---

## 2. 프로젝트 관리 원칙

- **작업 경로**: `C:\gnuboard` (Git 연동 완료)
- **DB 명칭**: `gnuboard5`
- **모듈화**: 반복되는 UI는 `lib.php` 또는 `include`를 활용하십시오.
- **자산 관리**: 외부 CDN 사용 절대 금지. 모든 라이브러리는 `assets/` 또는 테마 폴더에 물리적으로 저장하십시오.

---
**"환경이 최적화되었습니다. 이제 C 드라이브에서 즉시 배포하고 동기화하십시오."**