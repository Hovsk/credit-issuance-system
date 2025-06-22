<?php

namespace App\Service;

use App\DTO\ClientInputDto;
use App\Entity\Address;
use App\Entity\Client;
use App\Enum\Region;
use App\Exception\ClientAlreadyExistsException;
use App\Repository\ClientRepositoryInterface;

final readonly class ClientManager implements ClientManagerInterface
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {}

    public function create(ClientInputDto $dto): Client
    {
        if ($this->clientRepository->findOneBy(['email' => $dto->email])) {
            throw new ClientAlreadyExistsException();
        }

        $region = Region::tryFrom($dto->region)
            ?? throw new \RuntimeException('Invalid region.');

        $client = new Client(
            pin: $dto->pin,
            name: $dto->name,
            age: $dto->age,
            address: new Address($dto->city, $region),
            income: $dto->income,
            score: $dto->score,
            email: $dto->email,
            phone: $dto->phone,
        );

        $this->clientRepository->save($client);

        return $client;
    }
}
