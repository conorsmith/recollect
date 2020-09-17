<?php
declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

(Dotenv\Dotenv::createImmutable(__DIR__ . "/../"))->load();

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$dispatcher = \FastRoute\simpleDispatcher(require __DIR__ . "/../src/Infrastructure/Routes.php");

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo "Page Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        http_response_code(405);
        echo "Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $routeParameters = $routeInfo[2];
        $controller = (new \ConorSmith\Recollect\Infrastructure\Controllers\ControllerFactory)->create($handler);
        $response = $controller($request, $routeParameters);
        $response->send();
        break;
}
