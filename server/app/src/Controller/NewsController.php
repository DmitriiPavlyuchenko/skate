<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\News\NewsCreateDto;
use App\DTO\News\NewsUpdateDto;
use App\Enum\UserRole;
use App\Interface\NewsServiceInterface;
use App\Normalizer\NewsNormalizer;
use App\Repository\NewsRepository;
use App\Trait\Controller\Pagination;
use HttpException;
use LogicException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class NewsController extends BaseController
{
    use Pagination;
    private NewsNormalizer $normalizer;
    private NewsServiceInterface $newsService;
    private Security $security;

    public function __construct(
        NewsNormalizer $newsNormalizer,
        NewsServiceInterface $newsService,
        Security $security
    ) {
        $this->normalizer = $newsNormalizer;
        $this->security = $security;
        $this->newsService = $newsService;
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/news', name: 'news', methods: [Request::METHOD_GET])]
    public function list(Request $request, NewsRepository $newsRepository): Response
    {
        $news = $newsRepository->getList($this->getOffset($request), $this->getLimit($request));
        $response = [];
        foreach ($news as $newsEntity) {
            $response[] = $this->normalizer->normalize($newsEntity, 'json');
        }

        return new JsonResponse($response);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/news/{uuid}', name: 'news_entity', methods: [Request::METHOD_GET])]
    public function entity(string $uuid, NewsRepository $newsRepository): Response
    {
        $this->validateUuid($uuid);
        $news = $newsRepository->findOneBy(['uuid' => $uuid]);
        if (null === $news) {
            throw new NotFoundHttpException();
        }
        return new JsonResponse($this->normalizer->normalize($news, 'json'));
    }

    /**
     * @throws ExceptionInterface
     * @throws HttpExceptionInterface
     */
    #[Route('/news', name: 'news_create', methods: [Request::METHOD_POST])]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        if (!$this->security->isGranted(UserRole::ROLE_ADMIN)) {
            throw new AccessDeniedHttpException();
        }

        $rawData = $request->getContent();

        if (!$rawData) {
            throw new BadRequestHttpException("request is empty");
        }

        $newsCreateDto = $this->createSerializer()->deserialize($rawData, NewsCreateDto::class, 'json');
        $violations = $validator->validate($newsCreateDto);
        if ($violations->count() > 0) {
            return $this->badRequest($violations);
        }
        $news = $this->newsService->create($newsCreateDto);

        return new JsonResponse(
            $this->normalizer->normalize($news, 'json'),
            Response::HTTP_CREATED
        );
    }

    #[Route('/news/{uuid}', name: 'news_edit', methods: [Request::METHOD_PUT])]
    public function update(string $uuid, Request $request, ValidatorInterface $validator): JsonResponse
    {
        if (!$this->security->isGranted(UserRole::ROLE_ADMIN)) {
            throw new AccessDeniedHttpException();
        }
        $this->validateUuid($uuid);
        $rawData = $request->getContent();

        if (!$rawData) {
            throw new BadRequestHttpException("request is empty");
        }

        /** @var NewsUpdateDto $newsUpdateDto */
        $newsUpdateDto = $this->createSerializer()->deserialize($rawData, NewsUpdateDto::class, 'json');
        $newsUpdateDto->setUuid($uuid);
        $violations = $validator->validate($newsUpdateDto);
        if ($violations->count() > 0) {
            return $this->badRequest($violations);
        }
        $news = $this->newsService->update($newsUpdateDto);

        return new JsonResponse(
            $this->normalizer->normalize($news, 'json'),
            Response::HTTP_CREATED
        );
    }

    #[Route('/news/{uuid}', name: 'news_delete', methods: [Request::METHOD_DELETE])]
    public function delete(string $uuid): JsonResponse
    {
        if (!$this->security->isGranted(UserRole::ROLE_ADMIN)) {
            throw new AccessDeniedHttpException();
        }
        $this->validateUuid($uuid);
        try {
            $this->newsService->delete($uuid);
        } catch (LogicException $exception) {
            throw new NotFoundHttpException($exception->getMessage());
        }

        return new JsonResponse([], Response::HTTP_OK);
    }

    private function createSerializer(): SerializerInterface
    {
        return new Serializer(
            [
                new ArrayDenormalizer(),
                new ObjectNormalizer(null, null, null, new ReflectionExtractor()),
            ],
            [new JsonEncoder()]
        );
    }
}
