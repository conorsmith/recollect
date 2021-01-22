<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\UseCases;

use ConorSmith\Recollect\Domain\GameRepository;
use ConorSmith\Recollect\Domain\PlayerId;

class DrawTieBreaker
{
    /** @var GameRepository */
    private $gameRepo;

    public function __construct(GameRepository $gameRepo)
    {
        $this->gameRepo = $gameRepo;
    }

    public function __invoke(PlayerId $playerId)
    {
        $game = $this->gameRepo->findForPlayer($playerId);

        if (is_null($game)) {
            // Game not found
        }

        if (!$game->hasActiveFaceOff()) {
            // Can't draw tie breaker unless during a face off
        }

        if ($game->isGameOver()) {
            // Can't draw tie breaker when the game has ended
            return;
        }

        $drawPile = $game->getDrawPile();
        $tieBreakerPile = $game->getPlayer($playerId)->getTieBreakerPile();

        $card = $drawPile->draw();

        // TODO: Deal with a wild card

        $tieBreakerPile->placeAtop($card);

        $this->gameRepo->save($game);
    }
}
