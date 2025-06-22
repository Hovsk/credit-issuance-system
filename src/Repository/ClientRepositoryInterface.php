<?php

namespace App\Repository;

use App\Entity\Client;

interface ClientRepositoryInterface
{
    public function save(Client $client): void;
}
