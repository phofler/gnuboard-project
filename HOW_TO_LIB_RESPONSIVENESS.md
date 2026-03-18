# HOW_TO_LIB_RESPONSIVENESS.md

이 문서는 반응형(Responsiveness) 구현 및 중앙 축소(Center-focused Scaling) 로직을 정리한 지침서입니다.

## 1. 구현 핵심 로직
- **뷰포트 통합**: head.sub.php에서 모든 환경에 뷰포트 태그를 전역 적용.
- **Center-focused Scaling (Hero Skins)**: 
  - ade 및 ultimate_hero 스킨에 공통 적용.
  - 메인 이미지( hero_bg img)에 object-position: center center와 	ransform-origin: center center를 적용.
  - 모바일(768px 이하) 미디어 쿼리에서 width: auto, min-width: 100%, height: 100% 설정을 통해 슬라이더 중앙을 기준으로 이미지가 자연스럽게 잘리도록(Crop) 처리.
- **Fluid Typography**: clamp() 함수로 화면 크기에 비례한 가독성 확보.
- **복합 브레이크포인트**: 1200px, 992px, 768px, 576px, 480px의 세밀한 대응.

## 2. 주요 파일 및 역할
- head.sub.php: 전역 뷰포트 설정
- plugin/main_image_manager/skins/fade/style.css: Fade 스킨 중앙 축소 및 반응형
- plugin/main_image_manager/skins/ultimate_hero/style.css: Ultimate Hero 중앙 축소 및 반응형
- plugin/main_content_manager/skins/product_intro/style.css: 메인 컨텐츠 리스트 반응형 스타일

## 3. 유지보수 가이드
- 메인 비주얼 이미지는 가급적 **중앙에 주요 피사체**가 위치한 이미지를 사용하는 것이 반응형 대응에 가장 유리합니다.
- 모바일에서 텍스트가 겹칠 경우 768px 이하 쿼리에서 clamp()의 첫 번째 인자(최소값)를 더 줄이십시오.