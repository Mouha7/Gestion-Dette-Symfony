<?php

namespace App\Controller;

use App\Service\DetteService;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/dette')]
class DetteController extends AbstractController
{
    public function __construct(
        private DetteService $detteService
    ) {}

    #[Route('', name: 'dette.index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'status' => '200',
            'dettes' => $this->detteService->getAll()
        ]);
    }

    #[Route('', name: 'dette.create', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        return $this->json($this->detteService->create(json_decode($request->getContent(), true)));
    }

    #[Route('/{id}', name: 'dette.update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        return $this->json($this->detteService->update($id, json_decode($request->getContent(), true)));
    }
}
