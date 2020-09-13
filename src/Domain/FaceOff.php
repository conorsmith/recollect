<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain;

final class FaceOff
{
    /** @var Player */
    private $playerA;

    /** @var Player */
    private $playerB;

    public function __construct(Player $playerA, Player $playerB)
    {
        $this->playerA = $playerA;
        $this->playerB = $playerB;
    }

    public function getOtherPlayer(PlayerId $playerId): Player
    {
        if ($this->playerA->getId()->equals($playerId)) {
            return $this->playerB;
        }

        if ($this->playerB->getId()->equals($playerId)) {
            return $this->playerA;
        }

        // Throw exception
    }

    public function includesPlayer(PlayerId $playerId): bool
    {
        return $this->playerA->getId()->equals($playerId)
            || $this->playerB->getId()->equals($playerId);
    }
}
