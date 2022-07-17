<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\News\NewsCreateDto;
use App\DTO\News\NewsUpdateDto;
use App\Entity\Image;
use App\Interface\NewsServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\News as NewsEntity;
use LogicException;

/**
 * @codeCoverageIgnore
 */
class News implements NewsServiceInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(NewsCreateDto $newsCreateDto): NewsEntity
    {
        $news = new NewsEntity(
            $newsCreateDto->getTitle(),
            $newsCreateDto->getDescription(),
            $newsCreateDto->getText()
        );
        foreach ($newsCreateDto->getPhotoUuids() as $uuid) {
            $image = $this->entityManager->getRepository(Image::class)->findOneBy(['uuid' => $uuid]);
            if (null !== $image) {
                $news->addPhoto($image);
            }
        }

        $this->entityManager->persist($news);
        $this->entityManager->flush();
        $this->entityManager->refresh($news);

        return $news;
    }

    public function update(NewsUpdateDto $newsUpdateDto): NewsEntity
    {
        /** @var NewsEntity $news */
        $news = $this->entityManager->getRepository(NewsEntity::class)->findOneBy(['uuid' => $newsUpdateDto->getUuid()]);

        if ($newsUpdateDto->getTitle() !== $news->getTitle()) {
            $news->setTitle($newsUpdateDto->getTitle());
        }
        if ($newsUpdateDto->getDescription() !== $news->getDescription()) {
            $news->setDescription($newsUpdateDto->getDescription());
        }
        if ($newsUpdateDto->getDescription() !== $news->getText()) {
            $news->setText($newsUpdateDto->getText());
        }
        $news->clearPhoto();
        foreach ($newsUpdateDto->getPhotoUuids() as $uuid) {
            $image = $this->entityManager->getRepository(Image::class)->findOneBy(['uuid' => $uuid]);
            if (null !== $image) {
                $news->addPhoto($image);
            }
        }

        $this->entityManager->persist($news);
        $this->entityManager->flush();

        return $news;
    }

    public function delete(string $uuid): void
    {
        $news = $this->entityManager->getRepository(NewsEntity::class)->findOneBy(['uuid' => $uuid]);
        if (null === $news) {
            throw new LogicException('entity not found');
        }
        $this->entityManager->remove($news);
        $this->entityManager->flush();
    }
}
