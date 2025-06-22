<?php

namespace App\Service;

use App\Dto\LoanRequestDto;
use App\Entity\Loan;
use App\Enum\LoanStatus;
use App\Event\LoanCreatedEvent;
use App\Repository\ClientRepositoryInterface;
use App\Repository\LoanRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

readonly class LoanManager implements LoanManagerInterface
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        private LoanRepositoryInterface $loanRepository,
        private LoanRulesEvaluatorInterface $rulesEvaluator,
        private LoanAdjusterInterface $rateAdjuster,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    /** @throws \DateMalformedStringException */
    public function createLoan(int $clientId, LoanRequestDto $dto): Loan
    {
        $client = $this->clientRepository->getByIdOrFail($clientId);

        if ($client->getPin() !== $dto->pin) {
            throw new AccessDeniedException('Client PIN does not match.');
        }

        $status = $this->rulesEvaluator->evaluate($client);

        $rate = $dto->rate;
        if (LoanStatus::APPROVED === $status) {
            $rate = $this->rateAdjuster->adjust($dto->rate, $client);
        }

        $loan = new Loan(
            client: $client,
            name: $dto->name,
            amount: $dto->amount,
            rate: $rate,
            startDate: $dto->startDate,
            endDate: $dto->endDate,
            status: $status,
        );

        $this->loanRepository->save($loan);

        $this->eventDispatcher->dispatch(new LoanCreatedEvent($loan));

        return $loan;
    }
}
