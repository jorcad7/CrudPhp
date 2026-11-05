<?php
declare(strict_types=1);
 
// Autoload mínimo (PSR-4): App\Foo\Bar  ->  src/Foo/Bar.php
spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
 
    if (!str_starts_with($class, $prefix)) {
        return;
    }
 
    $file = __DIR__ . '/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
 
    if (is_file($file)) {
        require $file;
    }
});
 
// Escapa texto para HTML. Úsalo en TODA salida a las vistas.
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
 
// Carga el .env de la carpeta del proyecto (fuera de public/, no se sirve por web)
\App\Core\Env::load(dirname(__DIR__) . '/.env');