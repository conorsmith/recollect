<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\UseCases;

use ConorSmith\Recollect\Domain\Setup\SeatId;
use ConorSmith\Recollect\Domain\Setup\Table;
use ConorSmith\Recollect\Domain\Setup\TableRepository;
use RandomLib\Generator;

class OpenTable
{
    /** @var TableRepository */
    private $tableRepo;

    /** @var Generator */
    private $randomGenerator;

    public function __construct(TableRepository $tableRepo, Generator $randomGenerator)
    {
        $this->tableRepo = $tableRepo;
        $this->randomGenerator = $randomGenerator;
    }

    public function __invoke(): SeatId
    {
        $table = Table::openWithJoinCode(
            $this->randomGenerator->generateString("4", "BCDFGHJKLMNPQRSTVWXYZ")
        );

        $this->tableRepo->save($table);

        return $table->getLastSeatJoined()->getId();
    }
}
