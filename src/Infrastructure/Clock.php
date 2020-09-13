<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure;

use DateTimeImmutable;

final class Clock
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable("now", new \DateTimeZone("Europe/Dublin"));
    }
}
