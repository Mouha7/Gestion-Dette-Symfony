<?php

namespace App\Entity;

use App\Entity\Detail;
use App\Entity\DemandeArticle;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    shortName: "Article",
    description: "Gestion des articles",
    normalizationContext: ['groups' => ['article:read']],
    denormalizationContext: ['groups' => ['article:create']]
)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(groups: ['article:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le libellé ne peut pas être vide")]
    #[Assert\Length(
        min: 3, 
        max: 255, 
        minMessage: "Le libellé doit faire au moins 3 caractères",
        maxMessage: "Le libellé ne peut pas dépasser 255 caractères"
    )]
    #[Groups(['article:read', 'article:create', 'article:update'])]
    private ?string $libelle = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le prix est obligatoire")]
    #[Assert\Positive(message: "Le prix doit être positif")]
    #[Assert\LessThan(
        value: 1000000, 
        message: "Le prix est trop élevé"
    )]
    #[Groups(['article:read', 'article:create', 'article:update'])]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\Positive(message: "La quantité en stock doit être positif")]
    #[Assert\NotNull(message: "La quantité en stock est obligatoire")]
    #[Assert\GreaterThanOrEqual(
        value: 0, 
        message: "La quantité en stock ne peut pas être négative"
    )]
    #[Groups(['article:read', 'article:create', 'article:update'])]
    private ?int $qteStock = null;

    #[ORM\Column]
    #[Groups(['article:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['article:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: DemandeArticle::class, mappedBy: 'article', orphanRemoval: true)]
    #[Groups(['article:read'])]
    private Collection $demandeArticles;

    #[ORM\OneToMany(targetEntity: Detail::class, mappedBy: 'article', orphanRemoval: true)]
    #[Groups(['article:read'])]
    private Collection $details;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->demandeArticles = new ArrayCollection();
        $this->details = new ArrayCollection();
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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQteStock(): ?int
    {
        return $this->qteStock;
    }

    public function setQteStock(int $qteStock): static
    {
        $this->qteStock = $qteStock;

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
            $demandeArticle->setArticle($this);
        }

        return $this;
    }

    public function removeDemandeArticle(DemandeArticle $demandeArticle): static
    {
        if ($this->demandeArticles->removeElement($demandeArticle)) {
            // set the owning side to null (unless already changed)
            if ($demandeArticle->getArticle() === $this) {
                $demandeArticle->setArticle(null);
            }
        }

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
            $detail->setArticle($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): static
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getArticle() === $this) {
                $detail->setArticle(null);
            }
        }

        return $this;
    }
}
