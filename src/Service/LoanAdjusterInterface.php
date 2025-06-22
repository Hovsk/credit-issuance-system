<?php

namespace App\Service;

use App\Entity\Client;

interface LoanAdjusterInterface
{
    public function adjust(float $baseRate, Client $client): float;
}
