<?php

namespace App\Entity;

use App\Entity\Dette;
use App\Entity\DemandeArticle;
use App\Enums\EtatDemandeDette;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\DemandeDetteRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DemandeDetteRepository::class)]
#[ApiResource(
    shortName: "DemandeDette",
    description: "Gestion de la demande de dette d'un client",
    normalizationContext: ['groups' => ['default', 'demande_dette:read']],
    denormalizationContext: ['groups' => ['default', 'demande_dette:create']],
)]
class DemandeDette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(groups: ['demande_dette:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(
        message: "Le montant total ne doit pas être null"
    )]
    #[Assert\Positive(
        message: "Le montant total doit être positif"
    )]
    #[Groups(groups: ['demande_dette:read', 'demande_dette:create'])]
    private ?float $montantTotal = null;

    // Ne sera pas persisté
    #[Groups(groups: ['demande_dette:read'])]
    private EtatDemandeDette $etat = EtatDemandeDette::ENCOURS;

    #[ORM\Column]
    #[Groups(groups: ['demande_dette:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(groups: ['demande_dette:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: DemandeArticle::class, mappedBy: 'demandeDette', orphanRemoval: true)]
    #[Groups(groups: ['demande_dette:read'])]
    private Collection $demandeArticles;

    #[ORM\ManyToOne(inversedBy: 'demandeDettes')]
    #[Assert\NotNull(message: "Le client ne doit pas être null")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\OneToOne(mappedBy: 'demandeDette', cascade: ['persist', 'remove'])]
    #[Groups(groups: ['demande_dette:read'])]
    private ?Dette $dette = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->demandeArticles = new ArrayCollection();
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

    public function getEtat(): ?string
    {
        return $this->etat->name;
    }

    public function setEtat(EtatDemandeDette $etat): static
    {
        $this->etat = $etat;

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
     * @return Collection<int, DemandeArticle>
     */
    public function getDemandeArticles(): Collection
    {
        return $this->demandeArticles;
    }

    public function addDemandeArticle(DemandeArticle $demandeArticle): static
    {
        if (!$this->demandeArticles->contains($demandeArticle)) {
            $this->demandeArticles->add($demandeArticle);
            $demandeArticle->setDemandeDette($this);
        }

        return $this;
    }

    public function removeDemandeArticle(DemandeArticle $demandeArticle): static
    {
        if ($this->demandeArticles->removeElement($demandeArticle)) {
            // set the owning side to null (unless already changed)
            if ($demandeArticle->getDemandeDette() === $this) {
                $demandeArticle->setDemandeDette(null);
            }
        }

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

    public function getDette(): ?Dette
    {
        return $this->dette;
    }

    public function setDette(?Dette $dette): static
    {
        // unset the owning side of the relation if necessary
        if ($dette === null && $this->dette !== null) {
            $this->dette->setDemandeDette(null);
        }

        // set the owning side of the relation if necessary
        if ($dette !== null && $dette->getDemandeDette() !== $this) {
            $dette->setDemandeDette($this);
        }

        $this->dette = $dette;

        return $this;
    }
}
