<?php
declare(strict_types=1);
 
namespace App\Core;
 
final class View
{
    /**
     * Renderiza src/Views/<vista>.php dentro de src/Views/layout.php.
     * Las claves de $data quedan disponibles como variables en la vista.
     */
    public static function render(string $view, array $data = []): void
    {
        $base = dirname(__DIR__) . '/Views/';
 
        extract($data, EXTR_SKIP);
 
        ob_start();
        require $base . $view . '.php';
        $content = ob_get_clean();
 
        require $base . 'layout.php';
    }
}