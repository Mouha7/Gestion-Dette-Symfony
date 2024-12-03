<?php

namespace App\Controller;

use App\Service\PaiementService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/paiement')]
class PaiementController extends AbstractController
{
    public function __construct(
        private PaiementService $paiementService
    ) {}

    #[Route('', name: 'paiement.index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $result = $this->paiementService->getAll($page, $limit);

        return $this->json([
            'status' => '200',
            'paiements' => $result['paiements'],
            'total' => $result['total'],
            'page' => $page,
            'limit' => $limit,
            'total_pages' => ceil(num: $result['total'] / $limit)
        ]);
    }

    #[Route('', name: 'paiement.create', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        return $this->json($this->paiementService->create(json_decode($request->getContent(), true)));
    }

    #[Route(path: '/{id}', name: 'paiement.one', methods: ['GET'])]
    public function getOne(int $id): JsonResponse
    {
        return $this->json($this->paiementService->getBy($id));
    }
}
