<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    shortName: "Client",
    description: "Gestion des clients",
    operations: [
        new Get(
            normalizationContext: ['groups' => ['client:read']],
            security: "is_granted('ROLE_CLIENT')"
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['client:read']],
            security: "is_granted('ROLE_CLIENT')"
        ),
        new Post(
            normalizationContext: ['groups' => ['client:create']],
            denormalizationContext: ['groups' => ['client:create']],
            security: "is_granted('ROLE_ADMIN') || is_granted('ROLE_BOUTIQUIER')"
        ),
        new Put(
            normalizationContext: ['groups' => ['client:update']],
            denormalizationContext: ['groups' => ['client:update']],
            security: "is_granted('ROLE_ADMIN') || is_granted('ROLE_BOUTIQUIER')"
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN') || is_granted('ROLE_BOUTIQUIER')"
        ),
    ],
    normalizationContext: ['groups' => ['client:read']],
    denormalizationContext: ['groups' => ['client:create']],
    paginationEnabled: true,
    paginationItemsPerPage: 10,
    order: ['createdAt' => 'DESC']
)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['client:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(message: "Le surname ne peut pas être vide")]
    #[Assert\Length(
        min: 3, 
        max: 255, 
        minMessage: "Le surname doit faire au moins 3 caractères",
        maxMessage: "Le surname ne peut pas dépasser 255 caractères"
    )]
    #[Groups(['client:read'])]
    private ?string $surname = null;

    #[ORM\Column(length: 20)]
    #[Assert\Regex(
        pattern: '/^[0-9]{9}$/', 
        message: "Le numéro de téléphone doit être de 10 chiffres"
    )]
    #[Assert\NotBlank(message: "Le numéro de téléphone doit pas être vide")]
    #[Groups(['client:read'])]
    private ?string $tel = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 10, 
        max: 255, 
        minMessage: "L'adresse doit faire au moins 10 caractères",
        maxMessage: "L'adresse ne peut pas dépasser 255 caractères"
    )]
    #[Groups(['client:read'])]
    private ?string $address = null;

    #[ORM\Column(nullable: true)]
    private ?float $cumulMontantDu = 0;

    #[ORM\Column]
    #[Groups(['client:read', 'client:update'])]
    private ?bool $status = null;

    #[ORM\OneToMany(targetEntity: Dette::class, mappedBy: 'client', orphanRemoval: true)]
    #[Groups(['client:read'])]
    private Collection $dettes;

    #[ORM\Column]
    #[Groups(['client:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['client:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, DemandeDette>
     */
    #[ORM\OneToMany(targetEntity: DemandeDette::class, mappedBy: 'client', orphanRemoval: true)]
    #[Groups(['client:read'])]
    private Collection $demandeDettes;

    #[ORM\OneToOne(inversedBy: 'client', cascade: ['persist', 'remove'])]
    #[Groups(['client:read', 'client:create', 'client:update'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->dettes = new ArrayCollection();
        $this->status = true;
        $this->demandeDettes = new ArrayCollection();
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    // Méthode séparée pour mettre à jour le cumul
    public function updateCumulMontantDu(): void
    {
        $newCumul = 0.0;
        if ($this->dettes != null) {
            foreach ($this->dettes as $dette) {
                $newCumul += $dette->getMontantRestant();
            }
        }
        $this->cumulMontantDu = $newCumul;
    }

    public function getCumulMontantDu(): ?float
    {
        return $this->cumulMontantDu;
    }

    public function setCumulMontantDu(?float $cumulMontantDu): static
    {
        $this->cumulMontantDu = $cumulMontantDu;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Dette>
     */
    public function getDettes(): Collection
    {
        return $this->dettes;
    }

    public function addDette(Dette $dette): static
    {
        if (!$this->dettes->contains($dette)) {
            $this->dettes->add($dette);
            $dette->setClient($this);
            $this->updateCumulMontantDu();
        }

        return $this;
    }

    public function removeDette(Dette $dette): static
    {
        if ($this->dettes->removeElement($dette)) {
            // set the owning side to null (unless already changed)
            if ($dette->getClient() === $this) {
                $dette->setClient(null);
            }
        }

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, DemandeDette>
     */
    public function getDemandeDettes(): Collection
    {
        return $this->demandeDettes;
    }

    public function addDemandeDette(DemandeDette $demandeDette): static
    {
        if (!$this->demandeDettes->contains($demandeDette)) {
            $this->demandeDettes->add($demandeDette);
            $demandeDette->setClient($this);
        }

        return $this;
    }

    public function removeDemandeDette(DemandeDette $demandeDette): static
    {
        if ($this->demandeDettes->removeElement($demandeDette)) {
            // set the owning side to null (unless already changed)
            if ($demandeDette->getClient() === $this) {
                $demandeDette->setClient(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
