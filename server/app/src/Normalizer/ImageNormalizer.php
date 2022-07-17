<?php

declare(strict_types=1);

namespace App\Normalizer;

use App\Entity\Image;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @codeCoverageIgnore
 */
class ImageNormalizer implements NormalizerInterface
{
    /**
     * @param Image $object
     * @param string|null $format
     * @param string[] $context
     * @return string[]
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        if (!$object instanceof Image) {
            throw new LogicException('Invalid entity type: ' . get_class($object));
        }
        $data['imageName'] = $object->getImageName();
        $data['uuid'] = $object->getUuid()->jsonSerialize();
        $data['createdAt'] = $object->getCreatedAt()->format('Y-m-d H:i:s');
        $data['updatedAt'] = $object->getUpdatedAt()->format('Y-m-d H:i:s');

        return $data;
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof Image;
    }
}
