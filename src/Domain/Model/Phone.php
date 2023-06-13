<?php

namespace Alura\Pdo\Domain\Model;

class Phone
{
    /** @var null|int */
    private ?int $id;

    /** @var string $areaCode */
    private string $areaCode;

    /** @var string $number */
    private string $number;

    public function __construct(?int $id, string $areaCode, string $number)
    {
        $this->id = $id;
        $this->areaCode = $areaCode;
        $this->number = $number;
    }

    /** @return string */
    public function formattedPhone(): string
    {
        return "($this->areaCode) $this->number";
    }
}
