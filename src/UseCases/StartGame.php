<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\UseCases;

use ConorSmith\Recollect\Application\CommandResult\StartedGame;
use ConorSmith\Recollect\Domain\GameRepository;
use ConorSmith\Recollect\Domain\Setup\SeatId;
use ConorSmith\Recollect\Domain\Setup\TableRepository;

class StartGame
{
    /** @var GameRepository */
    private $gameRepo;

    /** @var TableRepository */
    private $tableRepo;

    public function __construct(GameRepository $gameRepo, TableRepository $tableRepo)
    {
        $this->gameRepo = $gameRepo;
        $this->tableRepo = $tableRepo;
    }

    public function __invoke(SeatId $seatId): StartedGame
    {
        $table = $this->tableRepo->findForSeat($seatId);

        if (is_null($table)) {
            return StartedGame::failure();
        }

        if (!$table->isOpen()) {
            return StartedGame::failure();
        }

        if (!$table->canStartGame()) {
            return StartedGame::failure();
        }

        $game = $table->startGame();

        $this->gameRepo->save($game);
        $this->tableRepo->save($table);

        $playerId = $table->getSeat($seatId)->getPlayerId();

        return StartedGame::success($playerId);
    }
}
