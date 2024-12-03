<?php

namespace App\Entity;

use App\Entity\Detail;
use App\Entity\Paiement;
use App\Enums\EtatDette;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DetteRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DetteRepository::class)]
#[ApiResource(
    shortName: "Dette",
    description: "Gestion de dette d'un client",
    normalizationContext: ['groups' => ['dette:read']],
    denormalizationContext: ['groups' => ['dette:create']]
)]
class Dette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(groups: ['dette:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le montant est obligatoire")]
    #[Assert\Positive(message: "Le montant doit être positif")]
    #[Assert\LessThan(
        value: 1000000, 
        message: "Le montant est trop élevé"
    )]
    #[Groups(groups: ['dette:create', 'dette:read'])]
    private ?float $montantTotal = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le montant est obligatoire")]
    #[Assert\Positive(message: "Le montant doit être positif")]
    #[Assert\LessThan(
        value: 1000000, 
        message: "Le montant est trop élevé"
    )]
    #[Groups(groups: ['dette:read'])]
    private ?float $montantVerser = null;

    #[ORM\Column]
    #[Groups(groups: ['dette:read'])]
    private ?bool $status = null;

    #[Groups(groups: ['dette:read'])]
    private EtatDette $etat = EtatDette::ENCOURS;

    #[ORM\ManyToOne(inversedBy: 'dettes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Le client ne peut pas être vide")]
    #[Groups(groups: ['dette:read'])]
    private ?Client $client = null;

    #[ORM\OneToMany(targetEntity: Detail::class, mappedBy: 'dette', orphanRemoval: true)]
    #[Groups(groups: ['dette:read'])]
    private Collection $details;

    #[ORM\Column]
    #[Groups(groups: ['dette:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(groups: ['dette:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: Paiement::class, mappedBy: 'dette', orphanRemoval: true)]
    #[Groups(groups: ['dette:read'])]
    private Collection $paiements;

    #[ORM\OneToOne(inversedBy: 'dette', cascade: ['persist', 'remove'])]
    #[Groups(groups: ['dette:read'])]
    private ?DemandeDette $demandeDette = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->details = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->status = true;
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

    public function getMontantTotal(): ?float
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(float $montantTotal): static
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getMontantVerser(): ?float
    {
        return $this->montantVerser;
    }

    public function setMontantVerser(float $montantVerser): static
    {
        $this->montantVerser = $montantVerser;

        return $this;
    }

    public function getMontantRestant(): float 
    {
        return $this->montantTotal - $this->montantVerser;
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

    public function getEtat(): EtatDette
    {
        return $this->etat;
    }

    public function setEtat(EtatDette $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(Detail $detail): static
    {
        if (!$this->details->contains($detail)) {
            $this->details->add($detail);
            $detail->setDette($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): static
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getDette() === $this) {
                $detail->setDette(null);
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
     * @return Collection<int, Paiement>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): static
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setDette($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): static
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getDette() === $this) {
                $paiement->setDette(null);
            }
        }

        return $this;
    }

    public function getDemandeDette(): ?DemandeDette
    {
        return $this->demandeDette;
    }

    public function setDemandeDette(?DemandeDette $demandeDette): static
    {
        $this->demandeDette = $demandeDette;

        return $this;
    }
}
