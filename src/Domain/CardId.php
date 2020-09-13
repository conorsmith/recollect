<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain;

use Ramsey\Uuid\UuidInterface;

final class CardId
{
    /** @var UuidInterface */
    private $value;

    public function __construct(UuidInterface $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value->toString();
    }

    public function equals(self $other): bool
    {
        return $this->value->equals($other->value);
    }
}
