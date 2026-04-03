# 프론트엔드 카피라이트 출력 전환 복구 가이드 (HOW_TO_RECOVER_FRONT_COPYRIGHT.md)

## 🚨 위급 상황 발생 시 (1초 복구 루틴)
작업 중 푸터 레이아웃이 사라지거나 에러가 발생하면 즉시 수행하십시오.

### 1단계: 물리 파일 복구
백업 폴더(`C:\gnuboard\_backups/yyyyMMdd_HHmm_Copyright_Front_Transition/`)에서 파일을 복구합니다.

```powershell
# tail.php 복구
Copy-Item "C:\gnuboard\_backups\yyyyMMdd_HHmm_Copyright_Front_Transition\tail.php" "C:\gnuboard\theme\kukdong_panel\tail.php" -Force
```

### 2단계: 브라우저 캐시 삭제
`Ctrl + F5`를 눌러 새로고침하십시오.

---

## 🛠 수정된 내용
1. **tail.php**: 하드코딩된 `<footer>` 섹션을 제거하고 `copyright_widget()` 동적 호출로 변경.
2. **라이브러리 보호**: 플러그인이 비활성화된 경우를 대비해 `function_exists` 체크 로직 포함.

## 📌 주의사항
- 만약 하단 정보가 나오지 않는다면, 관리자 페이지 [카피라이트 관리]에서 테마 ID(`kukdong_panel`)와 일치하는 데이터가 있는지, 그리고 '사용안함'으로 설정되어 있지는 않은지 확인하십시오.