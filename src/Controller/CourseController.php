<?php

namespace App\Controller;

use App\Entity\Course;
use App\Repository\CourseRepository;
use App\Repository\LevelRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/api/courses', name: 'api_courses_')]
class CourseController extends AbstractController
{
//    #[Route('', name: 'list', methods: ['GET'])]
//    public function list(CourseRepository $courseRepository): JsonResponse
//    {
//        $courses = $courseRepository->findAll();
//        $data = array_map(fn($course) => [
//            'id' => $course->getId(),
//            'title' => $course->getTitle(),
//            'description' => $course->getDescription(),
//            'price' => $course->getPrice(),
//            'thumbnail' => $course->getThumbnail(),
//            'level' => $course->getLevel()->getName(),
//            'created_at' => $course->getCreatedAt()->format('Y-m-d H:i:s'),
//        ], $courses);
//
//        return $this->json($data);
//    }
//
//    #[Route('/{id}', name: 'show', methods: ['GET'])]
//    public function show(int $id, CourseRepository $courseRepository): JsonResponse
//    {
//        $course = $courseRepository->find($id);
//
//        if (!$course) {
//            return $this->json(['error' => 'Course not found'], Response::HTTP_NOT_FOUND);
//        }
//
//        return $this->json([
//            'id' => $course->getId(),
//            'title' => $course->getTitle(),
//            'description' => $course->getDescription(),
//            'price' => $course->getPrice(),
//            'thumbnail' => $course->getThumbnail(),
//            'level' => $course->getLevel()->getName(),
//            'created_at' => $course->getCreatedAt()->format('Y-m-d H:i:s'),
//        ]);
//    }
//
//    #[Route('', name: 'create', methods: ['POST'])]
//    public function create(Request $request, EntityManagerInterface $entityManager, LevelRepository $levelRepository): JsonResponse
//    {
//        $data = $request->request->all();
//        $file = $request->files->get('thumbnail');
//
//        // Validate required fields
//        if (!isset($data['title'], $data['description'], $data['price'], $data['level_id'])) {
//            return $this->json(['error' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
//        }
//
//        // Find Level entity
//        $level = $levelRepository->find($data['level_id']);
//        if (!$level) {
//            return $this->json(['error' => 'Invalid level ID'], Response::HTTP_BAD_REQUEST);
//        }
//
//        // Handle file upload (if exists)
//        $thumbnailPath = null;
//        if ($file instanceof UploadedFile) {
//            $uploadsDir = $this->getParameter('kernel.project_dir') . '/public/uploads/courses';
//            $newFilename = uniqid() . '.' . $file->guessExtension();
//
//            try {
//                $file->move($uploadsDir, $newFilename);
//                $thumbnailPath = '/uploads/courses/' . $newFilename;
//            } catch (FileException $e) {
//                return $this->json(['error' => 'Failed to upload thumbnail'], Response::HTTP_INTERNAL_SERVER_ERROR);
//            }
//        }
//
//        $course = new Course();
//        $course->setTitle($data['title']);
//        $course->setDescription($data['description']);
//        $course->setPrice((float) $data['price']);
//        $course->setThumbnail($thumbnailPath);
//        $course->setLevel($level);
//        $course->setCreatedAt(new DateTime());
//        $course->setUpdatedAt(new DateTime());
//
//        $entityManager->persist($course);
//        $entityManager->flush();
//
//        return $this->json(['message' => 'Course created successfully', 'id' => $course->getId()], Response::HTTP_CREATED);
//    }
//
//    #[Route('/{id}', name: 'update', methods: ['PUT', 'PATCH'])]
//    public function update(int $id, Request $request, CourseRepository $courseRepository, LevelRepository $levelRepository, EntityManagerInterface $entityManager): JsonResponse
//    {
//        $course = $courseRepository->find($id);
//        if (!$course) {
//            return $this->json(['error' => 'Course not found'], Response::HTTP_NOT_FOUND);
//        }
//
//        $data = $request->request->all();
//        $file = $request->files->get('thumbnail');
//        if (isset($data['title'])) {
//            $course->setTitle($data['title']);
//        }
//        if (isset($data['description'])) {
//            $course->setDescription($data['description']);
//        }
//        if (isset($data['price'])) {
//            $course->setPrice((float) $data['price']);
//        }
//        if (isset($data['level_id'])) {
//            $level = $levelRepository->find($data['level_id']);
//            if (!$level) {
//                return $this->json(['error' => 'Invalid level ID'], Response::HTTP_BAD_REQUEST);
//            }
//            $course->setLevel($level);
//        }
//        if ($file instanceof UploadedFile) {
//            $uploadsDir = $this->getParameter('kernel.project_dir') . '/public/uploads/courses';
//            $newFilename = uniqid() . '.' . $file->guessExtension();
//
//            try {
//                $file->move($uploadsDir, $newFilename);
//                $course->setThumbnail('/uploads/courses/' . $newFilename);
//            } catch (FileException $e) {
//                return $this->json(['error' => 'Failed to upload thumbnail'], Response::HTTP_INTERNAL_SERVER_ERROR);
//            }
//        }
//        $course->setUpdatedAt(new DateTime());
//        $entityManager->flush();
//
//        return $this->json(['message' => 'Course updated successfully']);
//    }
//
//    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
//    public function delete(int $id, CourseRepository $courseRepository, EntityManagerInterface $entityManager): JsonResponse
//    {
//        $course = $courseRepository->find($id);
//        if (!$course) {
//            return $this->json(['error' => 'Course not found'], Response::HTTP_NOT_FOUND);
//        }
//
//        $entityManager->remove($course);
//        $entityManager->flush();
//
//        return $this->json(['message' => 'Course deleted successfully']);
//    }
}

