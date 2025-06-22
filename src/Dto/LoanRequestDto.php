<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;

class LoanRequestDto
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

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
