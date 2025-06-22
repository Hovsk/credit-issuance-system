<?php

namespace App\Service\LoanRules;

use App\Entity\Client;
use App\Enum\Region;

class RegionAllowedRule implements LoanRuleInterface
{
    public function passes(Client $client): bool
    {
        return in_array($client->getAddress()->getRegion(), [
            Region::PRAGUE,
            Region::BRNO,
            Region::OSTRAVA,
        ], true);
    }
}
