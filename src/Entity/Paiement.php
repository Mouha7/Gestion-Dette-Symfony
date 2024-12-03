<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\PaiementRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
#[ApiResource(
    shortName: 'Paiement',
    description: 'Gestion des paiements d\'un client',
    normalizationContext: ['groups' => ['paiement:read']],
    denormalizationContext: ['groups' => ['paiement:create']]
)]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(groups: ['paiement:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le montant à payé est obligatoire")]
    #[Assert\Positive(message: "Le montant à payé doit être positif")]
    #[Assert\LessThan(
        value: 1000000, 
        message: "Le montant à payé est trop élevé"
    )]
    #[Groups(groups: ['paiement:read', 'paiement:create'])]
    private ?float $montantPaye = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "La dette ne peut pas être vide")]
    #[Groups(groups: ['paiement:read'])]
    private ?Dette $dette = null;

    #[ORM\Column]
    #[Groups(groups: ['paiement:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(groups: ['paiement:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
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

    public function getMontantPaye(): ?float
    {
        return $this->montantPaye;
    }

    public function setMontantPaye(float $montantPaye): static
    {
        $this->montantPaye = $montantPaye;

        return $this;
    }

    public function getDette(): ?Dette
    {
        return $this->dette;
    }

    public function setDette(?Dette $dette): static
    {
        $this->dette = $dette;

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
}
