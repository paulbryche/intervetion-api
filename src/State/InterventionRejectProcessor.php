<?php

namespace App\State;

use App\Entity\InterventionRequest;
use App\Enum\RequestStatus;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;

class InterventionRejectProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function process(mixed $data, \ApiPlatform\Metadata\Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var InterventionRequest $data */

        $data->setStatus(RequestStatus::REJECTED);

        $this->entityManager->flush();

        return $data;
    }
}
