<?php

namespace App\Service;

use App\Dto\ClientInputDto;
use App\Entity\Client;

interface ClientManagerInterface
{
    public function create(ClientInputDto $dto): Client;
}
