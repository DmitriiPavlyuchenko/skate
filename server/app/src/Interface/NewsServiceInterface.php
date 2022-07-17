<?php

declare(strict_types=1);

namespace App\Interface;

use App\DTO\News\NewsCreateDto;
use App\DTO\News\NewsUpdateDto;
use App\Entity\News;

/**
 * @codeCoverageIgnore
 */
interface NewsServiceInterface
{
    public function create(NewsCreateDto $newsCreateDto): News;

    public function update(NewsUpdateDto $newsUpdateDto): News;

    public function delete(string $uuid): void;
}
