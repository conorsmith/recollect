<?php
declare(strict_types=1);

use ConorSmith\Recollect\Infrastructure\Controllers;
use FastRoute\RouteCollector;

return function (RouteCollector $r) {
    $r->get("/", Controllers\GetLandingPage::class);

    $r->post("/open-table", Controllers\PostOpenTable::class);
    $r->post("/join-table", Controllers\PostJoinTable::class);
    $r->get("/seat/{seatId}", Controllers\GetTablePage::class);
    $r->post("/seat/{seatId}/start-game", Controllers\PostStartGame::class);

    $r->get("/player/{playerId}", Controllers\GetPlayerPage::class);
    $r->get("/player/{playerId}/status", Controllers\GetPlayerStatus::class);
    $r->post("/player/{playerId}/draw-card", Controllers\PostDrawCard::class);
    $r->post("/player/{playerId}/win-face-off", Controllers\PostWinFaceOff::class);
    $r->post("/player/{playerId}/draw-tie-breaker", Controllers\PostDrawTieBreaker::class);
};
