<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\UseCases;

use ConorSmith\Recollect\Domain\GameRepository;
use ConorSmith\Recollect\Domain\PlayerId;

class WinFaceOff
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
            return;
        }

        if (!$game->hasActiveFaceOff()) {
            // Can't win when there is no face off
            return;
        }

        if (!$game->getActiveFaceOff()->includesPlayer($playerId)) {
            // Can't win a face off you're not part of
            return;
        }

        $winningPlayer = $game->getPlayer($playerId);
        $losingPlayer = $game->getActiveFaceOff()->getOtherPlayer($playerId);

        $winningPile = $winningPlayer->getWinningPile();

        $card = $losingPlayer->getPlayPile()->takeTopCard();

        $winningPile->add($card);

        $this->gameRepo->save($game);
    }
}
