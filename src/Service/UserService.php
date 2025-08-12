<?php

namespace App\Service;

use App\Entity\Review;
use App\Entity\Role;
use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
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

    public function register(Request $request, ValidatorInterface $validator): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            
            if (!$data) {
                return new JsonResponse(['error' => 'Invalid JSON data'], 400);
            }

            // Validate required fields
            $requiredFields = ['email', 'password', 'firstName', 'lastName', 'role'];
            foreach ($requiredFields as $field) {
                if (!isset($data[$field]) || empty(trim($data[$field]))) {
                    return new JsonResponse(['error' => "Field '$field' is required"], 400);
                }
            }

            // Validate email format
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return new JsonResponse(['error' => 'Invalid email format'], 400);
            }

            // Check if user already exists
            $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
            if ($existingUser) {
                return new JsonResponse(['error' => 'User with this email already exists'], 409);
            }

            // Validate password strength
            if (strlen($data['password']) < 8) {
                return new JsonResponse(['error' => 'Password must be at least 8 characters long'], 400);
            }

            // Validate role
            $allowedRoles = ['Student', 'Instructor'];
            if (!in_array($data['role'], $allowedRoles)) {
                return new JsonResponse(['error' => 'Invalid role. Must be Student or Instructor'], 400);
            }

            // Create new user
            $user = new User();
            $user->setEmail($data['email']);
            $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
            $user->setFirstName($data['firstName']);
            $user->setLastName($data['lastName']);
            $user->setCreatedAt(new DateTime());
            $user->setUpdatedAt(new DateTime());

            // Set optional fields
            if (isset($data['userName'])) {
                $user->setUserName($data['userName']);
            }
            if (isset($data['phoneNumber'])) {
                $user->setPhoneNumber($data['phoneNumber']);
            }
            if (isset($data['bio'])) {
                $user->setBio($data['bio']);
            }
            if (isset($data['website'])) {
                $user->setWebsite($data['website']);
            }
            if (isset($data['title'])) {
                $user->setTitle($data['title']);
            }

            // Social media fields
            if (isset($data['facebook'])) {
                $user->setFacebook($data['facebook']);
            }
            if (isset($data['twitter'])) {
                $user->setTwitter($data['twitter']);
            }
            if (isset($data['instagram'])) {
                $user->setInstagram($data['instagram']);
            }
            if (isset($data['linkedin'])) {
                $user->setLinkedin($data['linkedin']);
            }
            if (isset($data['youtube'])) {
                $user->setYoutube($data['youtube']);
            }
            if (isset($data['tiktok'])) {
                $user->setTiktok($data['tiktok']);
            }

            // Assign role
            $role = $this->entityManager->getRepository(Role::class)->findOneBy(['name' => $data['role']]);
            if (!$role) {
                // Create role if it doesn't exist
                $role = new Role();
                $role->setName($data['role']);
                $this->entityManager->persist($role);
            }
            $user->addRole($role);

            // Validate the user entity
            $violations = $validator->validate($user);
            if (count($violations) > 0) {
                $errors = [];
                foreach ($violations as $violation) {
                    $errors[] = $violation->getMessage();
                }
                return new JsonResponse(['errors' => $errors], 400);
            }

            // Save to database
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Return success response with user data (excluding password)
            return new JsonResponse([
                'message' => 'User registered successfully',
                'user' => [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'firstName' => $user->getFirstName(),
                    'lastName' => $user->getLastName(),
                    'fullName' => $user->getFullName(),
                    'roles' => $user->getRoles(),
                    'createdAt' => $user->getCreatedAt()?->format('c')
                ]
            ], 201);

        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Registration failed: ' . $e->getMessage()], 500);
        }
    }

    public function list(): JsonResponse
    {
        $users = $this->userRepository->findAll();
        $data = array_map(fn($user) => [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'fullName' => $user->getFullName(),
            'roles' => $user->getRoles(),
            'createdAt' => $user->getCreatedAt()?->format('c')
        ], $users);

        return new JsonResponse($data);
    }
}
