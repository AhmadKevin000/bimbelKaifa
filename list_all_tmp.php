<?php
$dir = 'storage/app/private/livewire-tmp';
$files = glob("$dir/*");
echo "Recent files in livewire-tmp (last 5 mins):\n";
foreach ($files as $file) {
    if (filemtime($file) > time() - 300) {
        echo basename($file) . " | size: " . filesize($file) . " | mtime: " . date('Y-m-d H:i:s', filemtime($file)) . "\n";
    }
}
