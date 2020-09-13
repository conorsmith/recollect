<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Domain;

final class Card
{
    /** @var CardId */
    private $id;

    /** @var Symbol */
    private $symbol;

    public function __construct(CardId $id, Symbol $symbol)
    {
        $this->id = $id;
        $this->symbol = $symbol;
    }

    public function getId(): CardId
    {
        return $this->id;
    }

    public function getSymbol(): Symbol
    {
        return $this->symbol;
    }
}
