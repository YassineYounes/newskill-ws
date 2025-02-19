<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $shortDescription;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\Column(type: 'boolean')]
    private bool $isPublished = false;

    #[ORM\Column(type: "string", nullable: true)]
    private ?string $thumbnail = null;

    #[ORM\Column(type: "json", nullable: true)]
    private ?array $requirements = [];

    #[ORM\Column(type: "json", nullable: true)]
    private ?array $skills = [];

    #[ORM\Column(type: "boolean", nullable: false)]
    private bool $certified = false;

    #[ORM\Column(type: "boolean", nullable: false)]
    private bool $onSale = false;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $salePercentage;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    private DateTime $updatedAt;

    #[ORM\Column(type: "decimal", precision: 3, scale: 1, nullable: true)]
    private ?float $rating;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $createdBy;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $updatedBy;

    #[ORM\ManyToOne(targetEntity: Level::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Level $level;

    #[ORM\ManyToMany(targetEntity: Topic::class, mappedBy: 'courses')]
    private Collection $topics;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $instructor;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'courses')]
    #[ORM\JoinTable(name: 'student_courses')]
    private Collection $students;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Category $category;

    #[ORM\OneToMany(targetEntity: Section::class, mappedBy: 'course', cascade: ['persist', 'remove'])]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $sections;

    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'course', cascade: ['persist', 'remove'])]
    #[ORM\OrderBy(['createdAt' => 'ASC'])]
    private Collection $reviews;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): void
    {
        $this->isPublished = $isPublished;
    }

    public function getInstructor(): User
    {
        return $this->instructor;
    }

    public function setInstructor(User $instructor): void
    {
        $this->instructor = $instructor;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function setSections(Collection $sections): void
    {
        $this->sections = $sections;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    public function getLevel(): Level
    {
        return $this->level;
    }

    public function setLevel(Level $level): void
    {
        $this->level = $level;
    }

    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function setTopics(Collection $topics): void
    {
        $this->topics = $topics;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(User $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getUpdatedBy(): User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(User $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    public function isCertified(): bool
    {
        return $this->certified;
    }

    public function setCertified(bool $certified): void
    {
        $this->certified = $certified;
    }

    public function isOnSale(): bool
    {
        return $this->onSale;
    }

    public function setOnSale(bool $onSale): void
    {
        $this->onSale = $onSale;
    }

    public function getSalePercentage(): ?int
    {
        return $this->salePercentage;
    }

    public function setSalePercentage(?int $salePercentage): void
    {
        $this->salePercentage = $salePercentage;
    }

    public function getRequirements(): ?array
    {
        return $this->requirements;
    }

    public function setRequirements(?array $requirements): void
    {
        $this->requirements = $requirements;
    }

    public function getSkills(): ?array
    {
        return $this->skills;
    }

    public function setSkills(?array $skills): void
    {
        $this->skills = $skills;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): void
    {
        $this->rating = $rating;
    }

    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function setStudents(Collection $students): void
    {
        $this->students = $students;
    }

    public function getNumberOfLessons(): int
    {
        $numberOfLessons = 0;
        /** @var Section $section */
        foreach ($this->sections as $section) {
            $numberOfLessons+= $section->getNumberOfLessons();
        }
        return $numberOfLessons;
    }

    public function getCourseLength(): int
    {
        $length = 0;
        /** @var Section $section */
        foreach ($this->sections as $section) {
            $length+= $section->getSectionLength();
        }
        return $length;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function setReviews(Collection $reviews): void
    {
        $this->reviews = $reviews;
    }

}




