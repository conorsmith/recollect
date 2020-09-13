<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain\Setup;

use ConorSmith\Recollect\Domain\Player;
use ConorSmith\Recollect\Domain\PlayerId;
use ConorSmith\Recollect\Domain\PlayPile;
use ConorSmith\Recollect\Domain\WinningPile;

final class Seat
{
    public static function generate(): self
    {
        return new self(SeatId::generate(), null);
    }

    /** @var SeatId */
    private $id;

    /** @var ?PlayerId */
    private $playerId;

    public function __construct(SeatId $id, ?PlayerId $playerId)
    {
        $this->id = $id;
        $this->playerId = $playerId;
    }

    public function getId(): SeatId
    {
        return $this->id;
    }

    public function getPlayerId(): ?PlayerId
    {
        return $this->playerId;
    }

    public function generatePlayer(): Player
    {
        $player = new Player(
            PlayerId::generate(),
            PlayPile::createEmpty(),
            WinningPile::createEmpty()
        );

        $this->playerId = $player->getId();

        return $player;
    }
}
