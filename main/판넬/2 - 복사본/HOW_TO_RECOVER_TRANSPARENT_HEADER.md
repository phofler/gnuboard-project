# HOW TO RECOVER - Transparent Header Implementation

If the header layout is broken or character encoding issues occur, follow these steps to restore the site.

## 1. Instant Restoration (PowerShell)
Run this command in the project root (`f:\gnuboard\main\판넬\2`) to restore files from the latest backup:

```powershell
$backupDir = "f:\gnuboard\main\판넬\2\_backups\20260309_1336_TransparentHeader"
Copy-Item "$backupDir\index.html" -Destination ".\index.html" -Force
Copy-Item "$backupDir\style.css" -Destination ".\style.css" -Force
```

## 2. Key Changes Made
- **CSS**: Modified `.gnbWrapBg` to be `background: transparent` and `border: none` by default.
- **CSS**: Added transitions and states for `.header.active` and `header:hover` to switch to `background: #fff`.
- **CSS**: Adjusted logo (`filter`) and GNB text color to ensure visibility on both transparent (dark slider) and white (active) backgrounds.
- **HTML/JS**: Maintained scroll listener for `active` class.

## 3. Adherence Checklist
- **Encoding**: Must be **BOM-free UTF-8**.
- **Ghost Save**: Always use the PowerShell `WriteAllText` script method.
- **Design**: Header must be transparent at `scrollY == 0` and transition to white on hover or scroll.
