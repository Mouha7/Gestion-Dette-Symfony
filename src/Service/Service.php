<?php

namespace App\Service;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Service
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {}

    /**
     * Méthode générique pour récupérer une liste paginée
     * 
     * @template T of object
     * @param EntityRepository<T> $repository
     * @param int $page
     * @param int $limit
     * @param array $criteria
     * @param array $orderBy
     * @return array{items: array, total: int, page: int, limit: int}
     */
    public function findPaginated(
        EntityRepository $repository,
        int $page = 1,
        int $limit = 10,
        array $criteria = [],
        array $orderBy = []
    ): array {
        $offset = ($page - 1) * $limit;

        $items = $repository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );

        $total = $repository->count($criteria);

        return [
            'items' => $items,
            'total' => $total,
            'page' => $page,
            'limit' => $limit
        ];
    }

    /**
     * Méthode générique pour créer une entité
     * 
     * @template T of object
     * @param T $entity
     * @param array $data
     * @param string[] $validationGroups
     * @return array{status: string, entity?: T, errors?: array}
     */
    public function create(
        object $entity,
        array $data,
        array $validationGroups = ['Default']
    ): array {
        // Hydrate l'entité dynamiquement
        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($entity, $setter)) {
                $entity->$setter($value);
            }
        }

        // Validation
        $errors = $this->validator->validate($entity, null, $validationGroups);
        if (count($errors) > 0) {
            return [
                'status' => '400',
                'errors' => $errors,
            ];
        }

        // Persist
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return [
            'status' => '201',
            'entity' => $entity,
        ];
    }

    /**
     * Méthode générique pour mettre à jour une entité
     * 
     * @template T of object
     * @param T $entity
     * @param array $data
     * @param string[] $validationGroups
     * @return array{status: string, entity?: T, errors?: array}
     */
    public function update(
        object $entity,
        array $data,
        array $validationGroups = ['Default']
    ): array {
        // Hydrate l'entité dynamiquement
        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($entity, $setter)) {
                $entity->$setter($value);
            }
        }

        // Validation
        $errors = $this->validator->validate($entity, null, $validationGroups);
        if (count($errors) > 0) {
            return [
                'status' => '400',
                'errors' => $errors,
            ];
        }

        // Flush
        $this->entityManager->flush();

        return [
            'status' => '200',
            'entity' => $entity,
        ];
    }

    /**
     * Méthode générique pour supprimer une entité
     * 
     * @template T of object
     * @param T $entity
     * @return array{status: string}
     */
    public function delete(object $entity): array
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();

        return [
            'status' => '204'
        ];
    }
}
