<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\Loan;

interface LoanAdjusterInterface
{
    public function adjust(float $baseRate, Client $client): float;
}
