<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\UseCases;

use ConorSmith\Recollect\Domain\GameRepository;
use ConorSmith\Recollect\Domain\PlayerId;

class DrawCard
{
    /** @var GameRepository */
    private $gameRepo;

    public function __construct(GameRepository $gameRepo)
    {
        $this->gameRepo = $gameRepo;
    }

    public function __invoke(PlayerId $playerId): void
    {
        $game = $this->gameRepo->findForPlayer($playerId);

        if (is_null($game)) {
            // Game not found
        }

        if ($game->hasActiveFaceOff()) {
            // Can't draw during a face off
        }

        if (!$game->isCurrentTurnForPlayer($playerId)) {
            // Can't draw when it's not your turn
            return;
        }

        if ($game->isGameOver()) {
            // Can't draw when the game has ended
            return;
        }

        $drawPile = $game->getDrawPile();
        $playPile = $game->getPlayer($playerId)->getPlayPile();

        $card = $drawPile->draw();

        // TODO: Deal with a wild card

        $playPile->placeAtop($card);

        $game->endTurn();

        $this->gameRepo->save($game);
    }
}
