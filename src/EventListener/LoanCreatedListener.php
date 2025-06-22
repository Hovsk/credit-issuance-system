<?php

namespace App\EventListener;

use App\Enum\LoanStatus;
use App\Event\LoanCreatedEvent;
use Psr\Log\LoggerInterface;

readonly class LoanCreatedListener
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(LoanCreatedEvent $event): void
    {
        $loan = $event->loan;
        $clientName = $loan->getClient()->getName();
        $status = $loan->getStatus();

        $message = sprintf(
            '[%s] Уведомление клиенту %s: Кредит %s.',
            (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            $clientName,
            LoanStatus::APPROVED === $status ? 'одобрен' : 'отклонен'
        );

        $this->logger->info($message);
    }
}
