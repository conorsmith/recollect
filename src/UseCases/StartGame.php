<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\UseCases;

use ConorSmith\Recollect\Domain\GameRepository;
use ConorSmith\Recollect\Domain\PlayerId;
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

    public function __invoke(SeatId $seatId): PlayerId
    {
        $table = $this->tableRepo->findForSeat($seatId);

        if (is_null($table)) {
            // Table not found
        }

        if (!$table->isOpen()) {
            // Cannot start a game when the table is closed
        }

        $game = $table->startGame();

        $this->gameRepo->save($game);
        $this->tableRepo->save($table);

        $playerId = $table->getSeat($seatId)->getPlayerId();

        if (is_null($playerId)) {
            // TODO: Handle player ID not being set
        }

        return $playerId;
    }
}
