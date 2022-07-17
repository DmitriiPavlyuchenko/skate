<?php

declare(strict_types=1);

namespace App\DTO\News;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @codeCoverageIgnore
 */
class NewsUpdateDto extends BaseNewsDto
{
    public string $title = '';

    public string $description = '';

    public string $text = '';

    /**
     * @Assert\NotBlank
     */
    private string $uuid;

    /**
     * @Assert\Expression(
     *     expression="this.title != '' || this.text != '' || this.description != ''",
     *     message="At least one of the fields must be filled"
     *	 )
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }
}
