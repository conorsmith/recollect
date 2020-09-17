<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\UseCases;

use ConorSmith\Recollect\Application\CommandResult\JoinedTable;
use ConorSmith\Recollect\Domain\Setup\TableRepository;

class JoinTable
{
    /** @var TableRepository */
    private $tableRepo;

    public function __construct(TableRepository $tableRepo)
    {
        $this->tableRepo = $tableRepo;
    }

    public function __invoke(string $joinCode): JoinedTable
    {
        $table = $this->tableRepo->findByJoinCode($joinCode);

        if (is_null($table)) {
            return JoinedTable::failure();
        }

        if (!$table->isOpen()) {
            return JoinedTable::failure();
        }

        $table->join();

        $this->tableRepo->save($table);

        return JoinedTable::success($table->getLastSeatJoined()->getId());
    }
}
