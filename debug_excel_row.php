<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

$file = 'storage/app/private/livewire-tmp/7IRkNBRnOr5LlPWxBsqnrCqHqiwKnS-metadGVtcGxhdGVfYmFua19zb2FsICgyKS54bHN4-.xlsx';

if (!file_exists($file)) {
    echo "File not found\n";
    exit;
}

$import = new class implements ToCollection, WithHeadingRow {
    public function collection(Collection $collection) {
        if ($collection->isNotEmpty()) {
            echo "Heading Row Normalization Keys:\n";
            print_r(array_keys($collection->first()->toArray()));
            echo "\nFirst 10 rows:\n";
            $count = 0;
            foreach ($collection as $row) {
                $count++;
                if ($count > 10) break;
                echo "Row " . ($count + 1) . ":\n";
                print_r($row->toArray());
            }
        }
    }
};

Excel::import(
    new class($import) implements \Maatwebsite\Excel\Concerns\WithMultipleSheets {
        public function __construct(protected $import) {}
        public function sheets(): array {
            return [
                'Esai' => $this->import
            ];
        }
    },
    $file
);
