<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class LoanRequestDto
{
    #[Assert\NotBlank]
    public string $pin;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public string $name;

    #[Assert\Positive]
    public int $amount;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(0)]
    #[Assert\LessThanOrEqual(100)]
    public float $rate;

    #[SerializedName('start_date')]
    #[Assert\NotBlank]
    #[Assert\Date]
    public string $startDate;

    #[SerializedName('end_date')]
    #[Assert\NotBlank]
    #[Assert\Date]
    public string $endDate;
}
