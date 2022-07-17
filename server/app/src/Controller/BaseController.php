<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Route("/api")
 * @codeCoverageIgnore
 */
class BaseController extends AbstractController
{
    protected function validateUuid(string $uuid): void
    {
        if (!Uuid::isValid($uuid)) {
            throw new BadRequestHttpException('invalid uuid');
        }
    }

    protected function badRequest(ConstraintViolationListInterface $violations): JsonResponse
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $errorMessages = [];
        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            if (!str_contains($violation->getPropertyPath(), '[')
                && !str_contains($violation->getPropertyPath(), ']')
            ) {
                $accessor->setValue($errorMessages, "[{$violation->getPropertyPath()}]", $violation->getMessage());
                continue;
            }
            $accessor->setValue($errorMessages, $violation->getPropertyPath(), $violation->getMessage());
        }

        return new JsonResponse(
            [
                'errors' => $errorMessages,
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
