<?php

namespace App\Service\LoanRules;

use App\Entity\Client;

class MinimumScoreRule implements LoanRuleInterface
{
    public function passes(Client $client): bool
    {
        return $client->getScore() > 500;
    }
}
