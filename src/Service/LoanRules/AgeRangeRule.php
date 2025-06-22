<?php

namespace App\Service\LoanRules;

use App\Entity\Client;

class AgeRangeRule implements LoanRuleInterface
{
    public function passes(Client $client): bool
    {
        $age = $client->getAge();
        return $age >= 18 && $age <= 60;
    }
}

