<?php
declare(strict_types=1);

use RandomLib\Factory;

require_once __DIR__ . "/../vendor/autoload.php";

(Dotenv\Dotenv::createImmutable(__DIR__ . "/../"))->load();

/**
 * COMMON DEPENDENCIES
 */

$db = \Doctrine\DBAL\DriverManager::getConnection([
    'dbname'   => $_ENV['DB_NAME'],
    'user'     => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'host'     => $_ENV['DB_HOST'],
    'driver'   => "pdo_mysql",
]);

$gameRepo = new \ConorSmith\Recollect\Infrastructure\Repositories\GameRepositoryDb(
    $db,
    new \ConorSmith\Recollect\Infrastructure\Clock(),
    new \ConorSmith\Recollect\Domain\Deck()
);

$tableRepo = new \ConorSmith\Recollect\Infrastructure\Repositories\TableRepositoryDb(
    $db,
    new \ConorSmith\Recollect\Infrastructure\Clock()
);

/**
 * ROUTES
 */

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
if ($_SERVER['REQUEST_METHOD'] === "GET" && $_SERVER['REQUEST_URI'] === "/") {
    $controller = new \ConorSmith\Recollect\Infrastructure\Controllers\GetLandingPage();

} elseif ($_SERVER['REQUEST_METHOD'] === "POST" && $_SERVER['REQUEST_URI'] === "/open-table") {
    $controller = new \ConorSmith\Recollect\Infrastructure\Controllers\PostOpenTable(
        new \ConorSmith\Recollect\UseCases\OpenTable(
            $tableRepo,
            (new Factory)->getLowStrengthGenerator()
        )
    );

} elseif ($_SERVER['REQUEST_METHOD'] === "POST" && $_SERVER['REQUEST_URI'] === "/join-table") {
    $controller = new \ConorSmith\Recollect\Infrastructure\Controllers\PostJoinTable(
        new \ConorSmith\Recollect\UseCases\JoinTable(
            $tableRepo
        )
    );

} elseif ($_SERVER['REQUEST_METHOD'] === "GET" && substr($_SERVER['REQUEST_URI'], 0, 6) === "/seat/") {
    $controller = new \ConorSmith\Recollect\Infrastructure\Controllers\GetTablePage(
        new \ConorSmith\Recollect\UseCases\ShowTable(
            $tableRepo
        )
    );

} elseif ($_SERVER['REQUEST_METHOD'] === "POST"
    && substr($_SERVER['REQUEST_URI'], 0, 6) === "/seat/"
    && substr($_SERVER['REQUEST_URI'], 42, 53) === "/start-game"
) {
    $controller = new \ConorSmith\Recollect\Infrastructure\Controllers\PostStartGame(
        new \ConorSmith\Recollect\UseCases\StartGame(
            $gameRepo,
            $tableRepo
        )
    );

} elseif ($_SERVER['REQUEST_METHOD'] === "GET" && substr($_SERVER['REQUEST_URI'], 0, 8) === "/player/") {
    $controller = new \ConorSmith\Recollect\Infrastructure\Controllers\GetPlayerPage(
        new \ConorSmith\Recollect\UseCases\ShowPlayer(
            $gameRepo
        )
    );

} elseif ($_SERVER['REQUEST_METHOD'] === "POST"
    && substr($_SERVER['REQUEST_URI'], 0, 8) === "/player/"
    && substr($_SERVER['REQUEST_URI'], 44, 54) === "/draw-card"
) {
    $controller = new \ConorSmith\Recollect\Infrastructure\Controllers\PostDrawCard(
        new \ConorSmith\Recollect\UseCases\DrawCard(
            $gameRepo
        )
    );

} elseif ($_SERVER['REQUEST_METHOD'] === "POST"
    && substr($_SERVER['REQUEST_URI'], 0, 8) === "/player/"
    && substr($_SERVER['REQUEST_URI'], 44, 57) === "/win-face-off"
) {
    $controller = new \ConorSmith\Recollect\Infrastructure\Controllers\PostWinFaceOff(
        new \ConorSmith\Recollect\UseCases\WinFaceOff(
            $gameRepo
        )
    );

} else {
    http_response_code(404);
    echo "Page Not Found";
    exit;
}


$controller($request);
