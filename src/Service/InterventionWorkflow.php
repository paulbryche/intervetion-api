<?php

namespace App\Service;

namespace App\Service;

use App\Entity\InterventionRequest;
use App\Enum\RequestStatus;
use DomainException;

class InterventionWorkflow
{
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
}
