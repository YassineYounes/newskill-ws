<?php

namespace App\Service;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Review;
use App\Entity\Role;
use App\Entity\Section;
use App\Entity\User;
use App\Repository\CourseRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class InstructorService
{
    public function __construct(private EntityManagerInterface $entityManager, private UserRepository $userRepository)
    {
    }

    public function show(int $id): JsonResponse
    {
        //todo
        return new JsonResponse([]);
    }

    public function listActive(): JsonResponse
    {
        /** @var User[] $instructors */
        $instructors = $this->entityManager->getRepository(User::class)->findInstructorsWithPublishedCourses();
        return $this->mappedInstructorData($instructors);
    }

    public function list()
    {
        /** @var User[] $instructors */
        $instructors = $this->entityManager->getRepository(User::class)->findAll();

        return $this->mappedInstructorData($instructors);
    }

    /**
     * @param array $instructors
     * @return JsonResponse
     */
    public function mappedInstructorData(array $instructors): JsonResponse
    {
        $data = array_map(fn($instructor) => [
            'id' => $instructor->getId(),
            'bio' => $instructor->getBio(),
            'fullName' => $instructor->getFullName(),
            'title' => $instructor->getTitle(),
            'avatar' => $instructor->getAvatar(),
            'teachingCoursesCount' => $instructor->getTeachingCourses()->count(),
            'enrollmentCount' => $instructor->getEnrollmentCount(),
        ], $instructors);
        return new JsonResponse($data);
    }


}
