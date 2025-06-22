<?php

namespace App\Service;

use App\Entity\Client;
use App\Enum\LoanStatus;

interface LoanRulesEvaluatorInterface
{
    public function evaluate(Client $client): LoanStatus;
}
