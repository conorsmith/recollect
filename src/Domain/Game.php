<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain;

final class Game
{
    /** @var GameId */
    private $id;

    /** @var Player[] */
    private $players;

    /** @var int */
    private $turnIndex;

    /** @var DrawPile */
    private $drawPile;

    public function __construct(GameId $id, array $players, int $turnIndex, DrawPile $drawPile)
    {
        $this->id = $id;
        $this->players = $players;
        $this->turnIndex = $turnIndex;
        $this->drawPile = $drawPile;

        usort($this->players, function (Player $playerA, Player $playerB) {
            return strcmp(
                $playerA->getId()->__toString(),
                $playerB->getId()->__toString()
            );
        });
    }

    public function getId(): GameId
    {
        return $this->id;
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getTurnIndex(): int
    {
        return $this->turnIndex;
    }

    public function getDrawPile(): DrawPile
    {
        return $this->drawPile;
    }

    public function getLastAddedPlayerId(): PlayerId
    {
        return $this->players[count($this->players) - 1]->getId();
    }

    public function getPlayer(PlayerId $playerId): Player
    {
        /** @var Player $player */
        foreach ($this->players as $player) {
            if ($player->getId()->__toString() === $playerId->__toString()) {
                return $player;
            }
        }

        // TODO: Throw exception
    }

    public function getDrawingPlayerId(): PlayerId
    {
        $playerIndex = $this->turnIndex % count($this->players);

        return $this->players[$playerIndex]->getId();
    }

    public function getActiveFaceOff(): FaceOff
    {
        $faceOff = $this->getPossibleFaceOff();

        if (is_null($faceOff)) {
            // Throw exception
        }

        return $faceOff;
    }

    public function hasActiveFaceOff(): bool
    {
        return !is_null($this->getPossibleFaceOff());
    }

    private function getPossibleFaceOff(): ?FaceOff
    {
        $playersBySymbolOnFaceUpCard = [];

        foreach ($this->players as $player) {
            $faceUpCard = $player->getPlayPile()->getFaceUpCard();

            if (is_null($faceUpCard)) {
                continue;
            }

            $symbolId = $faceUpCard->getSymbol()->getId()->__toString();

            if (!array_key_exists($symbolId, $playersBySymbolOnFaceUpCard)) {
                $playersBySymbolOnFaceUpCard[$symbolId] = [];
            }

            $playersBySymbolOnFaceUpCard[$symbolId][] = $player;
        }

        foreach ($playersBySymbolOnFaceUpCard as $symbolId => $players) {
            if (count($players) > 1) {
                return new FaceOff($players[0], $players[1]);
            }
        }

        return null;
    }

    public function isCurrentTurnForPlayer(PlayerId $playerId): bool
    {
        $playerIndex = $this->turnIndex % count($this->players);

        return $this->players[$playerIndex]->getId()->equals($playerId);
    }

    public function endTurn(): void
    {
        $this->turnIndex++;
    }

    public function isGameOver(): bool
    {
        return $this->drawPile->isEmpty();
    }

    public function canPlayerDrawCard(PlayerId $playerId): bool
    {
        return $this->isCurrentTurnForPlayer($playerId)
            && !$this->hasActiveFaceOff()
            && !$this->isGameOver();
    }

    public function canPlayerCompeteInFaceOff(PlayerId $playerId): bool
    {
        if (!$this->hasActiveFaceOff()) {
            return false;
        }

        $faceOff = $this->getActiveFaceOff();

        return $faceOff->includesPlayer($playerId);
    }

    public function getEndOfGameStatusForPlayer(PlayerId $playerId): EndOfGameStatus
    {
        if (!$this->isGameOver()) {
            // TODO: throw exception
        }

        $leadingPlayers = [
            $this->players[0],
        ];

        /** @var Player $player */
        foreach (array_slice($this->players, 1) as $player) {
            if ($player->getWinningPile()->beats($leadingPlayers[0]->getWinningPile())) {
                $leadingPlayers = [
                    $player,
                ];
            } elseif ($player->getWinningPile()->matches($leadingPlayers[0]->getWinningPile())) {
                $leadingPlayers[] = $player;
            }
        }

        $isALeadingPlayer = false;

        /** @var Player $player */
        foreach ($leadingPlayers as $player) {
            if ($playerId->equals($player->getId())) {
                $isALeadingPlayer = true;
            }
        }

        if (!$isALeadingPlayer) {
            return EndOfGameStatus::lose();
        }

        if (count($leadingPlayers) === 1) {
            return EndOfGameStatus::win();
        }

        return EndOfGameStatus::draw();
    }
}
