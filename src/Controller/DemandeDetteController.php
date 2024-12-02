<?php

namespace App\Controller;

use App\Service\DemandeDetteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/demande/dette')]
class DemandeDetteController extends AbstractController
{
    public function __construct(
        private DemandeDetteService $demandeDetteService
    ) {}

    #[Route('', name: 'demande_dette.index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'status' => '200',
            'demandeDettes' => $this->demandeDetteService->getAll()
        ]);
    }

    #[Route('', name: 'demande_dette.create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        return $this->json($this->demandeDetteService->create(json_decode($request->getContent(), true)));
    }

    #[Route('/{id}', name: 'demande_dette.update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        return $this->json($this->demandeDetteService->update($id, json_decode($request->getContent(), true)));
    }
}
