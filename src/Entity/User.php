<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', unique: true)]
    private string $email;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $firstName;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $lastName;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $website;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $twitter;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $instagram;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $facebook;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $tiktok;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $youtube;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $linkedin;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $updatedAt;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $userName;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $phoneNumber;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $bio;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $avatar;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $title;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $abv;

    #[ORM\Column(type: "decimal", precision: 3, scale: 1, nullable: true)]
    private ?float $rating;

    #[ORM\ManyToMany(targetEntity: Role::class, inversedBy: 'users')]
    #[ORM\JoinTable(name: 'user_roles')]
    private Collection $roles;

    #[ORM\OneToMany(targetEntity: Enrollment::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private Collection $enrollments;

    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: 'instructor')]
    private Collection $teachingCourses;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setRoles(Collection $roles): void
    {
        $this->roles = $roles;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName): void
    {
        $this->userName = $userName;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): void
    {
        $this->bio = $bio;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles->map(fn($role) => $role->getName())->toArray();
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }
        return $this;
    }

    public function removeRole(Role $role): self
    {
        $this->roles->removeElement($role);
        return $this;
    }

    public function getFullName(): string
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function getTeachingCourses(): Collection
    {
        return $this->teachingCourses;
    }

    public function setTeachingCourses(Collection $teachingCourses): void
    {
        $this->teachingCourses = $teachingCourses;
    }

    public function getEnrollments(): Collection
    {
        return $this->enrollments;
    }

    public function setEnrollments(Collection $enrollments): void
    {
        $this->enrollments = $enrollments;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): void
    {
        $this->website = $website;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): void
    {
        $this->twitter = $twitter;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): void
    {
        $this->instagram = $instagram;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): void
    {
        $this->facebook = $facebook;
    }

    public function getTiktok(): ?string
    {
        return $this->tiktok;
    }

    public function setTiktok(?string $tiktok): void
    {
        $this->tiktok = $tiktok;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): void
    {
        $this->youtube = $youtube;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): void
    {
        $this->linkedin = $linkedin;
    }

    public function getAbv(): ?string
    {
        return $this->abv;
    }

    public function setAbv(?string $abv): void
    {
        $this->abv = $abv;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): void
    {
        $this->rating = $rating;
    }

    public function getTeachingCoursesCount(): ?int
    {
        return count($this->teachingCourses);
    }

    public function getTeachingLessonsCount(): ?int
    {
        $lessons = 0;
        /** @var Course $course */
        foreach ($this->teachingCourses as $course) {
            $lessons += $course->getNumberOfLessons();
        }
        return $lessons;
    }

    public function getEnrollmentCount(): ?int
    {
        $students = 0;
        /** @var Course $course */
        foreach ($this->teachingCourses as $course) {
            $students += count($course->getEnrollments());
        }
        return $students;
    }

}
