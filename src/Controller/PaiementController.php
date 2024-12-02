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
    public function index(): JsonResponse
    {
        return $this->json([
            'status' => '200',
            'paiements' => $this->paiementService->getAll(),
        ]);
    }

    #[Route('', name: 'paiement.create', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        return $this->json($this->paiementService->create(json_decode($request->getContent(), true)));
    }
}
