# Webzine Skin Walkthrough

The **Webzine Skin** has been successfully implemented in `theme/corporate_light/skin/board/webzine`. It strictly follows the "Editorial Standard" defined in `theme_skin.md`.

## 1. Key Features implemented

### A. Alternating "Zigzag" List Layout
- **File**: `list.skin.php`
- **Logic**: Automatically checks if the post index is odd or even (`$i % 2`).
    - **Odd**: Image Left - Text Right
    - **Even**: Text Left - Image Right (`flex-direction: row-reverse`)
- **Typography**: Uses large serif fonts (`var(--font-header)`) for titles to enhance readability.

### B. Split View with Sticky Sidebar
- **File**: `view.skin.php`
- **Layout**: 
    - **Left (Main)**: Content, Title, Lead Text.
    - **Right (Sidebar)**: Meta information (Date, Author, Views, Share) stays fixed while scrolling (`position: sticky`).
- **Clean Structure**: Wrapped in `.skin-container` without unnecessary nested divs.

### C. Theme Sovereignty (Dark/Light Mode Support)
- **File**: `style.css`
- **Variables**: Uses `var(--color-bg-panel)`, `var(--color-text-primary)` etc.
- **Result**: Automatically adapts to Dark Mode without any additional CSS changes.

### D. Advanced UX Features
- **Type B Category**: Strategic Dropdown with `Parent > Child` logic and interaction.
- **View Anchor (`#bo_view`)**: Links maintain scroll position when navigating from list to view.
- **FAB (Floating Action Button)**: Fixed 'Write' button at bottom-right.
- **Clean Write Page**: Removed hardcoded headers for focus-mode writing.

## 2. How to Verify

### Step 1: Apply Skin
1. Go to **Admin > Board Management**.
2. Select a board (e.g., "News" or "Portfolio").
3. Change **Skin Directory** to `theme/webzine`.
4. (Optional) Use **Board Skin Manager** to set specific column/layout options if needed.

### Step 2: Input Test Data
1. Write 3-4 posts.
2. Ensure at least one post has **No Thumbnail** (to test the text-only fallback layout).
3. Ensure one post has a **Very Long Content** (to test Sticky Sidebar behavior).

### Step 3: Check Aesthetics
- **Desktop**: Verify Zigzag pattern.
- **Mobile**: Verify that Zigzag collapses into a single column (Stack).

## 3. Screenshots (Expected)
*(Placeholder for actual verification)*
- **List**: [Image] -> [Text] | [Text] <- [Image]
- **View**: [Content] | [Sticky Meta]

## [2026-03-16] 히어로 비주얼 서체(Typography) 표준화 완료
히어로 비주얼의 Tag, 메인 텍스트, 서브 텍스트의 색상과 크기를 테마 표준에 맞게 통합했습니다.

### 1. 주요 변경 사항
- **CSS 변수 통합**: plugin/sub_design/skins/typography.css를 생성하여 폰트 설정을 중앙 집중화했습니다.
- **테마 연동**: 테마의 --color-accent, --font-heading 변수를 직접 참조하여 사이트 전체와 일관성을 유지합니다.
- **반응형 최적화**: clamp() 함수를 사용하여 기기 크기에 따라 타이틀 크기가 부드럽게 조절됩니다.

### 2. 적용 결과
- **Tag**: 강조색(골드), 넓은 자간(0.3em), 1.1rem
- **Main**: 고대비 화이트, 굵게(800), 반응형 크기(2.5rem~5rem)
- **Sub**: 부드러운 화이트(0.85 opacity), 1.25rem
