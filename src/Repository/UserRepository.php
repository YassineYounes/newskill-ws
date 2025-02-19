<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findInstructors(): array
    {
        return $this->createQueryBuilder('u')
            ->join('u.roles', 'r')
            ->where('r.name = :roleName')
            ->setParameter('roleName', 'Instructor')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all users with the role 'Instructor' who have at least one published course.
     *
     * @return User[]
     */
    public function findInstructorsWithPublishedCourses(): array
    {
        return $this->createQueryBuilder('u')
            ->join('u.roles', 'r')  // Join roles table
            ->join('u.courses', 'c')  // Join courses table
            ->where('r.name = :roleName')
            ->andWhere('c.isPublished = :published')
            ->setParameter('roleName', 'Instructor')
            ->setParameter('published', true)
            ->distinct() // Ensure unique users
            ->getQuery()
            ->getResult();
    }
}
