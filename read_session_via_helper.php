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

foreach (array_slice($files, 0, 5) as $file) {
    $id = basename($file);
    echo "Session ID: $id\n";
    
    // Boot session using Laravel Session manager
    $session = app('session')->driver();
    $session->setId($id);
    $session->start();
    
    $allData = $session->all();
    foreach ($allData as $k => $v) {
        if (str_contains($k, 'import_bank_soal')) {
            echo "  Key: $k | Count: " . (is_array($v) ? count($v) : 'N/A') . "\n";
            if (is_array($v)) {
                foreach ($v as $row) {
                    if (!empty($row['gambar_soal']) || $row['row_num'] == 7) {
                        echo "    Row " . $row['row_num'] . ": pert='" . substr($row['pertanyaan'], 0, 60) . "', gambar_soal='" . ($row['gambar_soal'] ?? 'NULL') . "', status='" . $row['status'] . "'\n";
                        if (!empty($row['errors'])) {
                            echo "      Errors: " . implode(', ', $row['errors']) . "\n";
                        }
                    }
                }
            }
        } else {
            echo "  Key: $k\n";
        }
    }
    echo "--------------------------------------------------\n";
}
