<?php

require __DIR__ . '/../bootstrap.php';

$importService = new Services\ImportService($entityManager);
$importService->import(__DIR__ . '/../categories.json');