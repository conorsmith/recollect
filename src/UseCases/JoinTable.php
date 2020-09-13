<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\UseCases;

use ConorSmith\Recollect\Domain\Setup\SeatId;
use ConorSmith\Recollect\Domain\Setup\TableRepository;

class JoinTable
{
    /** @var TableRepository */
    private $tableRepo;

    public function __construct(TableRepository $tableRepo)
    {
        $this->tableRepo = $tableRepo;
    }

    public function __invoke(string $joinCode): SeatId
    {
        $table = $this->tableRepo->findByJoinCode($joinCode);

        if (is_null($table)) {
            // Table not found
        }

        if (!$table->isOpen()) {
            // TODO: Handle not being able to add a player to a closed table
        }

        $table->join();

        $this->tableRepo->save($table);

        return $table->getLastSeatJoined()->getId();
    }
}
