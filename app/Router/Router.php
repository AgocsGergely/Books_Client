<?php

namespace App\Router;

class Router
{
    public function dispatch(string $uri): array
    {
        // Csak az útvonal részt vesszük (query string nélkül)
        $path = trim(parse_url($uri, PHP_URL_PATH), "/");

        // Részekre bontjuk az URL-t
        $parts = explode("/", $path);

        // Alapértelmezések
        $resource = $parts[0] ?: "books";   // pl. / → counties
        $action   = $parts[1] ?? "index";      // pl. /counties → index
        $id       = $parts[2] ?? null;         // pl. /counties/edit/5 → 5

        return [$resource, $action, $id];
    }
}