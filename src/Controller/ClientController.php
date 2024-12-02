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
    public function index(): JsonResponse
    {
        return $this->json([
            'status' => '200',
            'clients' => $this->clientService->getAll()
        ]);
    }

    #[Route('', name: 'client.create', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        return $this->json($this->clientService->create(json_decode($request->getContent(), true)));
    }
}
