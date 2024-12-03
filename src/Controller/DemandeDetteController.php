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
    public function index(Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $result = $this->demandeDetteService->getAll($page, $limit);
        return $this->json([
            'status' => '200',
            'demandeDettes' => $result['demandeDettes'],
            'total' => $result['total'],
            'page' => $page,
            'limit' => $limit,
            'total_pages' => ceil($result['total'] / $limit)
        ]);
    }

    #[Route('', name: 'demande_dette.create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        return $this->json($this->demandeDetteService->create(json_decode($request->getContent(), true)));
    }

    #[Route('/update/{id}', name: 'demande_dette.update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        return $this->json($this->demandeDetteService->update($id, json_decode($request->getContent(), true)));
    }

    #[Route(path: '/{id}', name: 'demande_dette.one', methods: ['GET'])]
    public function getOne(int $id): JsonResponse
    {
        return $this->json($this->demandeDetteService->getBy($id));
    }
}
