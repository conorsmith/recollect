<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Repositories;

use ConorSmith\Recollect\Domain\Card;
use ConorSmith\Recollect\Domain\CardId;
use ConorSmith\Recollect\Domain\Deck;
use ConorSmith\Recollect\Domain\DrawPile;
use ConorSmith\Recollect\Domain\Game;
use ConorSmith\Recollect\Domain\GameId;
use ConorSmith\Recollect\Domain\GameRepository;
use ConorSmith\Recollect\Domain\Player;
use ConorSmith\Recollect\Domain\PlayerId;
use ConorSmith\Recollect\Domain\PlayPile;
use ConorSmith\Recollect\Domain\TieBreakerPile;
use ConorSmith\Recollect\Domain\WinningPile;
use ConorSmith\Recollect\Infrastructure\Clock;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\Uuid;

final class GameRepositoryDb implements GameRepository
{
    /** @var Connection */
    private $db;

    /** @var Clock */
    private $clock;

    /** @var Deck */
    private $deck;

    public function __construct(Connection $db, Clock $clock, Deck $deck)
    {
        $this->db = $db;
        $this->clock = $clock;
        $this->deck = $deck;
    }

    public function findForPlayer(PlayerId $playerId): ?Game
    {
        $row = $this->db->fetchAssoc("SELECT * FROM players WHERE id = :playerId", [
            'playerId' => $playerId,
        ]);

        if ($row === false) {
            return null;
        }

        return $this->reconstituteGame(new GameId(Uuid::fromString($row['game_id'])));
    }

    private function reconstituteGame(GameId $gameId): Game
    {
        $row = $this->db->fetchAssoc("SELECT * FROM games WHERE id = :gameId", [
            'gameId' => $gameId,
        ]);

        $playerRows = $this->db->fetchAll("SELECT * FROM players WHERE game_id = :gameId ORDER BY created_at", [
            'gameId' => $gameId,
        ]);

        $players = [];

        /** @var array $playerRow */
        foreach ($playerRows as $playerRow) {

            $decodedPlayPile = json_decode($playerRow['play_pile']);
            $playPileCards = [];

            /** @var string $cardId */
            foreach ($decodedPlayPile as $cardId) {
                $playPileCards[] = $this->deck->findCard(new CardId(Uuid::fromString($cardId)));
            }

            $decodedTieBreakerPile = json_decode($playerRow['tie_breaker_pile']);
            $tieBreakerPileCards = [];

            /** @var string $cardId */
            foreach ($decodedTieBreakerPile as $cardId) {
                $tieBreakerPileCards[] = $this->deck->findCard(new CardId(Uuid::fromString($cardId)));
            }

            $players[] = new Player(
                new PlayerId(Uuid::fromString($playerRow['id'])),
                new PlayPile($playPileCards),
                new WinningPile(intval($playerRow['winning_pile_count'])),
                new TieBreakerPile($tieBreakerPileCards)
            );
        }

        $decodedDrawPile = json_decode($row['draw_pile']);
        $drawPileCards = [];

        /** @var string $cardId */
        foreach ($decodedDrawPile as $cardId) {
            $drawPileCards[] = $this->deck->findCard(new CardId(Uuid::fromString($cardId)));
        }

        return new Game(
            $gameId,
            $players,
            intval($row['turn_index']),
            new DrawPile($drawPileCards)
        );
    }

    public function save(Game $game): void
    {
        $nowAsString = $this->clock->now()->format("Y-m-d H:i:s");

        $row = $this->db->fetchAssoc("SELECT * FROM games WHERE id = :gameId", [
            'gameId' => $game->getId(),
        ]);

        $drawPileCardIds = [];

        /** @var Card $card */
        foreach ($game->getDrawPile()->getCards() as $card) {
            $drawPileCardIds[] = $card->getId()->__toString();
        }

        $encodedDrawPile = json_encode($drawPileCardIds);

        if ($row === false) {
            $this->db->insert("games", [
                'id'          => $game->getId(),
                'draw_pile'   => $encodedDrawPile,
                'turn_index'  => $game->getTurnIndex(),
                'created_at'  => $nowAsString,
            ]);

            /** @var Player $player */
            foreach ($game->getPlayers() as $player) {
                $this->db->insert("players", [
                    'id'                 => $player->getId(),
                    'game_id'            => $game->getId(),
                    'play_pile'          => json_encode([]),
                    'winning_pile_count' => $player->getWinningPile()->getTotal(),
                    'tie_breaker_pile'   => json_encode([]),
                    'created_at'         => $nowAsString,
                ]);
            }

        } else {
            $this->db->update("games", [
                'turn_index'  => $game->getTurnIndex(),
                'draw_pile'   => $encodedDrawPile,
                'updated_at'  => $nowAsString,
            ], [
                'id' => $game->getId(),
            ]);

            /** @var Player $player */
            foreach ($game->getPlayers() as $player) {

                $row = $this->db->fetchAssoc("SELECT * FROM players WHERE id = :playerId", [
                    'playerId' => $player->getId(),
                ]);

                if ($row === false) {
                    $this->db->insert("players", [
                        'id'                 => $player->getId(),
                        'game_id'            => $game->getId(),
                        'play_pile'          => json_encode([]),
                        'winning_pile_count' => $player->getWinningPile()->getTotal(),
                        'tie_breaker_pile'   => json_encode([]),
                        'created_at'         => $nowAsString,
                    ]);
                } else {

                    $playPileCardIds = [];

                    /** @var Card $card */
                    foreach ($player->getPlayPile()->getCards() as $card) {
                        $playPileCardIds[] = $card->getId()->__toString();
                    }

                    $encodedPlayPile = json_encode($playPileCardIds);

                    $tieBreakerPileCardIds = [];

                    /** @var Card $card */
                    foreach ($player->getTieBreakerPile()->getCards() as $card) {
                        $tieBreakerPileCardIds[] = $card->getId()->__toString();
                    }

                    $encodedTieBreakerPile = json_encode($tieBreakerPileCardIds);

                    $this->db->update("players", [
                        'play_pile'          => $encodedPlayPile,
                        'winning_pile_count' => $player->getWinningPile()->getTotal(),
                        'tie_breaker_pile'   => $encodedTieBreakerPile,
                        'updated_at'         => $nowAsString,
                    ], [
                        'id' => $player->getId(),
                    ]);
                }
            }
        }
    }
}
