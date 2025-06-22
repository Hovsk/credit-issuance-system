<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class ClientInputDto
{
    #[Assert\NotBlank]
    public string $pin;

    #[Assert\NotBlank]
    public string $name;

    #[Assert\Positive]
    #[Assert\NotBlank]
    public int $age;

    #[Assert\NotBlank]
    public string $city;

    #[Assert\NotBlank]
    public string $region;

    #[Assert\NotNull]
    #[Assert\Positive]
    public int $income;

    #[Assert\NotNull]
    public int $score;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    public string $phone;
}
