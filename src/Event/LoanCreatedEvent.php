<?php

namespace App\Event;

use App\Entity\Loan;

readonly class LoanCreatedEvent
{
    public function __construct(public Loan $loan) {}
}
