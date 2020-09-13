<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain\Setup;

use ConorSmith\Recollect\Domain\DrawPile;
use ConorSmith\Recollect\Domain\Game;
use ConorSmith\Recollect\Domain\GameId;
use ConorSmith\Recollect\Domain\Player;

final class Table
{
    public static function openWithJoinCode(string $code): self
    {
        return new self(
            TableId::generate(),
            $code,
            [
                Seat::generate(),
            ],
            $isOpen = true
        );
    }

    /** @var TableId */
    private $id;

    /** @var string */
    private $code;

    /** @var array */
    private $seats;

    /** @var bool */
    private $isOpen;

    public function __construct(TableId $id, string $code, array $seats, bool $isOpen)
    {
        $this->id = $id;
        $this->code = $code;
        $this->seats = $seats;
        $this->isOpen = $isOpen;
    }

    public function getId(): TableId
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getSeats(): array
    {
        return $this->seats;
    }

    public function isOpen(): bool
    {
        return $this->isOpen;
    }

    public function join(): void
    {
        $this->seats[] = Seat::generate();
    }

    public function getLastSeatJoined(): Seat
    {
        return $this->seats[count($this->seats) - 1];
    }

    public function startGame(): Game
    {
        if (count($this->seats) === 0) {
            // Throw an exception
        }

        $players = [];

        /** @var Seat $seat */
        foreach ($this->seats as $seat) {
            $players[] = $seat->generatePlayer();
        }

        $game = new Game(
            GameId::generate(),
            $players,
            $turnIndex = 0,
            DrawPile::generate()
        );

        $this->close();

        return $game;
    }

    public function getSeat(SeatId $seatId): Seat
    {
        /** @var Seat $seat */
        foreach ($this->seats as $seat) {
            if ($seat->getId()->__toString() === $seatId->__toString()) {
                return $seat;
            }
        }

        // TODO: Handle seat not existing
    }

    private function close(): void
    {
        // TODO: Stop a closed table from being closed again
        $this->isOpen = false;
    }
}
