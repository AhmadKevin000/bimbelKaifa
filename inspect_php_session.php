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

// Let's print all recent sessions with their keys
foreach (array_slice($files, 0, 5) as $file) {
    $content = file_get_contents($file);
    try {
        // Laravel encrypts session if configured, but SESSION_ENCRYPT=false.
        // Also Laravel file session starts with a payload that is serialized.
        $sessionData = unserialize($content);
        if (is_array($sessionData)) {
            echo "Session File: " . basename($file) . " | mtime: " . date('Y-m-d H:i:s', filemtime($file)) . "\n";
            foreach ($sessionData as $key => $val) {
                if (str_contains($key, 'import_bank_soal')) {
                    echo "  Key: $key | Type: " . gettype($val) . " | Count: " . (is_array($val) ? count($val) : 'N/A') . "\n";
                    if (is_array($val)) {
                        // Print first 2 rows
                        foreach (array_slice($val, 0, 2) as $row) {
                            echo "    Row: " . json_encode($row) . "\n";
                        }
                    }
                } else {
                    echo "  Key: $key\n";
                }
            }
        }
    } catch (\Exception $e) {
        echo "Failed to unserialize " . basename($file) . ": " . $e->getMessage() . "\n";
    }
}
