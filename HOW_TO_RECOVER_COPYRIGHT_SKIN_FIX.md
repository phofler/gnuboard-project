# 카피라이트 스킨 초기화 및 치환자 동기화 복구 가이드 (HOW_TO_RECOVER_COPYRIGHT_SKIN_FIX.md)

## 🚨 위급 상황 발생 시 (1초 복구 루틴)
스킨 선택 시 에디터가 멈추거나 내용이 이상하게 바뀌면 즉시 수행하십시오.

### 1단계: 물리 파일 복구
백업 폴더(`C:\gnuboard\_backups/20260316_1345_Copyright_Skin_Fix/`)에서 파일을 복구합니다.

```powershell
$backupDir = "C:\gnuboard\_backups\20260316_1345_Copyright_Skin_Fix"
# write.php 복구
Copy-Item "$backupDir\write.php" "C:\gnuboard\plugin\copyright_manager\adm\write.php" -Force
# 템플릿 전수 복구
Copy-Item "$backupDir\style_a\template.html" "C:\gnuboard\plugin\copyright_manager\skins\style_a\template.html" -Force
# (다른 스타일도 동일)
```

---

## 🛠 수정된 내용
1.  **write.php**: `load_template()` JS 함수에 신규 6종 치환자 동기화 로직 추가.
2.  **template.html (A~D)**: 기본 템플릿에 기업 정보(상호/대표자/사업자번호) 레이아웃 삽입.
3.  **BOM 차단**: Rule 2에 따라 BOM 없는 UTF-8 형식을 엄격히 준수함.