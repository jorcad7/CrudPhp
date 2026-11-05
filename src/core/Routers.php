<?php
declare(strict_types=1);
 
namespace App\Core;
 
final class Router
{
    /** @var array<int, array{0: string, 1: string, 2: callable}> */
    private array $routes = [];
 
    public function add(string $method, string $pattern, callable $handler): void
    {
        $regex = '#^' . preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $pattern) . '$#';
        $this->routes[] = [$method, $regex, $handler];
    }
 
    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $path = $path === '/' ? '/' : rtrim($path, '/');
 
        foreach ($this->routes as [$routeMethod, $regex, $handler]) {
            if ($routeMethod === $method && preg_match($regex, $path, $matches)) {
                // Solo los grupos con nombre: se pasan como argumentos con nombre al handler
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $handler(...$params);
                return;
            }
        }
 
        Http::notFound();
    }
}