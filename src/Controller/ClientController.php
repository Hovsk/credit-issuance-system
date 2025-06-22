<?php

namespace App\Controller;

use App\Dto\ClientInputDto;
use App\Exception\ClientAlreadyExistsException;
use App\Service\ClientManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClientController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
        private readonly ClientManagerInterface $clientManager,
        private readonly LoggerInterface $logger,
    ) {
    }

    #[Route('/api/client', name: 'api_client_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        try {
            $dto = $this->serializer->deserialize($request->getContent(), ClientInputDto::class, 'json');

            $errors = $this->validator->validate($dto);
            if (count($errors) > 0) {
                return $this->json(['errors' => (string) $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $client = $this->clientManager->create($dto);

            return $this->json($client->toArray(), Response::HTTP_CREATED);

        } catch (ClientAlreadyExistsException $e) {
            return $this->json(['error' => 'Client already exists.'], Response::HTTP_CONFLICT);
        } catch (\RuntimeException $e) {
            $this->logger->error('Unable to create client: {message}', ['message' => $e->getMessage()]);
            return $this->json(['error' => 'Unable to create client.'], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $e) {
            $this->logger->error('Unhandled exception: {message}', ['message' => $e->getMessage()]);
            return $this->json(['error' => 'Internal server error.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
