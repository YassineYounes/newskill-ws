<?php

namespace App\Service;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Section;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CourseService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function show(int $id): JsonResponse
    {
        /** @var Course $course */
        $course = $this->entityManager->getRepository(Course::class)->find($id);

        if (!$course) {
            return new JsonResponse(['error' => 'Course not found'], Response::HTTP_NOT_FOUND);
        }
        [$sections, $numberOfLessons, $length] = $this->getSectionsAndLessonsInfos($course);

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
            'created_at' => $course->getCreatedAt()->format('c'),
            'updated_at' => $course->getCreatedAt()->format('c'),
            'instructorName' => $course->getCreatedBy()->getFirstName() . ' ' . $course->getCreatedBy()->getLastName(),
            'instructorId' => $course->getCreatedBy()->getId(),
            'isCertified' => $course->isCertified(),
            'sections' =>  $sections,
            'numberOfLessons' =>  $numberOfLessons,
            'courseLength' =>  $length,
            'rating' =>  $course->getRating(),
        ]);
    }


    /**
     * @param Course $course
     * @return array
     */
    public function getSectionsAndLessonsInfos(Course $course): array
    {
        $sections = [];
        $numberOfLessons = 0;
        $length = 0;
        /** @var Section $section */
        foreach ($course->getSections() as $section) {
            $numberOfLessons += count($section->getLessons());
            /** @var Lesson $lesson */
            $lessons = [];
            $sectionLength = 0;
            foreach ($section->getLessons() as $lesson) {
                $length += $lesson->getVideoLength();
                $sectionLength += $lesson->getVideoLength();
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
                'sectionLength' => $sectionLength,
            ];
        }
        return [$sections, $numberOfLessons, $length];
    }


}
