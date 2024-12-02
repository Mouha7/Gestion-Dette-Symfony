<?php

namespace App\Service;

use App\Entity\Dette;
use App\Entity\Client;
use App\Entity\DemandeDette;
use App\Repository\DetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DetteService
{
    public function __construct(
        private DetteRepository $detteRepository,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager
    ) {}

    public function getAll(int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;

        $dettes = $this->detteRepository->findBy(
            [],
            [],
            $limit,
            $offset
        );

        $total = $this->detteRepository->count([]);

        return [
            'dettes' => $dettes,
            'total' => $total
        ];
    }

    public function create(array $data): array
    {
        $dette = new Dette();
        $dette->setMontantTotal($data['montantTotal'])
            ->setMontantVerser($data['montantVerser']);
        if (isset($data['client'])) {
            $client = $this->entityManager->getRepository(Client::class)->find(
                str_replace('/api/clients/', '', $data['client'])
            );
            if ($client) {
                $dette->setClient($client);
            } else {
                return [
                    'status' => '404',
                    'message' => 'Client non trouvé',
                ];
            }
        }
        if (isset($data['demandeDette'])) {
            $demandeDette = $this->entityManager->getRepository(DemandeDette::class)->find(
                str_replace('/api/demande_dettes/', '', $data['demandeDette'])
            );
            if ($demandeDette) {
                $dette->setDemandeDette($demandeDette);
            } else {
                return [
                    'status' => '404',
                    'message' => 'Demande Dette non trouvée',
                ];
            }
        }
        $errors = $this->validator->validate($dette);
        if (count($errors) > 0) {
            return [
                'status' => '400',
                'errors' => $errors,
            ];
        }

        $this->entityManager->persist($dette);
        $this->entityManager->flush();

        return [
            'status' => '201',
            'dette' => $dette,
        ];
    }

    public function update(int $id, array $data): mixed
    {
        $dette = $this->detteRepository->find($id);
        if (!$dette) {
            return [
                'status' => '404',
                'error' => 'Dette not found',
            ];
        }
        if (isset($data['montantTotal'])) {
            $dette->setMontantTotal($data['montantTotal']);
        }
        if (isset($data['montantVerser'])) {
            $dette->setMontantVerser($data['montantVerser']);
        }
        if (isset($data['status'])) {
            $dette->setStatus($data['status']);
        }
        if (isset($data['client'])) {
            $client = $this->entityManager->getRepository(Client::class)->find(
                str_replace('/api/clients/', '', $data['client'])
            );
            if ($client) {
                $dette->setClient($client);
            }
        }
        if (isset($data['demandeDette'])) {
            $demandeDette = $this->entityManager->getRepository(DemandeDette::class)->find(
                str_replace('/api/demande_dettes/', '', $data['demandeDette'])
            );
            if ($demandeDette) {
                $dette->setDemandeDette($demandeDette);
            }
        }
        $errors = $this->validator->validate($dette);
        if (count($errors) > 0) {
            return [
                'status' => '400',
                'errors' => $errors,
            ];
        }
        $this->entityManager->persist($dette);
        $this->entityManager->flush();
        return [
            'status' => '200',
            'dette' => $dette,
        ];
    }
}
