<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use App\Enum\RequestStatus;
use App\Enum\RequestType;
use App\Repository\InterventionRequestRepository;
use App\State\InterventionAssignTechnicianProcessor;
use App\State\InterventionCloseProcessor;
use App\State\InterventionRejectProcessor;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: InterventionRequestRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(operations: [

    New Patch(),

    new Delete(),

    new Get(),

    new Post(),

    new Post(
        uriTemplate: '/intervention-requests/{id}/assign',
        processor: InterventionAssignTechnicianProcessor::class
    ),

    new Post(
        uriTemplate: '/intervention-requests/{id}/assign-technician/{techId}',
        processor: InterventionAssignTechnicianProcessor::class
    ),

    new Post(
        uriTemplate: '/intervention-requests/{id}/close',
        processor: InterventionCloseProcessor::class
    ),

    new Post(
        uriTemplate: '/intervention-requests/{id}/reject',
        processor: InterventionRejectProcessor::class
    ),
])]
class InterventionRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['request:read'])]
    private ?int $id = null;

    #[ORM\Column(enumType: RequestType::class)]
    #[Groups(['request:read', 'request:write'])]
    private ?RequestType $type = null;

    #[ORM\Column(type: 'text')]
    #[Groups(['request:read', 'request:write'])]
    private ?string $description = null;

    #[ORM\Column(type: 'text')]
    #[Groups(['request:read', 'request:write'])]
    private ?string $address = null;

    #[ORM\Column(enumType: RequestStatus::class)]
    #[Groups(['request:read'])]
    private RequestStatus $status = RequestStatus::PENDING;

    #[ORM\Column]
    #[Groups(['request:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['request:read'])]
    private ?\DateTimeImmutable $closedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['request:read', 'request:write'])]
    private ?\DateTimeImmutable $interventionDate = null;

    #[ORM\ManyToOne(inversedBy: 'requestsCreated')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['request:read', 'request:write'])]
    private ?User $requester = null;

    #[ORM\ManyToOne(inversedBy: 'requestsManaged')]
    #[Groups(['request:read'])]
    private ?User $assignedAdmin = null;

    #[ORM\ManyToOne(inversedBy: 'requestsAssigned')]
    #[Groups(['request:read'])]
    private ?User $assignedTechnician = null;

    // ======================
    // GETTERS / SETTERS
    // ======================

    public function getId(): ?int { return $this->id; }

    public function getType(): ?RequestType { return $this->type; }
    public function setType(RequestType $type): static { $this->type = $type; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $description): static { $this->description = $description; return $this; }

    public function getAddress(): ?string { return $this->address; }
    public function setAddress(string $address): static { $this->address = $address; return $this; }

    public function getStatus(): RequestStatus { return $this->status; }
    public function setStatus(RequestStatus $status): static { $this->status = $status; return $this; }

    public function getRequester(): ?User { return $this->requester; }
    public function setRequester(?User $requester): static { $this->requester = $requester; return $this; }

    public function getAssignedAdmin(): ?User { return $this->assignedAdmin; }
    public function setAssignedAdmin(?User $admin): static { $this->assignedAdmin = $admin; return $this; }

    public function getAssignedTechnician(): ?User { return $this->assignedTechnician; }
    public function setAssignedTechnician(?User $tech): static { $this->assignedTechnician = $tech; return $this; }

    public function getClosedAt(): ?\DateTimeImmutable { return $this->closedAt; }
    public function setClosedAt(?\DateTimeImmutable $date): static
    {
        $this->closedAt = $date;
        return $this;
    }

    #[ORM\PrePersist]
    public function init(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable();
        }
    }
}
