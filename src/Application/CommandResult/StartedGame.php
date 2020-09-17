<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Application\CommandResult;

use ConorSmith\Recollect\Domain\PlayerId;

final class StartedGame
{
    public static function success(PlayerId $playerId): self
    {
        return new self(true, $playerId);
    }

    public static function failure(): self
    {
        return new self(false, null);
    }

    /** @var bool */
    private $succeeded;

    /** @var ?PlayerId */
    private $playerId;

    private function __construct(bool $succeeded, ?PlayerId $playerId)
    {
        $this->succeeded = $succeeded;
        $this->playerId = $playerId;
    }

    public function succeeded(): bool
    {
        return $this->succeeded;
    }

    public function getPlayerId(): PlayerId
    {
        return $this->playerId;
    }
}
