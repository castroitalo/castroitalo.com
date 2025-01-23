<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

if (is_null($databaseConnection)) {
    http_response_code(500);
    header('Content-type: application/json');
    echo json_encode([
        'message' => 'banco de dados nao conectou'
    ]);
}
