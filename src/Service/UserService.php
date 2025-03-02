<?php

namespace App\Service;

use App\Entity\Review;
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
        $reviews = [];
        foreach ($this->entityManager->getRepository(Review::class)->findBy(['instructor' => $user]) as $review) {
            $reviews[] = [
                'comment' => $review->getComment(),
                'rating' => $review->getRating(),
                'reviewer' => $review->getReviewer()->getFirstName() . ' ' . $review->getReviewer()->getLastName(),
            ];
        }
        return new JsonResponse([
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'id' => $user->getId(),
            'bio' => $user->getBio(),
            'avatar' => $user->getAvatar(),
            'title' => $user->getTitle(),
            'abv' => $user->getAbv(),
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
            'reviews' => $reviews,
            'rating' => $user->getRating(),
            'teachingCoursesCount' => $user->getTeachingCoursesCount(),
            'teachingLessonsCount' => $user->getTeachingLessonsCount(),
            'enrollmentCount' => $user->getEnrollmentCount(),
        ]);
    }

    public function listActive(): JsonResponse
    {
        /** @var User[] $instructors */
        $instructors = $this->entityManager->getRepository(User::class)->findInstructorsWithPublishedCourses();
        $data = array_map(fn($instructor) => [
            'id' => $instructor->getId(),
            'bio' => $instructor->getBio(),
            'abv' => $instructor->getAbv(),
            'fullName' => $instructor->getFullName(),
            'avatar' => $instructor->getAvatar(),
            'coursesCount' => $instructor->getTeachingCourses()->count(),
        ], $instructors);

        return new JsonResponse($data);
    }


}
