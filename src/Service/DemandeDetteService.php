<?php

namespace App\Service;

use App\Entity\Dette;
use App\Entity\Client;
use App\Entity\DemandeDette;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DemandeDetteRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DemandeDetteService
{
    public function __construct(
        private DemandeDetteRepository $demandeDetteRepository,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager
    ) {}

    public function getAll(int $page = 1, int $limit = 10): array
    {
        $offset = ($page - 1) * $limit;

        $demandesDettes = $this->demandeDetteRepository->findBy(
            [],
            [],
            $limit,
            $offset
        );

        $total = $this->demandeDetteRepository->count([]);

        return [
            'demandesDettes' => $demandesDettes,
            'total' => $total
        ];
    }

    public function create(array $data): array
    {
        $demandeDette = new DemandeDette();
        $demandeDette->setMontantTotal($data['montantTotal']);

        if (isset($data['client'])) {
            $client = $this->entityManager->getRepository(Client::class)->find(
                str_replace('/api/clients/', '', $data['client'])
            );
            if ($client) {
                $demandeDette->setClient($client);
            } else {
                return [
                    'status' => '404',
                    'message' => 'Client non trouvé',
                ];
            }
        }
        if (isset($data['dette'])) {
            $dette = $this->entityManager->getRepository(Dette::class)->find(
                str_replace('/api/dettes/', '', $data['dette'])
            );
            if ($dette) {
                $demandeDette->setDette($dette);
            } else {
                return [
                    'status' => '404',
                    'message' => 'Dette non trouvée',
                ];
            }
        }
        $errors = $this->validator->validate($demandeDette);
        if (count($errors) > 0) {
            return [
                'status' => '400',
                'errors' => $errors,
            ];
        }
        $this->entityManager->persist($demandeDette);
        $this->entityManager->flush();

        return [
            'status' => '201',
            'demandeDette' => $demandeDette,
        ];
    }

    public function update(int $id, array $data): mixed
    {
        $demandeDette = $this->demandeDetteRepository->find($id);
        if (!$demandeDette) {
            return [
                'status' => '404',
                'error' => 'Dette not found',
            ];
        }
        if (isset($data['montantTotal'])) {
            $demandeDette->setMontantTotal($data['montantTotal']);
        }
        if (isset($data['etat'])) {
            $demandeDette->setEtat($data['etat']);
        }
        if (isset($data['client'])) {
            $client = $this->entityManager->getRepository(Client::class)->find(
                str_replace('/api/clients/', '', $data['client'])
            );
            if ($client) {
                $demandeDette->setClient($client);
            } else {
                return [
                    'status' => '404',
                    'message' => 'Client non trouvée',
                ];
            }
        }
        if (isset($data['dette'])) {
            $dette = $this->entityManager->getRepository(Dette::class)->find(
                str_replace('/api/dettes/', '', $data['dette'])
            );
            if ($dette) {
                $demandeDette->setDette($dette);
            } else {
                return [
                    'status' => '404',
                    'message' => 'Dette non trouvé',
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
        $this->entityManager->persist($demandeDette);
        $this->entityManager->flush();
        return [
            'status' => '200',
            'demandeDette' => $demandeDette,
        ];
    }

    public function getBy(int $id)
    {
        return $this->demandeDetteRepository->findOneBy(["id" => $id]);
    }
}
