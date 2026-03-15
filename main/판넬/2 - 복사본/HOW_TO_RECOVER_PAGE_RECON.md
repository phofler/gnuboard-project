# HOW TO RECOVER - Page Reconstruction Implementation

If the new page content layout breaks or animations cause performance issues, follow these steps to restore the site.

## 1. Instant Restoration (PowerShell)
Run this command in the project root (`f:\gnuboard\main\판넬\2`) to restore files from the latest backup:

```powershell
$backupDir = "f:\gnuboard\main\판넬\2\_backups\20260309_1411_PageRecon"
Copy-Item "$backupDir\index.html" -Destination ".\index.html" -Force
Copy-Item "$backupDir\style.css" -Destination ".\style.css" -Force
```

## 2. Key Changes Made
- **HTML**: Reconstructed the main body into 5 stages:
    1. Product Intro (Slide animations)
    2. Key Products Grid
    3. Factory View (Large image)
    4. Bottom Links (Support/Inquiry/Notice)
    5. Footer (Updated copy)
- **CSS**: Added animation classes (`.reveal`, `.active`, `.slide-left`, `.slide-right`) and reconstructed section styles.
- **JS**: Added `IntersectionObserver` to trigger scroll animations.

## 3. Adherence Checklist
- **Encoding**: Must be **BOM-free UTF-8**.
- **Ghost Save**: Always use the PowerShell `WriteAllText` script method.
- **Design**: Slide animations must trigger smoothly on scroll.
