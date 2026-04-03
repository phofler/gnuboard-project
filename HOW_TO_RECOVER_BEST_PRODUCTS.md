# Best Products 섹션 모듈화 복구 가이드 (HOW_TO_RECOVER_BEST_PRODUCTS.md)

## 🚨 위급 상황 발생 시 (1초 복구 루틴)
작업 중 메인 페이지의 상품 섹션이 사라지거나 레이아웃이 깨지면 즉시 수행하십시오.

### 1단계: 물리 파일 복구
백업 폴더(`C:\gnuboard\_backups/yyyyMMdd_HHmm_Modularize_Best_Products/`)에서 파일을 복구합니다.

```powershell
# index.php 복구
Copy-Item "C:\gnuboard\_backups\yyyyMMdd_HHmm_Modularize_Best_Products\index.php" "C:\gnuboard\theme\kukdong_panel\index.php" -Force

# kukdong_best 스킨 복구
Copy-Item "C:\gnuboard\_backups\yyyyMMdd_HHmm_Modularize_Best_Products\kukdong_best.skin.php" "C:\gnuboard\theme\kukdong_panel\skin\latest\kukdong_best\latest.skin.php" -Force
```

### 2단계: 브라우저 캐시 삭제
`Ctrl + F5`를 눌러 새로고침하십시오.

---

## 🛠 수정된 내용
1. **index.php**: 하드코딩된 `<section class="main-items">` 블록을 제거하고 `latest_widget()` 호출로 변경.
2. **kukdong_best/latest.skin.php**: `skin.head.php`를 연동하여 타이틀 영역을 자동화함.

## 📌 위젯 설정 안내
- 만약 화면에 아무것도 나오지 않는다면, 관리자 페이지 [보드 최근글 스킨 관리]에서 위젯 ID에 해당하는 게시판과 스킨(`kukdong_best`)이 제대로 매칭되어 있는지 확인하십시오.