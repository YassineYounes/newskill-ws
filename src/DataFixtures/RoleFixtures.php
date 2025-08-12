<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create Student role
        $studentRole = new Role();
        $studentRole->setName('Student');
        $manager->persist($studentRole);

        // Create Instructor role
        $instructorRole = new Role();
        $instructorRole->setName('Instructor');
        $manager->persist($instructorRole);

        // Create Admin role (for future use)
        $adminRole = new Role();
        $adminRole->setName('Admin');
        $manager->persist($adminRole);

        $manager->flush();
    }
}