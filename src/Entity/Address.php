<?php

namespace App\Entity;

use App\Enum\Region;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[ORM\Column(length: 100)]
        private readonly string $city,

        #[ORM\Column(length: 2, enumType: Region::class)]
        private readonly Region $region,
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getRegion(): Region
    {
        return $this->region;
    }

    public function toArray(): array
    {
        return [
            'city' => $this->city,
            'region' => $this->region->value,
        ];
    }
}
