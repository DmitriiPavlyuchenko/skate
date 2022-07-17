<?php

declare(strict_types=1);

namespace App\Normalizer;

use App\Entity\User;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Uid\Uuid;

class UserNormalizer implements NormalizerInterface
{
    /**
     * @param User $object
     * @param string|null $format
     * @param string[] $context
     * @return string[]
     *
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        if (!$object instanceof User) {
            throw new LogicException('Invalid entity type: ' . get_class($object));
        }
        /** @var Uuid $uuid */
        $uuid = $object->getUuid();
        /** @var string $email */
        $email = $object->getEmail();
        $data['uuid'] = $uuid->jsonSerialize();
        $data['email'] = $email;

        return $data;
    }

    public function supportsNormalization($data, string $format = null): bool
    {
        return $data instanceof User;
    }
}
