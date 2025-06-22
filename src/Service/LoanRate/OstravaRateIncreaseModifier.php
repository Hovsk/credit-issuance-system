<?php

namespace App\Service\LoanRate;

use App\Entity\Client;
use App\Enum\Region;

class OstravaRateIncreaseModifier implements LoanRateModifierInterface
{
    public function supports(Client $client): bool
    {
        return Region::OSTRAVA === $client->getAddress()->getRegion();
    }

    public function modify(float $baseRate, Client $client): float
    {
        return $baseRate + 5.0;
    }
}
