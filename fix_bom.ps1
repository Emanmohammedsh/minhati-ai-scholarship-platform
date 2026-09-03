# fix_bom.ps1
# يفحص كل ملفات .php بمجلد app/ (أو أي مسار تحدده) ويشيل الـ BOM إذا موجود

$targetPath = "app"  # عدّلي المسار إذا لازم
$files = Get-ChildItem -Path $targetPath -Filter *.php -Recurse

$bomBytes = [byte[]](0xEF,0xBB,0xBF)
$fixedCount = 0

foreach ($file in $files) {
    $bytes = [System.IO.File]::ReadAllBytes($file.FullName)

    if ($bytes.Length -ge 3 -and $bytes[0] -eq $bomBytes[0] -and $bytes[1] -eq $bomBytes[1] -and $bytes[2] -eq $bomBytes[2]) {
        # شيل أول 3 bytes (الـ BOM)
        $newBytes = $bytes[3..($bytes.Length - 1)]
        [System.IO.File]::WriteAllBytes($file.FullName, $newBytes)
        Write-Host "Fixed: $($file.FullName)" -ForegroundColor Green
        $fixedCount++
    }
}

Write-Host "`nDone. Fixed $fixedCount file(s)." -ForegroundColor Cyan