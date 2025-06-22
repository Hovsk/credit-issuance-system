<?php

namespace App\Service\LoanRules;

use App\Entity\Client;

interface LoanRuleInterface
{
    public function passes(Client $client): bool;
}
