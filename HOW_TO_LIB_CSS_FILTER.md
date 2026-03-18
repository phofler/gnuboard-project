# HOW_TO_LIB_CSS_FILTER.md

이 문서는 제품 소개 섹션에 적용된 이미지 시각적 보정(CSS Filter) 기술 사양서입니다.

## 1. 개요
고해상도 원본 이미지를 더 돋보이게 하기 위해 브라우저 엔진의 필터 기능을 활용하여 시각적 선명도와 가독성을 개선했습니다.

## 2. 구현 상세 (`skins/product_intro/style.css`)

### 1) 기술적 선명화 (`image-rendering`)
- `image-rendering: -webkit-optimize-contrast;`
- 브라우저가 이미지의 경계선을 뭉개지 않고 대비를 강조하여 그리도록 지시합니다. 특히 로고나 텍스트가 포함된 이미지에서 효과가 큽니다.

### 2) 시각적 밸런스 (`filter`)
- `contrast(1.1)`: 대비를 10% 높여 선과 면의 구분을 뚜렷하게 합니다.
- `brightness(1.03)`: 밝기를 3% 높여 칙칙해 보일 수 있는 그림자 영역의 디테일을 살립니다.

### 3) 사용자 경험 (`transition` & `hover`)
- `transition: filter 0.3s ease`: 필터 변화 시 부드러운 전환 효과를 줍니다.
- `:hover { filter: contrast(1.15) brightness(1.05); }`: 마우스를 올렸을 때 이미지가 더 생생하게 살아나는 피드백을 제공합니다.

## 3. 유지보수
- 만약 이미지가 너무 인위적으로 보인다면 `contrast` 값을 1.1에서 1.05로 낮추어 조절할 수 있습니다.
- 모든 최신 브라우저(Chrome, Edge, Safari, Firefox)에서 호환되는 표준 속성입니다.
