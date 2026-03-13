# HOW TO RECOVER - Slider Button Fine-tuning

## 1. Instant Restoration (PowerShell)
Run this command in the project root (`f:\gnuboard\main\판넬\2`) to restore files from the latest backup:

```powershell
$backupDir = "f:\gnuboard\main\판넬\2\_backups\20260309_1417_SliderBtnFix"
Copy-Item "$backupDir\index.html" -Destination ".\index.html" -Force
Copy-Item "$backupDir\style.css" -Destination ".\style.css" -Force
```

## 2. Key Changes
- **HTML**: Changed slider button text to "제품보기".
- **CSS**: Added hover effect using `--edge-color` (#c92127) for the slider button.
