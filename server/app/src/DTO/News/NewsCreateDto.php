<?php

declare(strict_types=1);

namespace App\DTO\News;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @codeCoverageIgnore
 */
class NewsCreateDto extends BaseNewsDto
{
    /**
     * @Assert\NotBlank
     */
    protected string $title;

    /**
     * @Assert\NotBlank
     */
    protected string $text;

    /**
     * @Assert\NotBlank
     */
    protected string $description;
}
