<?php

namespace App\Service;

use App\Entity\Client;
use App\Enum\LoanStatus;

readonly class LoanRulesEvaluator implements LoanRulesEvaluatorInterface
{
    /**@param iterable<LoanRuleInterface> $rules */
    public function __construct(private iterable $rules)
    {
    }

    public function evaluate(Client $client): LoanStatus
    {
        foreach ($this->rules as $rule) {
            if (!$rule->passes($client)) {
                return LoanStatus::REJECTED;
            }
        }

        return LoanStatus::APPROVED;
    }
}

