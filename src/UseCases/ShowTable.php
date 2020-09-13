<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\UseCases;

use ConorSmith\Recollect\Domain\Setup\SeatId;
use ConorSmith\Recollect\Domain\Setup\Table;
use ConorSmith\Recollect\Domain\Setup\TableRepository;

class ShowTable
{
    /** @var TableRepository */
    private $tableRepo;

    public function __construct(TableRepository $tableRepo)
    {
        $this->tableRepo = $tableRepo;
    }

    public function __invoke(SeatId $seatId): Table
    {
        $table = $this->tableRepo->findForSeat($seatId);

        if (is_null($table)) {
            // Table not found
        }

        return $table;
    }
}
