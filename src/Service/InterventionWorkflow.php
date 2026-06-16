<?php

namespace App\Service;

use App\Entity\InterventionRequest;
use App\Enum\RequestStatus;
use App\Message\InterventionAssignedMessage;
use DomainException;
use Symfony\Component\Messenger\MessageBusInterface;

class InterventionWorkflow
{
    public function __construct(
        private MessageBusInterface $bus,
    ) {}
    public function transition(InterventionRequest $request, RequestStatus $newStatus): void
    {
        $current = $request->getStatus();

        if ($current === $newStatus) {
            return;
        }

        match ($current) {

            RequestStatus::PENDING => $this->fromPending($request, $newStatus),

            RequestStatus::ASSIGNED => $this->fromAssigned($request, $newStatus),

            RequestStatus::CLOSED,
            RequestStatus::REJECTED => throw new DomainException('Cannot change status once closed/rejected'),

        };
    }

    private function fromPending(InterventionRequest $request, RequestStatus $newStatus): void
    {
        if ($newStatus === RequestStatus::ASSIGNED) {
            $request->setStatus(RequestStatus::ASSIGNED);

            $this->bus->dispatch(
                new InterventionAssignedMessage($request->getId())
            );
        }
        match ($newStatus) {
            RequestStatus::ASSIGNED => $request->setStatus(RequestStatus::ASSIGNED),
            RequestStatus::REJECTED => $request->setStatus(RequestStatus::REJECTED),
            RequestStatus::CLOSED => $request->setStatus(RequestStatus::CLOSED),
            default => throw new DomainException('Invalid transition from PENDING'),
        };
    }

    private function fromAssigned(InterventionRequest $request, RequestStatus $newStatus): void
    {
        match ($newStatus) {
            RequestStatus::CLOSED => $request->setStatus(RequestStatus::CLOSED),
            RequestStatus::REJECTED => $request->setStatus(RequestStatus::REJECTED),
            default => throw new DomainException('Invalid transition from ASSIGNED'),
        };
    }

    public function assign($request) : void
    {
        $request->setStatus(RequestStatus::ASSIGNED);
    }

    public function close($request) : void
    {
        $request->setStatus(RequestStatus::CLOSED);
        $request->setClosedAt(new \DateTimeImmutable());
    }

    public function reject($request) : void
    {
        $request->setStatus(RequestStatus::REJECTED);
        $request->setClosedAt(new \DateTimeImmutable());
    }

    public function assignTechnician(InterventionRequest $request): void
    {
        // simple pour l'instant (on complexifiera après)
    }
}
