<?php

namespace App\Service;

use App\Entity\Client;
use App\Service\LoanRate\LoanRateModifierInterface;

readonly class LoanRateAdjuster implements LoanAdjusterInterface
{
    /**
     * @param iterable<LoanRateModifierInterface> $modifiers
     */
    public function __construct(private iterable $modifiers)
    {
    }

    public function adjust(float $baseRate, Client $client): float
    {
        foreach ($this->modifiers as $modifier) {
            if ($modifier->supports($client)) {
                $baseRate = $modifier->modify($baseRate, $client);
            }
        }

        return $baseRate;
    }
}
