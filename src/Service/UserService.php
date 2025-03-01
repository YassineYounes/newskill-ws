<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserService
{
    public function __construct(private EntityManagerInterface $entityManager, private UserRepository $userRepository)
    {
    }

    public function show(User $user): JsonResponse
    {
        return new JsonResponse([
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'id' => $user->getId(),
            'bio' => $user->getBio(),
            'avatar' => $user->getAvatar(),
            'title' => $user->getTitle(),
            'fullName' => $user->getFullName(),
            'createdAt' => $user->getCreatedAt()?->format('c'),
            'updatedAt' => $user->getCreatedAt()?->format('c'),
            'instagram' => $user->getInstagram(),
            'facebook' => $user->getFacebook(),
            'twitter' => $user->getTwitter(),
            'tiktok' => $user->getTiktok(),
            'youtube' => $user->getYoutube(),
            'website' => $user->getWebsite(),
            'linkedin' => $user->getLinkedin(),
        ]);
    }

    public function listActive(): JsonResponse
    {
        /** @var User[] $instructors */
        $instructors = $this->entityManager->getRepository(User::class)->findInstructorsWithPublishedCourses();
        $data = array_map(fn($instructor) => [
            'id' => $instructor->getId(),
            'bio' => $instructor->getBio(),
            'fullName' => $instructor->getFullName(),
            'avatar' => $instructor->getAvatar(),
            'coursesCount' => $instructor->getTeachingCourses()->count(),
        ], $instructors);

        return new JsonResponse($data);
    }


}
