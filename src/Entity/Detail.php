<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DetailRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DetailRepository::class)]
#[ApiResource(
    shortName: 'detail',
    description: "Table de détail des articles",
    operations: [
        new Get(
            normalizationContext: ['groups' => ['detail:read']],
            security: "is_granted('ROLE_CLIENT')"
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['detail:read']],
            security: "is_granted('ROLE_CLIENT')"
        ),
        new Post(
            normalizationContext: ['groups' => ['detail:create']],
            denormalizationContext: ['groups' => ['detail:read']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Put(
            normalizationContext: ['groups' => ['detail:update']],
            denormalizationContext: ['groups' => ['detail:read']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')"
        )
    ],
    normalizationContext: ['groups' => ['detail:read']],
    denormalizationContext: ['groups' => ['detail:create']],
    paginationEnabled: false,
)]
class Detail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(groups: ['detail:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Positive(message: "La quantité doit être positif")]
    #[Assert\NotNull(message: "La quantité est obligatoire")]
    #[Assert\GreaterThanOrEqual(
        value: 0, 
        message: "La quantité ne peut pas être négative"
    )]
    #[Groups(groups: ['detail:read', 'detail:create', 'detail:update'])]
    private ?int $qte = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le prix est obligatoire")]
    #[Assert\Positive(message: "Le prix doit être positif")]
    #[Assert\LessThan(
        value: 1000000, 
        message: "Le prix est trop élevé"
    )]
    #[Groups(groups: ['detail:read', 'detail:create'])]
    private ?float $prixVente = null;

    #[ORM\ManyToOne(inversedBy: 'details')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(groups: ['detail:read'])]
    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'details')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(groups: ['detail:read'])]
    private ?Dette $dette = null;

    #[ORM\Column]
    #[Groups(groups: ['detail:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(groups: ['detail:read'])]
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

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): static
    {
        $this->qte = $qte;

        return $this;
    }

    public function getPrixVente(): ?float
    {
        return $this->prixVente;
    }

    public function setPrixVente(float $prixVente): static
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

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
