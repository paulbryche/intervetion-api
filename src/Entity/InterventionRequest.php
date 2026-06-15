<?php

namespace App\Entity;

use App\Enum\RequestStatus;
use App\Enum\RequestType;
use App\Repository\InterventionRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: InterventionRequestRepository::class)]
class InterventionRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: RequestType::class)]
    private ?RequestType $type = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(type: 'text')]
    private ?string $address = null;

    #[ORM\Column(enumType: RequestStatus::class)]
    private ?RequestStatus $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $closedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $interventionDate = null;

    #[ORM\ManyToOne(inversedBy: 'requestsCreated')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $requester = null;

    #[ORM\ManyToOne(inversedBy: 'requestsManaged')]
    private ?User $assignedAdmin = null;

    #[ORM\ManyToOne(inversedBy: 'requestsAssigned')]
    private ?User $assignedTechnician = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?RequestType
    {
        return $this->type;
    }

    public function setType(RequestType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getStatus(): ?RequestStatus
    {
        return $this->status;
    }

    public function setStatus(RequestStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getClosedAt(): ?\DateTimeImmutable
    {
        return $this->closedAt;
    }

    public function setClosedAt(?\DateTimeImmutable $closedAt): static
    {
        $this->closedAt = $closedAt;

        return $this;
    }

    public function getInterventionDate(): ?\DateTimeImmutable
    {
        return $this->interventionDate;
    }

    public function setInterventionDate(?\DateTimeImmutable $interventionDate): static
    {
        $this->interventionDate = $interventionDate;

        return $this;
    }

    public function getRequester(): ?User
    {
        return $this->requester;
    }

    public function setRequester(?User $requester): static
    {
        $this->requester = $requester;

        return $this;
    }

    public function getAssignedAdmin(): ?User
    {
        return $this->assignedAdmin;
    }

    public function setAssignedAdmin(?User $assignedAdmin): static
    {
        $this->assignedAdmin = $assignedAdmin;

        return $this;
    }

    public function getAssignedTechnician(): ?User
    {
        return $this->assignedTechnician;
    }

    public function setAssignedTechnician(?User $assignedTechnician): static
    {
        $this->assignedTechnician = $assignedTechnician;

        return $this;
    }
}
