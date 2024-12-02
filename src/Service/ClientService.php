<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClientService
{
    public function __construct(
        private ClientRepository $clientRepository,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager
    ) {}

    public function getAll(): array
    {
        return $this->clientRepository->findAll();
    }

    public function create(array $data): array
    {
        $client = new Client();
        $client->setSurname($data['surname'])
            ->setTel($data['tel'])
            ->setAddress($data['address']);
        if (isset($data['user'])) {
            // Récupérer l'utilisateur depuis le repository
            $user = $this->entityManager->getRepository(User::class)->find(
                str_replace('/api/users/', '', $data['user'])
            );
            if ($user) {
                $client->setUser($user);
            } else {
                return [
                    'status' => '404',
                    'message' => 'User non trouvé',
                ];
            }
        }
        $errors = $this->validator->validate($client);
        if (count($errors) > 0) {
            return [
                'status' => '400',
                'errors' => $errors,
            ];
        }

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return [
            'status' => '201',
            'client' => $client,
        ];
    }
}
