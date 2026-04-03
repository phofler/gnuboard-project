# HOW_TO_LIB_HEADER_CENTERING.md

이 문서는 헤더 로고 중앙 정렬 라이브러리 사양서입니다.

## 1. 구현 원칙
모바일에서 시각적 균형을 위해 Flexbox의 단순 정렬 대신 Absolute Positioning을 병행합니다.

### CSS 핵심 로직
- header_container: position: relative (기준점)
- logo: position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%)
- tnAllmenu & ightBtn: 양측 사이드 배치

## 2. 사용 시 주의사항
- 로고 이미지가 너무 가로로 길 경우 메뉴 버튼과 겹칠 수 있으므로 모바일용 로고(m_logo.png)는 가급적 가로 폭을 제한하십시오.
- 헤더 높이가 변동될 경우 	op: 50%가 어색해질 수 있으니 헤더 min-height와 동기화가 필요합니다.