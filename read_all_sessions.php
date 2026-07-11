<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Session;

$dir = storage_path('framework/sessions');
$files = glob("$dir/*");
if (empty($files)) {
    echo "No session files found\n";
    exit;
}

usort($files, function($a, $b) {
    return filemtime($b) - filemtime($a);
});

echo "Total session files: " . count($files) . "\n\n";

$sessionManager = app('session');

foreach (array_slice($files, 0, 10) as $file) {
    $id = basename($file);
    // Read session using the session handler
    try {
        $handler = $sessionManager->getHandler();
        $rawData = $handler->read($id);
        if ($rawData) {
            $data = unserialize($rawData);
            if (is_array($data)) {
                $hasImport = false;
                foreach ($data as $k => $v) {
                    if (str_contains($k, 'import_bank_soal')) {
                        $hasImport = true;
                        break;
                    }
                }
                if ($hasImport) {
                    echo "Session ID: $id | mtime: " . date('Y-m-d H:i:s', filemtime($file)) . "\n";
                    foreach ($data as $k => $v) {
                        if (str_contains($k, 'import_bank_soal')) {
                            echo "  Key: $k | Count: " . (is_array($v) ? count($v) : 'N/A') . "\n";
                            if (is_array($v)) {
                                foreach (array_slice($v, 0, 3) as $row) {
                                    echo "    Row " . $row['row_num'] . ": pert='" . substr($row['pertanyaan'], 0, 60) . "', gambar_soal='" . ($row['gambar_soal'] ?? 'NULL') . "'\n";
                                }
                            }
                        } else {
                            echo "  Key: $k\n";
                        }
                    }
                    echo "--------------------------------------------------\n";
                }
            }
        }
    } catch (\Exception $e) {
        echo "Error reading session $id: " . $e->getMessage() . "\n";
    }
}
