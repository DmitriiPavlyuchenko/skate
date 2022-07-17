<?php

declare(strict_types=1);

namespace App\DTO\News;

/**
 * @codeCoverageIgnore
 */
abstract class BaseNewsDto
{
    protected string $title;

    protected string $description;

    protected string $text;

    /**
     * @var string[]
     */
    protected array $photoUuids;

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

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string[]
     */
    public function getPhotoUuids(): array
    {
        return $this->photoUuids;
    }

    /**
     * @param string[] $photoUuids
     */
    public function setPhotoUuids(array $photoUuids): void
    {
        $this->photoUuids = $photoUuids;
    }
}
