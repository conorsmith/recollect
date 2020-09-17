<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Application\CommandResult;

use ConorSmith\Recollect\Domain\Setup\SeatId;

final class JoinedTable
{
    public static function success(SeatId $seatId): self
    {
        return new self(true, $seatId);
    }

    public static function failure(): self
    {
        return new self(false, null);
    }

    /** @var bool */
    private $succeeded;

    /** @var ?SeatId */
    private $seatId;

    public function __construct(bool $succeeded, ?SeatId $seatId)
    {
        $this->succeeded = $succeeded;
        $this->seatId = $seatId;
    }

    public function succeeded(): bool
    {
        return $this->succeeded;
    }

    public function getSeatId(): SeatId
    {
        return $this->seatId;
    }
}
