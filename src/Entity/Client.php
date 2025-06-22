<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[ORM\Column(length: 50)]
        private readonly string $pin,

        #[ORM\Column(length: 100)]
        private readonly string $name,

        #[ORM\Column]
        private readonly int $age,

        #[ORM\OneToOne(cascade: ['persist'], orphanRemoval: true)]
        #[ORM\JoinColumn(nullable: false, onDelete: 'restrict')]
        private readonly Address $address,

        #[ORM\Column]
        private readonly int $income,

        #[ORM\Column]
        private readonly int $score,

        #[ORM\Column(length: 100, unique: true)]
        private readonly string $email,

        #[ORM\Column(length: 20)]
        private readonly string $phone,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPin(): string
    {
        return $this->pin;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getIncome(): int
    {
        return $this->income;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'pin' => '*****',
            'name' => $this->name,
            'age' => $this->age,
            'address' => $this->address->toArray(),
            'income' => $this->income,
            'score' => $this->score,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}
