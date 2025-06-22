<?php

namespace App\Service\LoanRate;

use App\Entity\Client;

interface LoanRateModifierInterface
{
    public function supports(Client $client): bool;

    public function modify(float $baseRate, Client $client): float;
}
