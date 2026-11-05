<?php
declare(strict_types=1);
 
namespace App\Core;
 
final class Flash
{
    public static function set(string $type, string $message): void
    {
        $_SESSION['_flash'] = [$type => $message];
    }
 
    /** @return array<string, string> */
    public static function pull(): array
    {
        $flash = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']);
 
        return $flash;
    }
}
 