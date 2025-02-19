<?php

namespace App\Service;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Review;
use App\Entity\Section;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CourseService
{
    public function __construct(private EntityManagerInterface $entityManager, private CourseRepository $courseRepository)
    {
    }

    public function show(int $id): JsonResponse
    {
        /** @var Course $course */
        $course = $this->courseRepository->find($id);

        if (!$course) {
            return new JsonResponse(['error' => 'Course not found'], Response::HTTP_NOT_FOUND);
        }
        $sections = $this->getSectionsAndLessonsInfos($course);
        $reviews = [];
        foreach ($this->entityManager->getRepository(Review::class)->findBy(['course' => $course]) as $review) {
            $reviews[] = [
                'comment' => $review->getComment(),
                'rating' => $review->getRating(),
                'reviewer' => $review->getReviewer()->getFirstName() . ' ' . $review->getReviewer()->getLastName(),
            ];
        }
        return new JsonResponse([
            'title' => $course->getTitle(),
            'description' => $course->getDescription(),
            'shortDescription' => $course->getShortDescription(),
            'price' => $course->getPrice(),
            'skills' => $course->getSkills(),
            'requirements' => $course->getRequirements(),
            'onSale' => $course->isOnSale(),
            'salePercentage' => $course->getSalePercentage(),
            'thumbnail' => $course->getThumbnail(),
            'level' => $course->getLevel()->getTitle(),
            'category' => $course->getCategory()->getName(),
            'createdAt' => $course->getCreatedAt()->format('c'),
            'updatedAt' => $course->getCreatedAt()->format('c'),
            'instructor' => [
                'fullName' => $course->getCreatedBy()->getFullName(),
                'id' => $course->getCreatedBy()->getId(),
                'bio' => $course->getCreatedBy()->getBio(),
            ],
            'instructorId' => $course->getCreatedBy()->getId(),
            'isCertified' => $course->isCertified(),
            'sections' => $sections,
            'numberOfLessons' => $course->getNumberOfLessons(),
            'courseLength' => $course->getCourseLength(),
            'rating' => $course->getRating(),
            'reviews' => $reviews,
            'studentsNumber' => count($course->getStudents()),
        ]);
    }


    /**
     * @param Course $course
     * @return array
     */
    public function getSectionsAndLessonsInfos(Course $course): array
    {
        $sections = [];
        /** @var Section $section */
        foreach ($course->getSections() as $section) {
            /** @var Lesson $lesson */
            $lessons = [];
            foreach ($section->getLessons() as $lesson) {
                $lessons[] = [
                    'title' => $lesson->getTitle(),
                    'content' => $lesson->getContent(),
                    'position' => $lesson->getPosition(),
                    'videoUrl' => $lesson->getVideoUrl(),
                    'canPreview' => $lesson->canPreview(),
                    'videoLength' => $lesson->getVideoLength(),
                ];
            }
            $sections[] = [
                'title' => $section->getTitle(),
                'description' => $section->getDescription(),
                'position' => $section->getPosition(),
                'lessons' => $lessons,
                'sectionLength' => $section->getSectionLength(),
            ];
        }
        return $sections;
    }

    public function list(): JsonResponse
    {
        /** @var Course[] $courses */
        $courses = $this->courseRepository->findAll();
        $data = array_map(fn($course) => [
            'id' => $course->getId(),
            'title' => $course->getTitle(),
            'description' => $course->getDescription(),
            'price' => $course->getPrice(),
            'thumbnail' => $course->getThumbnail(),
            'level' => $course->getLevel()->getTitle(),
            'category' => $course->getCategory()->getName(),
            'createdAt' => $course->getCreatedAt()->format('c'),
            'updatedAt' => $course->getUpdatedAt()->format('c'),
            'rating' => $course->getRating(),
            'numberOfLessons' => $course->getNumberOfLessons(),
            'courseLength' => $course->getCourseLength(),
            'reviewsCount' => count($course->getReviews()),
            'instructor' => [
                'fullName' => $course->getCreatedBy()->getFullName(),
                'id' => $course->getCreatedBy()->getId(),
                'bio' => $course->getCreatedBy()->getBio(),
            ]
        ], $courses);

        return new JsonResponse($data);
    }


}
