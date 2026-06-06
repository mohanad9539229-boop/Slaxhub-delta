```php
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$folder = 'file/';
$latest_apk = [];

if (is_dir($folder)) {
    $files = scandir($folder);
    $apk_files = [];

    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'apk') {
            $filePath = $folder . $file;
            $apk_files[] = [
                'name' => $file,
                'size' => filesize($filePath),
                'last_modified' => date("M d, Y", filemtime($filePath)),
                'mtime' => filemtime($filePath)
            ];
        }
    }

    usort($apk_files, function($a, $b) {
        return $b['mtime'] - $a['mtime'];
    });

    if (!empty($apk_files)) {
        $latest_apk[] = $apk_files[0];
    }
}

echo json_encode(['latest_apk' => $latest_apk]);
?>

```
