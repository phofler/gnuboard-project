# HOW TO RECOVER: Slider Ken Burns & Button Refinement

이 문서는 메인 슬라이더의 Ken Burns 효과 및 버튼 스타일 수정 중 문제가 발생했을 때 1초 만에 복구하기 위한 지침입니다.

## 1. 개요
- **작업 내용**: 텍스트 고정형 Ken Burns(배경 줌) 효과 적용 및 버튼 호버 색상 강화
- **수정 파일**: `index.html`, `style.css`
- **백업 위치**: `f:\gnuboard\_backups\20260309_1456_SliderKenBurns`

## 2. 복구 방법

### 방법 A: 전체 파일 복사 (가장 빠름)
백업 폴더에 있는 원본 파일을 프로젝트 루트로 덮어씌웁니다.
```powershell
$backupDir = "f:\gnuboard\_backups\20260309_1456_SliderKenBurns"
Copy-Item "$backupDir\index.html" -Destination ".\index.html" -Force
Copy-Item "$backupDir\style.css" -Destination ".\style.css" -Force
```

### 방법 B: 수동 코드 확인
- **HTML**: `.slide` 내부에 `.slide-bg`와 `.slide-content`가 분리되어 있는지 확인.
- **CSS**: `.slide.active`가 아닌 `.slide-bg`에 애니메이션(`animation: kenburns ...`)이 걸려있는지 확인.

## 3. 주의 사항 (Rule 7)
- 모든 수정은 반드시 **BOM 없는 UTF-8** 형식을 유지해야 합니다.
- `index.html`의 한글 인사가 깨졌다면, 위 백업 파일을 사용하여 PowerShell 스크립트로 재저장하십시오.