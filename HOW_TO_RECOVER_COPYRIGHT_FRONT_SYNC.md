# 프론트엔드 카피라이트 동기화 복구 가이드 (HOW_TO_RECOVER_COPYRIGHT_FRONT_SYNC.md)

## 🚨 위급 상황 발생 시 (1초 복구 루틴)
프론트엔드 레이아웃이 깨지거나 주소가 잘못 나오는 경우 즉시 수행하십시오.

### 1단계: 물리 파일 복구
백업 폴더(`C:\gnuboard\_backups/20260316_1312_Copyright_Front_Sync/`)에서 파일을 복구합니다.

```powershell
$backupDir = "C:\gnuboard\_backups\20260316_1312_Copyright_Front_Sync"
Copy-Item "$backupDir\lib.php" "C:\gnuboard\plugin\copyright_manager\lib.php" -Force
Copy-Item "$backupDir\footer.skin.php" "C:\gnuboard\plugin\copyright_manager\skins\style_a\footer.skin.php" -Force
# (다른 스킨들도 동일하게 복구 가능)
```

---

## 🛠 수정된 내용
1.  **치환자 확장**: 에디터용 `{company}`, `{ceo}`, `{bizno}` 등 6개 치환자 정식 지원.
2.  **데이터 무결성**: 관리자 페이지의 '남양주' 주소가 실시간으로 실사이트에 반영되도록 로직 동기화.
3.  **스킨 고도화**: Style A~D 전 수량 기업 정보 출력 레이아웃 반영.
4.  **BOM 차단**: 모든 파일은 BOM 없는 UTF-8로 저장되어 AJAX 오류를 방지함.