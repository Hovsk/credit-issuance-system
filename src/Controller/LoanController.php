<?php

namespace App\Controller;

use App\Dto\LoanRequestDto;
use App\Exception\ClientNotFoundException;
use App\Service\LoanManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class LoanController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
        private readonly LoanManagerInterface $loanManager,
        private readonly LoggerInterface $logger,
    ) {
    }

    #[Route('/api/client/{id}/loan', name: 'loan_create', methods: ['POST'])]
    public function create(int $id, Request $request): JsonResponse
    {
        try {
            $dto = $this->serializer->deserialize(
                $request->getContent(),
                LoanRequestDto::class,
                'json',
            );

            $errors = $this->validator->validate($dto);
            if ($errors->count() > 0) {
                return $this->json(['errors' => (string) $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $loan = $this->loanManager->createLoan($id, $dto);

            return $this->json(
                [
                    'id' => $loan->getId(),
                    'name' => $loan->getName(),
                    'amount' => $loan->getAmount(),
                    'rate' => $loan->getRate(),
                    'start_date' => $loan->getStartDate()->format('Y-m-d'),
                    'end_date' => $loan->getEndDate()->format('Y-m-d'),
                    'status' => $loan->getStatus()->value,
                ],
                Response::HTTP_CREATED,
            );
        } catch (NotEncodableValueException) {
            return $this->json(['error' => 'Invalid JSON payload.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (ClientNotFoundException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            $this->logger->error('Internal server error: {message}', ['message' => $e->getMessage()]);

            return $this->json(['error' => 'Internal server error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
