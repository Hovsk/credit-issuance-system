<?php

namespace App\Service;

use App\DTO\LoanRequestDto;
use App\Entity\Loan;
use App\Enum\LoanStatus;
use App\Event\LoanCreatedEvent;
use App\Exception\ClientNotFoundException;
use App\Repository\ClientRepositoryInterface;
use App\Repository\LoanRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

readonly class LoanManager implements LoanManagerInterface
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private LoanRepositoryInterface $loanRepository,
        private LoanRulesEvaluatorInterface $rulesEvaluator,
        private LoanAdjusterInterface $rateAdjuster,
        private EventDispatcherInterface $eventDispatcher
    )
    {
    }

    /** @throws \DateMalformedStringException */
    public function createLoan(LoanRequestDto $dto): Loan
    {
        $client = $this->clientRepository->findOneBy(['email' => $dto->email]);

        if (!$client) {
            throw new ClientNotFoundException("Client not found: {$dto->email}");
        }

        $status = $this->rulesEvaluator->evaluate($client);

        $rate = $dto->rate;
        if ($status === LoanStatus::APPROVED) {
            $rate = $this->rateAdjuster->adjust($dto->rate, $client);
        }

        $loan = new Loan(
            client: $client,
            name: $dto->name,
            amount: $dto->amount,
            rate: $rate,
            status: $status,
            startDate: $dto->startDate,
            endDate: $dto->endDate,
        );

        $this->loanRepository->save($loan);

        $this->eventDispatcher->dispatch(new LoanCreatedEvent($loan));

        return $loan;
    }
}
