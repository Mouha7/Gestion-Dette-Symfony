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
    public function index(Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $result = $this->userService->getAll($page, $limit);
        
        return $this->json([
            'status' => '200',
            'users' => $result['users'],
            'total' => $result['total'],
            'page' => $page,
            'limit' => $limit,
            'total_pages' => ceil($result['total'] / $limit)
        ]);
    }

    #[Route('', name: 'user.create', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        return $this->json($this->userService->create(json_decode($request->getContent(), true)));
    }

    #[Route(path: '/{id}', name: 'user.one', methods: ['GET'])]
    public function getOne(int $id): JsonResponse
    {
        return $this->json($this->userService->getBy(["id" => $id]));
    }

    #[Route(path: '/info/{email}', name: 'user.info', methods: ['GET'])]
    public function info(string $email): JsonResponse
    {
        $user = $this->userService->getBy(["email" => $email]);
        return $this->json([
            'roles' => $user->getRoles(),
            'surname' => $user->getLogin()
        ]);
    }
}
