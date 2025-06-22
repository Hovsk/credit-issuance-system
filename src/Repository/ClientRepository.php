<?php

namespace App\Repository;

use App\Entity\Client;
use App\Exception\ClientNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository implements ClientRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function getByIdOrFail(int $id): Client
    {
        $client = $this->getEntityManager()->getRepository(Client::class)->find($id);

        if (!$client) {
            throw new ClientNotFoundException(sprintf('Client with id %s not found.', $id));
        }

        return $client;
    }

    public function save(Client $client): void
    {
        $this->getEntityManager()->persist($client);
        $this->getEntityManager()->flush();
    }
}
