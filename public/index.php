<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Router\Router;

// Router
$router = new Router();
[$resource, $action, $id] = $router->dispatch($_SERVER['REQUEST_URI']);

// Controller neve
$controllerName = "App\\Controllers\\" . ucfirst($resource) . "Controller";

// 1) Controller létezik?
if (!class_exists($controllerName)) {
    http_response_code(404);
    echo "<h1>404 – A(z) {$controllerName} nem található</h1>";
    exit;
}

// 2) Controller példányosítása
$controller = new $controllerName();

// 3) Metódus létezik?
if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo "<h1>404 – A(z) {$controllerName}::{$action}() metódus nem található</h1>";
    exit;
}

// 4) Metódus meghívása
echo $controller->$action($id);
