<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "categories")]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 100, unique: true)]
    private string $name;

    #[ORM\ManyToMany(targetEntity: Course::class, mappedBy: 'categories')]
    private Collection $courses;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function setCourses(Collection $courses): void
    {
        $this->courses = $courses;
    }
}





