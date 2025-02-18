<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $content;

    #[ORM\Column(type: 'string', nullable: true)]
    private string $videoUrl;

    #[ORM\Column(type: 'integer')]
    private int $position; // Order in the section

    #[ORM\Column(type: 'boolean')]
    private bool $canPreview = false;

    #[ORM\Column(type: 'integer')]
    private int $videoLength = 0;

    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private Section $section;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getVideoUrl(): string
    {
        return $this->videoUrl;
    }

    public function setVideoUrl(string $videoUrl): void
    {
        $this->videoUrl = $videoUrl;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function getSection(): Section
    {
        return $this->section;
    }

    public function setSection(Section $section): void
    {
        $this->section = $section;
    }

    public function getCourse(): Course
    {
        return $this->section->getCourse();
    }

    public function canPreview(): bool
    {
        return $this->canPreview;
    }

    public function setCanPreview(bool $canPreview): void
    {
        $this->canPreview = $canPreview;
    }

    public function getVideoLength(): int
    {
        return $this->videoLength;
    }

    public function setVideoLength(int $videoLength): void
    {
        $this->videoLength = $videoLength;
    }
}



