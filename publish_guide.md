# 디자인 퍼블리싱 가이드 (Design & Publishing Guide)

## 1. 메인 비주얼 반응형 전략 (Main Visual Responsive Strategy)

화면 크기에 따라 최적의 사용자 경험을 제공하기 위해 **'하이브리드 높이 전략(Hybrid Height Strategy)'**을 사용합니다.
단순히 `100vh`만 사용하면 모바일에서 너무 길거나 짧아질 수 있고, `aspect-ratio`만 사용하면 PC에서 꽉 찬 느낌이 부족할 수 있기 때문입니다.

### 적용 규칙 (Rules)

| 화면 크기 (Device) | 기준 너비 (Width) | 적용 스타일 (CSS) | 설명 (Description) |
| --- | --- | --- | --- |
| **PC 매크로 (초대형)** | `1600px` 초과 | `height: 100vh;` | 모니터 화면을 가득 채워 웅장한 느낌을 줍니다. |
| **노트북/태블릿 (가로)** | `1024px` ~ `1600px` | `aspect-ratio: 16 / 9;`<br>`height: auto;` | 가로 폭이 줄어들면 비율에 맞춰 높이도 자연스럽게 줄어듭니다. (이미지 잘림 방지) |
| **모바일/태블릿 (세로)** | `1024px` 이하 | `height: 65vh;`<br>`min-height: 600px;` | 화면이 좁아도 이미지가 너무 납작해지지 않도록 최소 높이를 강제합니다. |

### 코드 예시 (Code Snippet)

```css
/* PC 기본: Full Screen */
.hero-section {
    height: 100vh !important;
    min-height: 800px;
}

/* 노트북/태블릿 가로: 비율 유지 (Aspect Ratio) */
@media (max-width: 1600px) {
    .hero-section {
        height: auto !important;
        aspect-ratio: 16 / 9;
    }
}

/* 모바일: 높이 강제 고정 (Fixed Height) */
@media (max-width: 1024px) {
    .hero-section {
        height: 65vh !important;
        min-height: 600px !important;
        aspect-ratio: auto !important; /* 비율 계산 끄기 */
        display: block !important;
    }
    
    /* 중요: 부모 높이를 자식 요소들이 상속받도록 강제 */
    .hero-section .swiper, 
    .hero-section .swiper-slide {
        height: 100% !important;
    }
}
```

## 2. 네비게이션 화살표 정렬 (Navigation Arrows)

반응형으로 높이가 수시로 변하는 컨테이너 안에서 화살표를 중앙에 유지하려면 `flex` 보다는 `absolute` + `transform` 조합이 가장 확실합니다.

```css
.swiper-button-next,
.swiper-button-prev {
    position: absolute;
    top: 50%;
    transform: translateY(-50%); /* 정확한 수직 중앙 정렬 */
    z-index: 10;
}
```
