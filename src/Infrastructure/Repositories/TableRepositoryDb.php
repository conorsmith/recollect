<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Repositories;

use ConorSmith\Recollect\Domain\PlayerId;
use ConorSmith\Recollect\Domain\Setup\Seat;
use ConorSmith\Recollect\Domain\Setup\SeatId;
use ConorSmith\Recollect\Domain\Setup\Table;
use ConorSmith\Recollect\Domain\Setup\TableId;
use ConorSmith\Recollect\Domain\Setup\TableRepository;
use ConorSmith\Recollect\Infrastructure\Clock;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\Uuid;

final class TableRepositoryDb implements TableRepository
{
    /** @var Connection */
    private $db;

    /** @var Clock */
    private $clock;

    public function __construct(Connection $db, Clock $clock)
    {
        $this->db = $db;
        $this->clock = $clock;
    }

    public function findByJoinCode(string $joinCode): ?Table
    {
        $row = $this->db->fetchAssoc("SELECT * FROM tables WHERE code = :code", [
            'code' => $joinCode,
        ]);

        if ($row === false) {
            return null;
        }

        $seatRows = $this->db->fetchAll("SELECT * FROM seats WHERE table_id = :tableId", [
            'tableId' => $row['id'],
        ]);

        $seats = [];

        foreach ($seatRows as $seatRow) {
            $seats[] = new Seat(
                new SeatId(Uuid::fromString($seatRow['id'])),
                is_null($seatRow['player_id']) ? null : new PlayerId(Uuid::fromString($seatRow['player_id']))
            );
        }

        return new Table(
            new TableId(Uuid::fromString($row['id'])),
            $row['code'],
            $seats,
            $row['is_open'] === "1"
        );
    }

    public function findForSeat(SeatId $seatId): ?Table
    {
        $seatRow = $this->db->fetchAssoc("SELECT * FROM seats WHERE id = :seatId", [
            'seatId' => $seatId,
        ]);

        if ($seatRow === false) {
            return null;
        }

        $row = $this->db->fetchAssoc("SELECT * FROM tables WHERE id = :tableId", [
            'tableId' => $seatRow['table_id'],
        ]);

        if ($row === false) {
            return null;
        }

        $seatRows = $this->db->fetchAll("SELECT * FROM seats WHERE table_id = :tableId", [
            'tableId' => $row['id'],
        ]);

        $seats = [];

        foreach ($seatRows as $seatRow) {
            $seats[] = new Seat(
                new SeatId(Uuid::fromString($seatRow['id'])),
                is_null($seatRow['player_id']) ? null : new PlayerId(Uuid::fromString($seatRow['player_id']))
            );
        }

        return new Table(
            new TableId(Uuid::fromString($row['id'])),
            $row['code'],
            $seats,
            $row['is_open'] === "1"
        );
    }

    public function save(Table $table): void
    {
        $nowAsString = $this->clock->now()->format("Y-m-d H:i:s");

        $row = $this->db->fetchAssoc("SELECT * FROM tables WHERE id = :id", [
            'id' => $table->getId()
        ]);

        if ($row === false) {
            $this->db->insert("tables", [
                'id'         => $table->getId(),
                'code'       => $table->getCode(),
                'is_open'    => $table->isOpen() ? 1 : 0,
                'created_at' => $nowAsString,
            ]);

            /** @var Seat $seat */
            foreach ($table->getSeats() as $seat) {
                $this->db->insert("seats", [
                    'id'         => $seat->getId(),
                    'table_id'   => $table->getId(),
                    'player_id'  => $seat->getPlayerId(),
                    'created_at' => $nowAsString,
                ]);
            }
        } else {
            $this->db->update("tables", [
                'code'       => $table->getCode(),
                'is_open'    => $table->isOpen() ? 1 : 0,
                'updated_at' => $nowAsString,
            ], [
                'id' => $table->getId(),
            ]);

            /** @var Seat $seat */
            foreach ($table->getSeats() as $seat) {

                $seatRow = $this->db->fetchAssoc("SELECT * FROM seats WHERE id = :seatId", [
                    'seatId' => $seat->getId(),
                ]);

                if ($seatRow === false) {
                    $this->db->insert("seats", [
                        'id'         => $seat->getId(),
                        'table_id'   => $table->getId(),
                        'player_id'  => $seat->getPlayerId(),
                        'created_at' => $nowAsString,
                    ]);
                } else {
                    $this->db->update("seats", [
                        'table_id'   => $table->getId(),
                        'player_id'  => $seat->getPlayerId(),
                        'updated_at' => $nowAsString,
                    ], [
                        'id' => $seat->getId(),
                    ]);
                }
            }
        }
    }
}
