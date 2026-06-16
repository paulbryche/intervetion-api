<?php

namespace App\Entity;

use App\Enum\UserRole;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']]
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:write'])]
    #[Assert\NotBlank]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:write'])]
    #[Assert\NotBlank]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['user:read', 'user:write'])]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(enumType: UserRole::class)]
    #[Groups(['user:read', 'user:write'])]
    private ?UserRole $role = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'requester', targetEntity: InterventionRequest::class)]
    #[Groups(['user:read'])]
    private Collection $requestsCreated;

    #[ORM\OneToMany(mappedBy: 'assignedAdmin', targetEntity: InterventionRequest::class)]
    #[Groups(['user:read'])]
    private Collection $requestsManaged;

    #[ORM\OneToMany(mappedBy: 'assignedTechnician', targetEntity: InterventionRequest::class)]
    #[Groups(['user:read'])]
    private Collection $requestsAssigned;

    public function __construct()
    {
        $this->requestsCreated = new ArrayCollection();
        $this->requestsManaged = new ArrayCollection();
        $this->requestsAssigned = new ArrayCollection();

        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getFirstname(): ?string { return $this->firstname; }
    public function setFirstname(string $firstname): static { $this->firstname = $firstname; return $this; }

    public function getLastname(): ?string { return $this->lastname; }
    public function setLastname(string $lastname): static { $this->lastname = $lastname; return $this; }

    public function getName(): ?string
    {
        return trim($this->firstname . ' ' . $this->lastname);
    }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }

    public function getRole(): ?UserRole { return $this->role; }
    public function setRole(UserRole $role): static { $this->role = $role; return $this; }

    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }

    public function getRequestsCreated(): Collection { return $this->requestsCreated; }
    public function getRequestsManaged(): Collection { return $this->requestsManaged; }
    public function getRequestsAssigned(): Collection { return $this->requestsAssigned; }
}
