<?php

namespace App\State;

use App\Entity\InterventionRequest;
use App\Enum\RequestStatus;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InterventionAssignTechnicianProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository
    ) {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): InterventionRequest {
        /** @var InterventionRequest $data */

        $techId = $uriVariables['techId'] ?? null;

        if (!$techId) {
            throw new NotFoundHttpException('techId is required');
        }

        $technician = $this->userRepository->find($techId);

        if (!$technician) {
            throw new NotFoundHttpException('Technician not found');
        }

        $data->setAssignedTechnician($technician);
        $data->setStatus(RequestStatus::ASSIGNED);

        $this->entityManager->flush();

        return $data;
    }
}
