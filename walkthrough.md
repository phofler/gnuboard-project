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
