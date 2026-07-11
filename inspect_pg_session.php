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
echo "Recent File: $file\n";
$content = file_get_contents($file);
$decoded = json_decode($content, true);

if (is_array($decoded) && isset($decoded['import_bank_soal_pg'])) {
    $pg = $decoded['import_bank_soal_pg'];
    echo "Total PG rows: " . count($pg) . "\n";
    foreach ($pg as $row) {
        if (!empty($row['gambar_soal'])) {
            echo "  Row " . $row['row_num'] . ": pert='" . substr($row['pertanyaan'], 0, 40) . "', gambar_soal='" . $row['gambar_soal'] . "'\n";
        }
        foreach ($row['opsi'] as $label => $opsi) {
            if (!empty($opsi['gambar_path'])) {
                echo "    Opsi $label: gambar_nama='" . $opsi['gambar_nama'] . "', path='" . $opsi['gambar_path'] . "'\n";
            }
        }
    }
} else {
    echo "No import_bank_soal_pg in session\n";
}
