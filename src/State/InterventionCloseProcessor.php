<?php

namespace App\State;

use App\Entity\InterventionRequest;
use App\Enum\RequestStatus;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;

class InterventionCloseProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function process(mixed $data, \ApiPlatform\Metadata\Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var InterventionRequest $data */

        $data->setStatus(RequestStatus::CLOSED);
        $data->setClosedAt(new \DateTimeImmutable());

        $this->entityManager->flush();

        return $data;
    }
}
