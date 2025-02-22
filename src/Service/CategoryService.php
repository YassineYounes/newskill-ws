<?php

namespace App\Service;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function show(int $id): JsonResponse
    {
        //todo
        return new JsonResponse([]);
    }

    public function list(): JsonResponse
    {
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        $data = array_map(fn($category) => [
            'id' => $category->getId(),
            'name' => $category->getName(),
            'coursesCount' => $category->getCourses()->count(),
        ], $categories);
        return new JsonResponse($data);
    }


}
