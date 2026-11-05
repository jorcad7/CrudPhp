<?php
declare(strict_types=1);
 
namespace App\Core;
 
use PDO;
use RuntimeException;
 
final class CreateDatabase
{
    public static function create(): void
    {
        $host = Env::get('DB_HOST', 'localhost');
        $port = Env::get('DB_PORT', '5432');
        $dbname = Env::get('DB_NAME', 'micrud_db');
        $user = Env::get('DB_USER', 'postgres');
        $password = Env::get('DB_PASSWORD', '');
 
        // Conectar a la base de mantenimiento, no a micrud_db.
        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=postgres',
            $host,
            $port
        );
 
        $pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
 
        // Comprobar si la base de datos ya existe.
        $stmt = $pdo->prepare(
            'SELECT 1
             FROM pg_database
             WHERE datname = :dbname'
        );
 
        $stmt->execute(['dbname' => $dbname]);
 
        if ($stmt->fetchColumn()) {
            return;
        }
 
        // Los nombres de bases de datos no se pueden pasar como
        // parámetros preparados. Validamos y escapamos el identificador.
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $dbname)) {
            throw new RuntimeException(
                'Nombre de base de datos no válido.'
            );
        }
 
        $pdo->exec(
            'CREATE DATABASE "' . $dbname . '"'
        );
    }
}