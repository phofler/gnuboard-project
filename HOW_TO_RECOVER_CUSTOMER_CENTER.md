# 고객센터 섹션 고도화 복구 가이드 (HOW_TO_RECOVER_CUSTOMER_CENTER.md)

## 🚨 위급 상황 발생 시 (1초 복구 루틴)
작업 중 메인 페이지 레이아웃이 깨지거나, PHP 에러가 발생하면 다음 단계를 즉시 수행하십시오.

### 1단계: 물리 파일 복구
가장 최근의 백업 폴더(`C:\gnuboard\_backups/yyyyMMdd_HHmm_Customer_Center_Upgrade/`)에서 파일을 복사하여 원본 위치에 덮어씌웁니다.

```powershell
# index.php 복구
Copy-Item "C:\gnuboard\_backups\yyyyMMdd_HHmm_Customer_Center_Upgrade\index.php" "C:\gnuboard\theme\kukdong_panel\index.php" -Force

# style.css 복구
Copy-Item "C:\gnuboard\_backups\yyyyMMdd_HHmm_Customer_Center_Upgrade\style.css" "C:\gnuboard\theme\kukdong_panel\style.css" -Force
```

### 2단계: 브라우저 캐시 삭제
디자인이 꼬여 보일 경우 `Ctrl + F5`를 눌러 강력 새로고침을 수행하십시오.

---

## 🛠 수정된 내용 (Checklist)
1. **theme/kukdong_panel/index.php**: 
   - 고객센터 블록의 텍스트를 상세 운영 시간으로 업데이트.
   - FontAwesome 아이콘 추가.
2. **theme/kukdong_panel/style.css**: 
   - 고객센터 전용 스타일(`.customer-center-box`) 추가.
   - 아이콘 및 텍스트 레이아웃 정렬 스타일 정의.

## ⚠️ 주의 사항
- 모든 파일은 **BOM 없는 UTF-8**로 저장되어야 합니다.
- 파일 수정 시 반드시 PowerShell 스크립트 방식($false 사용)을 유지하십시오.