<?php

namespace App\Controller;

use App\Service\ClientService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/api/client')]
class ClientController extends AbstractController
{
    public function __construct(
        private ClientService $clientService
    ) {}

    #[Route('', name: 'client.index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $result = $this->clientService->getAll($page, $limit);

        return $this->json([
            'status' => '200',
            'clients' => $result['clients'],
            'total' => $result['total'],
            'page' => $page,
            'limit' => $limit,
            'total_pages' => ceil($result['total'] / $limit)
        ]);
    }

    #[Route('', name: 'client.create', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        return $this->json($this->clientService->create(json_decode($request->getContent(), true)));
    }

    #[Route(path: '/{id}', name: 'client.one', methods: ['GET'])]
    public function getOne(int $id): JsonResponse
    {
        return $this->json($this->clientService->getBy($id));
    }
}