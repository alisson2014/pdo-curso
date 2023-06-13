<?php

namespace Alura\Pdo\Domain\Model;

class Student
{
    /** @var int|null $id */
    private ?int $id;

    /** @var string $name */
    private string $name;

    /** @var \DateTimeInterface $birthDate */
    private \DateTimeInterface $birthDate;

    /** @var Phone[] */
    private array $phones = [];

    public function __construct(?int $id, string $name, \DateTimeInterface $birthDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    /**
     * @param int $id
     * @return void
     */
    public function defineId(int $id): void
    {
        if (!is_null($this->id)) {
            throw new \DomainException("Você só pode definir o id uma vez!");
        }

        $this->id = $id;
    }

    /** @return null|int */
    public function id(): ?int
    {
        return $this->id;
    }

    /** @return string */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param string $newName
     * @return void
     */
    public function changeName(string $newName): void
    {
        $this->name = $newName;
    }

    /** @return \DateTimeInterface */
    public function birthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    /** @return int */
    public function age(): int
    {
        return $this->birthDate
            ->diff(new \DateTimeImmutable())
            ->y;
    }

    /**
     * @param Phone $phone
     * @return void
     */
    public function addPhone(Phone $phone): void
    {
        $this->phones[] = $phone;
    }

    /** @return Phone[] */
    public function phones(): array
    {
        return $this->phones;
    }
}
