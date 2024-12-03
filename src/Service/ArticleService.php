<?php

namespace App\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ArticleService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ArticleRepository $articleRepository,
        private ValidatorInterface $validator
    ) {}

    public function getAll(int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;

        $articles = $this->articleRepository->findBy(
            [],
            [],
            $limit,
            $offset
        );

        $total = $this->articleRepository->count([]);

        return [
            'articles' => $articles,
            'total' => $total
        ];
    }

    public function create(array $data): array
    {
        $article = new Article();
        $article->setLibelle($data['libelle'])
            ->setPrix($data['prix'])
            ->setQteStock($data['qteStock']);

        $errors = $this->validator->validate($article);
        if (count($errors) > 0) {
            return [
                'status' => '400',
                'errors' => $errors,
            ];
        }

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return [
            'status' => '201',
            'article' => $article,
        ];
    }

    public function getAllAvailable(): array
    {
        return $this->articleRepository->findAllAvailable();
    }

    public function getBy(int $id)
    {
        return $this->articleRepository->findOneBy(["id" => $id]);
    }
}
