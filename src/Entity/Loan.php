<?php

namespace App\Entity;

use App\Enum\LoanStatus;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Loan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private readonly \DateTimeImmutable $startDate;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private readonly \DateTimeImmutable $endDate;

    #[ORM\Column]
    private readonly \DateTimeImmutable $createdAt;

    /**
     * @throws \DateMalformedStringException
     */
    public function __construct(
        #[ORM\ManyToOne(targetEntity: Client::class)]
        #[ORM\JoinColumn(nullable: false)]
        private readonly Client $client,

        #[ORM\Column(length: 100)]
        private readonly string $name,

        #[ORM\Column]
        private readonly int $amount,

        #[ORM\Column(type: 'float')]
        private readonly float $rate,

        #[ORM\Column(length: 20, enumType: LoanStatus::class)]
        private LoanStatus $status = LoanStatus::PENDING,

        string $startDate,
        string $endDate,
    ) {
        $this->startDate = new \DateTimeImmutable($startDate);
        $this->endDate = new \DateTimeImmutable($endDate);
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getStatus(): LoanStatus
    {
        return $this->status;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function approve(): void
    {
        $this->status = LoanStatus::APPROVED;
    }

    public function reject(): void
    {
        $this->status = LoanStatus::REJECTED;
    }
}
