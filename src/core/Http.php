<?php
declare(strict_types=1);
 
namespace App\Core;
 
final class Http
{
    public static function redirect(string $to): never
    {
        header('Location: ' . $to, true, 303);
        exit;
    }
 
    public static function notFound(): never
    {
        http_response_code(404);
        View::render('errors/404', ['title' => 'No encontrado']);
        exit;
    }
}