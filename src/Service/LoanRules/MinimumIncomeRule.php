<?php

namespace App\Service\LoanRules;

use App\Entity\Client;

class MinimumIncomeRule implements LoanRuleInterface
{
    public function passes(Client $client): bool
    {
        return $client->getIncome() >= 1000;
    }
}
