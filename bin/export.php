<?php

require __DIR__ . '/../bootstrap.php';

use Services\ExportService;

if ($argc < 3) {
    echo "Usage: php export.php [type] [output_file]\n";
    echo "  type: a - format with URLs, b - simple format\n";
    exit(1);
}

$type = strtolower($argv[1]);
$outputFile = $argv[2];

$exportService = new ExportService($entityManager);

try {
    switch ($type) {
        case 'a':
            $exportService->exportByTypeA($outputFile);
            break;
        case 'b':
            $exportService->exportByTypeB($outputFile);
            break;
        default:
            throw new \InvalidArgumentException("Unknown export type: $type");
    }

    echo "Export completed: $outputFile\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}