# HOW TO RECOVER - Responsive Layout Implementation

If the responsive layout breaks the design or causes encoding issues, follow these steps to restore the site.

## 1. Instant Restoration (PowerShell)
Run this command in the project root (`f:\gnuboard\main\판넬\2`) to restore files from the latest backup:

```powershell
$backupDir = "f:\gnuboard\main\판넬\2\_backups\20260309_1357_ResponsiveLayout"
Copy-Item "$backupDir\index.html" -Destination ".\index.html" -Force
Copy-Item "$backupDir\style.css" -Destination ".\style.css" -Force
```

## 2. Key Changes Made
- **CSS**: Changed `.container` and `.dep2Wrap2` from `width: 1200px` to `max-width: 1200px; width: 100%; padding: 0 20px;`.
- **CSS**: Adjusted `.dep2Wrap` centering logic to use percentage-based offsets or simplified alignment.
- **CSS**: Added initial media queries for tablet and mobile view.
- **HTML**: Ensured viewport meta tag is present.

## 3. Adherence Checklist
- **Encoding**: Must be **BOM-free UTF-8**.
- **Ghost Save**: Always use the PowerShell `WriteAllText` script method.
- **Responsive**: No horizontal scrollbars on smaller screens.
