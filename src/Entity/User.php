<?php

namespace App\Entity;

use App\Enum\UserRole;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(enumType: UserRole::class)]
    private ?UserRole $role = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, InterventionRequest>
     */
    #[ORM\OneToMany(targetEntity: InterventionRequest::class, mappedBy: 'requester', orphanRemoval: true)]
    private Collection $requestsCreated;

    /**
     * @var Collection<int, InterventionRequest>
     */
    #[ORM\OneToMany(targetEntity: InterventionRequest::class, mappedBy: 'assignedAdmin')]
    private Collection $requestsManaged;

    /**
     * @var Collection<int, InterventionRequest>
     */
    #[ORM\OneToMany(targetEntity: InterventionRequest::class, mappedBy: 'assignedTechnician')]
    private Collection $requestsAssigned;

    public function __construct()
    {
        $this->requestsCreated = new ArrayCollection();
        $this->requestsManaged = new ArrayCollection();
        $this->requestsAssigned = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRole(): ?UserRole
    {
        return $this->role;
    }

    public function setRole(UserRole $role): static
    {
        $this->role = $role;

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

    /**
     * @return Collection<int, InterventionRequest>
     */
    public function getRequestsCreated(): Collection
    {
        return $this->requestsCreated;
    }

    public function addRequestsCreated(InterventionRequest $requestsCreated): static
    {
        if (!$this->requestsCreated->contains($requestsCreated)) {
            $this->requestsCreated->add($requestsCreated);
            $requestsCreated->setRequester($this);
        }

        return $this;
    }

    public function removeRequestsCreated(InterventionRequest $requestsCreated): static
    {
        if ($this->requestsCreated->removeElement($requestsCreated)) {
            // set the owning side to null (unless already changed)
            if ($requestsCreated->getRequester() === $this) {
                $requestsCreated->setRequester(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InterventionRequest>
     */
    public function getRequestsManaged(): Collection
    {
        return $this->requestsManaged;
    }

    public function addRequestsManaged(InterventionRequest $requestsManaged): static
    {
        if (!$this->requestsManaged->contains($requestsManaged)) {
            $this->requestsManaged->add($requestsManaged);
            $requestsManaged->setAssignedAdmin($this);
        }

        return $this;
    }

    public function removeRequestsManaged(InterventionRequest $requestsManaged): static
    {
        if ($this->requestsManaged->removeElement($requestsManaged)) {
            // set the owning side to null (unless already changed)
            if ($requestsManaged->getAssignedAdmin() === $this) {
                $requestsManaged->setAssignedAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InterventionRequest>
     */
    public function getRequestsAssigned(): Collection
    {
        return $this->requestsAssigned;
    }

    public function addRequestsAssigned(InterventionRequest $requestsAssigned): static
    {
        if (!$this->requestsAssigned->contains($requestsAssigned)) {
            $this->requestsAssigned->add($requestsAssigned);
            $requestsAssigned->setAssignedTechnician($this);
        }

        return $this;
    }

    public function removeRequestsAssigned(InterventionRequest $requestsAssigned): static
    {
        if ($this->requestsAssigned->removeElement($requestsAssigned)) {
            // set the owning side to null (unless already changed)
            if ($requestsAssigned->getAssignedTechnician() === $this) {
                $requestsAssigned->setAssignedTechnician(null);
            }
        }

        return $this;
    }
}
