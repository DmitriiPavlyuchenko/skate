<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Image;
use App\Normalizer\ImageNormalizer;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class ImageController extends BaseController
{
    /**
     * @Route("/images", methods={"POST"})
     * @throws ExceptionInterface
     */
    public function createImage(
        Request $request,
        EntityManagerInterface $entityManager,
        ImageNormalizer $normalizer
    ): JsonResponse {
        /** @var UploadedFile|null $uploadedFile */
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        if (!$this->isEnabledType($uploadedFile)) {
            throw new BadRequestHttpException('"file" type must be one of: PNG, JPEG');
        }

        $image = new Image(
            $uploadedFile,
            $uploadedFile->getFilename(),
            $uploadedFile->getSize()
        );

        $entityManager->persist($image);
        $entityManager->flush();

        return new JsonResponse($normalizer->normalize($image), Response::HTTP_CREATED);
    }

    /**
     * @Route("/images/{uuid}", methods={"GET"})
     * @throws ExceptionInterface
     */
    public function entity(string $uuid, ImageRepository $imageRepository, ImageNormalizer $normalizer): Response
    {
        $this->validateUuid($uuid);
        $image = $imageRepository->findOneBy(['uuid' => $uuid]);
        if (null === $image) {
            throw new NotFoundHttpException();
        }
        return new JsonResponse($normalizer->normalize($image, 'json'));
    }

    private function isEnabledType(UploadedFile $uploadedFile): bool
    {
        $mimeType = $uploadedFile->getClientMimeType();
        $extension = strtolower($uploadedFile->getClientOriginalExtension());

        return in_array($mimeType, ['image/png', 'image/jpeg'], true) && in_array($extension, ['jpg', 'jpeg', 'png'], true);
    }
}
