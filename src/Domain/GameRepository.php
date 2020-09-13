<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain;

interface GameRepository
{
    public function findForPlayer(PlayerId $playerId): ?Game;
    public function save(Game $game): void;
}
