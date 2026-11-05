<?php
 
require dirname(__DIR__) . '/src/bootstrap.php';
 
use App\Core\CreateDatabase;
 
try {
    CreateDatabase::create();
 
    echo 'Base de datos verificada correctamente.';
} catch (\Throwable $e) {
    http_response_code(500);
 
    echo 'Error al crear la base de datos: '
        . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
}
 