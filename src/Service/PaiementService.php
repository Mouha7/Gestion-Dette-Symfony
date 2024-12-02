<?php

namespace App\Service;

use App\Entity\Dette;
use App\Entity\Paiement;
use App\Repository\PaiementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaiementService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PaiementRepository $paiementRepository,
        private ValidatorInterface $validator
    ) {}

    public function getAll(): array
    {
        return $this->paiementRepository->findAll();
    }

    public function create(array $data): array
    {
        $paiement = new Paiement();
        $paiement->setMontantPaye($data['montantPaye']);
        if (isset($data['dette'])) {
            $dette = $this->entityManager->getRepository(Dette::class)->find(
                str_replace('/api/dettes/', '', $data['dette'])
            );
            if ($dette) {
                $paiement->setDette($dette);
            } else {
                return [
                    'status' => '404',
                    'message' => 'Dette not found',
                ];
            }
        }

        $errors = $this->validator->validate($paiement);
        if (count($errors) > 0) {
            return [
                'status' => '400',
                'errors' => $errors,
            ];
        }

        $this->entityManager->persist($paiement);
        $this->entityManager->flush();

        return [
            'status' => '201',
            'paiement' => $paiement,
        ];
    }
}
