<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/user')]
class UserController extends AbstractController
{
    public function __construct(
        private UserService $userService
    ) {}

    #[Route('', name: 'user.index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'status' => '200',
            'users' => $this->userService->getAll()
        ]);
    }

    #[Route('', name: 'user.create', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        return $this->json($this->userService->create(json_decode($request->getContent(), true)));
    }
}
