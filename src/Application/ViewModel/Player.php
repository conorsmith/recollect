<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Application\ViewModel;

use ConorSmith\Recollect\Domain\EndOfGameStatus;
use ConorSmith\Recollect\Domain\PlayPile;
use ConorSmith\Recollect\Domain\WinningPile;

final class Player
{
    /** @var PlayPile */
    private $playPile;

    /** @var WinningPile */
    private $winningPile;

    /** @var bool */
    private $canDrawCard;

    /** @var bool */
    private $canCompeteInFaceOff;

    /** @var bool */
    private $isGameOver;

    /** @var ?EndOfGameStatus */
    private $endOfGameStatus;

    public function __construct(
        PlayPile $playPile,
        WinningPile $winningPile,
        bool $canDrawCard,
        bool $canCompeteInFaceOff,
        bool $isGameOver,
        ?EndOfGameStatus $endOfGameStatus
    ) {
        $this->playPile = $playPile;
        $this->winningPile = $winningPile;
        $this->canDrawCard = $canDrawCard;
        $this->canCompeteInFaceOff = $canCompeteInFaceOff;
        $this->isGameOver = $isGameOver;
        $this->endOfGameStatus = $endOfGameStatus;
    }

    public function getPlayPile(): PlayPile
    {
        return $this->playPile;
    }

    public function getWinningPile(): WinningPile
    {
        return $this->winningPile;
    }

    public function canDrawCard(): bool
    {
        return $this->canDrawCard;
    }

    public function canCompeteInFaceOff(): bool
    {
        return $this->canCompeteInFaceOff;
    }

    public function isGameOver(): bool
    {
        return $this->isGameOver;
    }

    public function getEndOfGameStatus(): ?EndOfGameStatus
    {
        return $this->endOfGameStatus;
    }
}
