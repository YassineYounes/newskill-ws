<?php

namespace App\Controller;

use App\Service\InstructorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/instructors', name: 'api_instructors_')]
class InstructorController extends AbstractController
{
    public function __construct(private InstructorService $instructorService)
    {
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return $this->instructorService->list();
    }

    #[Route('/active', name: 'list_active', methods: ['GET'])]
    public function listActive(): JsonResponse
    {
        return $this->instructorService->listActive();
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        return $this->instructorService->show($id);
    }
}

