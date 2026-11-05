<?php
declare(strict_types=1);
 
namespace App\Core;
 
final class Csrf
{
    public static function token(): string
    {
        return $_SESSION['_csrf'] ??= bin2hex(random_bytes(32));
    }
 
    public static function field(): string
    {
        return '<input type="hidden" name="_csrf" value="' . e(self::token()) . '">';
    }
 
    /** Llamar al inicio de TODA acción que modifique datos (POST). */
    public static function verify(): void
    {
        $sent = $_POST['_csrf'] ?? '';
 
        if (!is_string($sent) || !hash_equals(self::token(), $sent)) {
            http_response_code(403);
            exit('Token CSRF inválido. Recarga la página e inténtalo de nuevo.');
        }
    }
}
 