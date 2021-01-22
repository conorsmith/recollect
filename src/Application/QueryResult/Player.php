<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Application\QueryResult;

use ConorSmith\Recollect\Domain\EndOfGameStatus;
use ConorSmith\Recollect\Domain\PlayPile;
use ConorSmith\Recollect\Domain\TieBreakerPile;
use ConorSmith\Recollect\Domain\WinningPile;

final class Player
{
    /** @var PlayPile */
    private $playPile;

    /** @var WinningPile */
    private $winningPile;

    /** @var TieBreakerPile */
    private $tieBreakerPile;

    /** @var bool */
    private $canDrawCard;

    /** @var bool */
    private $canCompeteInFaceOff;

    /** @var bool */
    private $canDrawTieBreaker;

    /** @var bool */
    private $isGameOver;

    /** @var ?EndOfGameStatus */
    private $endOfGameStatus;

    public function __construct(
        PlayPile $playPile,
        WinningPile $winningPile,
        TieBreakerPile $tieBreakerPile,
        bool $canDrawCard,
        bool $canCompeteInFaceOff,
        bool $canDrawTieBreaker,
        bool $isGameOver,
        ?EndOfGameStatus $endOfGameStatus
    ) {
        $this->playPile = $playPile;
        $this->winningPile = $winningPile;
        $this->tieBreakerPile = $tieBreakerPile;
        $this->canDrawCard = $canDrawCard;
        $this->canCompeteInFaceOff = $canCompeteInFaceOff;
        $this->canDrawTieBreaker = $canDrawTieBreaker;
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

    public function getTieBreakerPile(): TieBreakerPile
    {
        return $this->tieBreakerPile;
    }

    public function canDrawCard(): bool
    {
        return $this->canDrawCard;
    }

    public function canCompeteInFaceOff(): bool
    {
        return $this->canCompeteInFaceOff;
    }

    public function canDrawTieBreaker(): bool
    {
        return $this->canDrawTieBreaker;
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
