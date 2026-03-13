# GnuBoard Project: 사무실/집 작업 동기화 및 절대 지침서

이 가이드는 집과 사무실을 오가며 작업할 때 발생할 수 있는 데이터 손실을 방지하고, AI 에이전트와 완벽하게 협업하기 위한 **절대 수칙**을 담고 있습니다.

## 🚨 0. 절대 수칙 (The Golden Rules)

### [Rule 0] 작업 전 백업 필수
- 모든 수정 작업 전, 반드시 `C:\gnuboard\_backups/` 폴더 내에 `[날짜_시간_기능명]` 폴더를 생성하고 원본 파일을 복사하십시오.

### [Rule 7] 고스트 저장(Ghost Save) 및 인코딩 방지
- **파일 저장**: 반드시 PowerShell 스크립트를 통해 저장하며, **BOM 없는 UTF-8 ($false)** 형식을 사용합니다.
- **검증**: AI가 수정한 후에는 반드시 에디터나 브라우저(F5)를 통해 실제 디스크 기록 여부를 확인하십시오.

---

## 1. 사무실/집 작업 동기화 (Sync Guide)

### [A. 집에서 작업 마무리]
1. **DB 백업 (반드시 backup/ 폴더에 저장)**:
   - **원칙**: 백업 전 반드시 `_backups/` 폴더에 원본 파일 백업(Rule 0)을 병행하십시오.
   - **파워쉘 원라인 명령어** (복사해서 붙여넣으세요):
   ```powershell
   # [주의] DB_NAME을 반드시 확인하세요. (현재: gnuboard5)
   $d = get-date -f yyyyMMdd; $f = "backup/gnuboard5_backup_$d.sql"; $i = 1; while (Test-Path $f) { $f = "backup/gnuboard5_backup_${d}_$i.sql"; $i++ }; mysqldump -u root --default-character-set=utf8mb4 --hex-blob --skip-extended-insert --result-file="$f" gnuboard5
   ```
   - **검증**: 백업 후 파일 용량이 수 KB라면 빈 DB일 수 있으니 주의하십시오. (정상은 보통 수 MB 이상)

2. **Git Push**: `git add .`, `git commit -m "작업 완료 및 안전한 DB 백업"`, `git push origin main`

### [B. 사무실/집에서 작업 시작]
1. **최신 소스 가져오기**: `git pull origin main`
2. **DB 복구 (가장 중요)**: 
   ```powershell
   # 윈도우 type 명령어와 파이프(|)를 사용하여 인코딩 오류 방지
   cmd /c "type backup\gnuboard5_backup_{날짜}.sql | mysql -u root --default-character-set=utf8mb4 gnuboard5"
   ```

---

## 2. 프로젝트 주요 환경 설정

- **설치 경로**: `C:\gnuboard` (절대 경로 준수)
- **접속 주소**: `http://localhost/gnuboard`
- **DB 정보**: `DB_NAME = gnuboard5` / `root` (비번 없음)
- **테마 경로**: `C:\gnuboard\theme\kukdong_panel`
- **플러그인**: `top_menu_manager`, `pro_menu_manager`

---

## 3. 코딩 및 개발 원칙

### [A. DRY 및 모듈화]
- 반복되는 UI는 반드시 `include` 또는 전역 함수(`lib.php`)로 모듈화합니다.
- 상단 메뉴 설정 UI는 `get_top_menu_setting_ui()` 함수를 사용하십시오.

### [B. 자산(Asset) 로컬 관리]
- **외부 CDN(jsdelivr 등) 사용 절대 금지**.
- 모든 라이브러리는 다운로드하여 `assets/` 또는 테마 내 폴더에 저장 후 로컬 경로로 연결하십시오.

---

## 4. AI 협업 프로토콜

1. **계회 우선**: 모든 작업 전 `implementation_plan.md` 승인 필수.
2. **명시적 승인**: 사용자(@보스)의 "승인" 또는 "진행해" 답변 전까지 대기.
3. **복구 대책**: 중요 작업 시 `HOW_TO_RECOVER_기능명.md` 생성.

---

**"완벽한 마무리는 꼼꼼한 지침 준수에서 시작됩니다."**