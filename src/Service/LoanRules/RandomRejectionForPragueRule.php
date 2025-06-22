<?php

namespace App\Service\LoanRules;

use App\Entity\Client;
use App\Enum\Region;
use Random\RandomException;

class RandomRejectionForPragueRule implements LoanRuleInterface
{
    /**
     * @throws RandomException
     */
    public function passes(Client $client): bool
    {
        if (Region::PRAGUE !== $client->getAddress()->getRegion()) {
            return true;
        }

        return random_int(1, 100) > 30; // 30% chance to fail
    }
}
