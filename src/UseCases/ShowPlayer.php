<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\UseCases;

use ConorSmith\Recollect\Application\QueryResult\Player;
use ConorSmith\Recollect\Domain\GameRepository;
use ConorSmith\Recollect\Domain\PlayerId;

class ShowPlayer
{
    /** @var GameRepository */
    private $gameRepo;

    public function __construct(GameRepository $gameRepo)
    {
        $this->gameRepo = $gameRepo;
    }

    public function __invoke(PlayerId $playerId): Player
    {
        $game = $this->gameRepo->findForPlayer($playerId);

        if (is_null($game)) {
            // Game not found
        }

        $player = $game->getPlayer($playerId);

        return new Player(
            $player->getPlayPile(),
            $player->getWinningPile(),
            $player->getTieBreakerPile(),
            $game->canPlayerDrawCard($player->getId()),
            $game->canPlayerCompeteInFaceOff($player->getId()),
            $game->canPlayerDrawTieBreaker($player->getId()),
            $game->isGameOver(),
            $game->isGameOver() ? $game->getEndOfGameStatusForPlayer($player->getId()) : null
        );
    }
}
