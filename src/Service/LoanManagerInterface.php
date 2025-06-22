<?php

namespace App\Service;

use App\Dto\LoanRequestDto;
use App\Entity\Loan;

interface LoanManagerInterface
{
    public function createLoan(int $clientId, LoanRequestDto $dto): Loan;
}
