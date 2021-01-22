<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain;

final class Player
{
    /** @var PlayerId */
    private $id;

    /** @var PlayPile */
    private $playPile;

    /** @var WinningPile */
    private $winningPile;

    /** @var TieBreakerPile */
    private $tieBreakerPile;

    public function __construct(
        PlayerId $id,
        PlayPile $playPile,
        WinningPile $winningPile,
        TieBreakerPile $tieBreakerPile
    ) {
        $this->id = $id;
        $this->playPile = $playPile;
        $this->winningPile = $winningPile;
        $this->tieBreakerPile = $tieBreakerPile;
    }

    public function getId(): PlayerId
    {
        return $this->id;
    }

    public function getPlayPile(): PlayPile
    {
        return $this->playPile;
    }

    public function getWinningPile(): WinningPile
    {
        return $this->winningPile;
    }

    public function getTieBreakerPile()
    {
        return $this->tieBreakerPile;
    }
}
