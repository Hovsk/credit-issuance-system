<?php

namespace App\Service\LoanRate;

use App\Entity\Client;
use App\Enum\Region;

class OstravaRateIncreaseModifier implements LoanRateModifierInterface
{
    public function supports(Client $client): bool
    {
        return $client->getAddress()->getRegion() === Region::OSTRAVA;
    }

    public function modify(float $baseRate, Client $client): float
    {
        return $baseRate + 5.0;
    }
}
