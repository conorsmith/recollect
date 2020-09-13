<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain;

use Ramsey\Uuid\UuidInterface;

final class Symbol
{
    /** @var UuidInterface */
    private $id;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
