<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\DemandeArticleRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DemandeArticleRepository::class)]
#[ApiResource(
    shortName: 'DemandeArticle',
    description: "Table d'association entre Demande de Dette et Article",
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['demande_article:read']],
            security: "is_granted('ROLE_CLIENT')"
        ),
        new Get(
            normalizationContext: ['groups' => ['demande_article:read']],
            security: "is_granted('ROLE_CLIENT')"
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Post(
            denormalizationContext: ['groups' => ['demande_article:create']],
            security: "is_granted('ROLE_CLIENT')  || is_granted('ROLE_BOUTIQUIER') || is_granted('ROLE_ADMIN')"
        ),
        new Put(
            denormalizationContext: ['groups' => ['demande_article:update']],
            security: "is_granted('ROLE_ADMIN') || is_granted('ROLE_BOUTIQUIER')"
        )
    ],
    normalizationContext: ['groups' => ['demande_article:read']],
    denormalizationContext: ['groups' => ['demande_article:create']],
    paginationEnabled: false,
    order: ['createdAt' => 'DESC']
)]
class DemandeArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(groups: ['demande_article:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Positive(message: "La quantité d'article doit être positif")]
    #[Assert\NotNull(message: "La quantité d'article ne peut pas être vide")]
    #[Assert\GreaterThanOrEqual(
        value: 0, 
        message: "La quantité d'article ne peut pas être négative"
    )]
    #[Groups(groups: ['demande_article:read', 'demande_article:create'])]
    private ?int $qteArticle = null;

    #[ORM\ManyToOne(inversedBy: 'demandeArticles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "L'article ne doit pas être null")]
    #[Groups(groups: ['demande_article:read', 'demande_article:create'])]
    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'demandeArticles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "La demande de dette ne doit pas être null")]
    #[Groups(groups: ['demande_article:read', 'demande_article:create'])]
    private ?DemandeDette $demandeDette = null;

    #[ORM\Column]
    #[Groups(groups: ['demande_article:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(groups: ['demande_article:read'])]
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

    public function getQteArticle(): ?int
    {
        return $this->qteArticle;
    }

    public function setQteArticle(int $qteArticle): static
    {
        $this->qteArticle = $qteArticle;

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

    public function getDemandeDette(): ?DemandeDette
    {
        return $this->demandeDette;
    }

    public function setDemandeDette(?DemandeDette $demandeDette): static
    {
        $this->demandeDette = $demandeDette;

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
