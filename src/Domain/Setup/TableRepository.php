<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain\Setup;

interface TableRepository
{
    public function findByJoinCode(string $joinCode): ?Table;
    public function findForSeat(SeatId $seatId): ?Table;
    public function save(Table $table): void;
}
