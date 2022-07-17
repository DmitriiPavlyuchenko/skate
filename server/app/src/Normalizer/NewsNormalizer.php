<?php

declare(strict_types=1);

namespace App\Normalizer;

use App\Entity\News;
use LogicException;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @codeCoverageIgnore
 */
class NewsNormalizer implements NormalizerInterface
{
    private ObjectNormalizer $objectNormalizer;
    private ImageNormalizer $imageNormalizer;

    public function __construct(
        ObjectNormalizer $objectNormalizer,
        ImageNormalizer $imageNormalizer
    ) {
        $this->objectNormalizer = $objectNormalizer;
        $this->imageNormalizer = $imageNormalizer;
        $this->objectNormalizer->setSerializer(new Serializer(
            [
            new ArrayDenormalizer(),
            new ObjectNormalizer(null, null, null, new ReflectionExtractor()),
        ],
            [new JsonEncoder()]
        ));
    }

    /**
     * @param News $object
     * @param string|null $format
     * @param string[] $context
     * @return string[]
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        if (!$object instanceof News) {
            throw new LogicException('Invalid entity type: ' . get_class($object));
        }
        $photo = $object->getPhoto();
        $object->clearPhoto();
        /** @var string[] $data */
        $data = $this->objectNormalizer->normalize($object);
        $data['uuid'] = $object->getUuid()->jsonSerialize();
        $data['createdAt'] = $object->getCreatedAt()->format('Y-m-d');
        $data['photo'] = [];
        foreach ($photo as $image) {
            $data['photo'][] = $this->imageNormalizer->normalize($image);
        }

        return $data;
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof News;
    }
}
