<?php

namespace App\Repository;

use App\Entity\Loan;

interface LoanRepositoryInterface
{
    public function save(Loan $loan): void; // TODO: Move this to other place please
}
