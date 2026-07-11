<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$dir = storage_path('framework/sessions');
$files = glob("$dir/*");
if (empty($files)) {
    echo "No session files found\n";
    exit;
}
usort($files, function($a, $b) {
    return filemtime($b) - filemtime($a);
});

$file = $files[0];
echo "Recent File: $file (size: " . filesize($file) . " bytes)\n";
$content = file_get_contents($file);

$decoded = json_decode($content, true);

if (is_array($decoded)) {
    echo "Keys: " . implode(', ', array_keys($decoded)) . "\n";
    if (isset($decoded['import_bank_soal_esai'])) {
        $esai = $decoded['import_bank_soal_esai'];
        echo "Total Esai rows: " . count($esai) . "\n";
        foreach ($esai as $row) {
            if (!empty($row['gambar_soal'])) {
                echo "  Row " . $row['row_num'] . ": pert='" . substr($row['pertanyaan'], 0, 40) . "', gambar_soal='" . $row['gambar_soal'] . "'\n";
            }
        }
    } else {
        echo "import_bank_soal_esai key not found in this session.\n";
    }
} else {
    echo "Could not decode JSON content.\n";
}
