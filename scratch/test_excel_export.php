<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Exports\StallSalesReport;
use App\Models\Stall;
use Maatwebsite\Excel\Facades\Excel;

echo "=== TESTING EXCEL EXPORT ===\n";

$stall = Stall::first();
if (!$stall) {
    echo "Error: No stall found in the database.\n";
    exit(1);
}

echo "Found Stall: {$stall->name} (ID: {$stall->stall_id})\n";

try {
    $export = new StallSalesReport($stall->stall_id, $stall->name, '7d');
    $data = $export->array();
    
    echo "Excel Array Data:\n";
    print_r($data);
    
    // Test writing to a temporary file in the scratch directory
    $tempFile = __DIR__ . '/temp_test_report.xlsx';
    if (file_exists($tempFile)) {
        unlink($tempFile);
    }
    
    Excel::store($export, 'scratch/temp_test_report.xlsx', 'local');
    
    $fullPath = storage_path('app/scratch/temp_test_report.xlsx');
    echo "Excel file successfully stored to: {$fullPath}\n";
    
    if (file_exists($fullPath)) {
        echo "File size: " . filesize($fullPath) . " bytes\n";
        unlink($fullPath);
    } else {
        // Let's also try local storage relative path
        $relativePath = __DIR__ . '/temp_test_report.xlsx';
        Excel::store($export, '../scratch/temp_test_report.xlsx', 'local');
        echo "Stored locally via relative path\n";
    }
    
    echo "SUCCESS\n";
} catch (\Exception $e) {
    echo "EXCEPTION THROWN: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
