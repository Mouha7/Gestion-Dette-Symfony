<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $encoder,
        private EntityManagerInterface $entityManager
    ) {}

    public function getAll(): array
    {
        return $this->userRepository->findAll();
    }

    public function create(array $data): array
    {
        $user = new User();
        $user->setEmail($data['email'])
            ->setLogin($data['login'])
            ->setRoles($data['roles']);
        $plaintextPassword = $data['password'];
        $hashedPassword = $this->encoder->hashPassword($user, $plaintextPassword);
        $user->setPassword($hashedPassword);
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return [
                'status' => '400',
                'errors' => $errors,
            ];
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return [
            'status' => '201',
            'user' => $user,
        ];
    }
}
