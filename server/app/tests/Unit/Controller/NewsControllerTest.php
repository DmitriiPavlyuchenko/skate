<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller;

use App\Controller\NewsController;
use App\Entity\Image;
use App\Entity\News;
use App\Interface\NewsServiceInterface;
use App\Normalizer\ImageNormalizer;
use App\Normalizer\NewsNormalizer;
use App\Repository\NewsRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validation;
use App\Service\News as NewsService;

class NewsControllerTest extends KernelTestCase
{
    /**
     * @throws ExceptionInterface
     * @throws HttpExceptionInterface
     * @throws JsonException
     * @covers \App\Controller\NewsController::create
     */
    public function testCreate(): void
    {
        $uuid = Uuid::v4();
        $createdAt = new DateTimeImmutable();
        $data = [];

        try {
            $this->create($uuid, $data);
        } catch (HttpException $exception) {
            self::assertEquals(Response::HTTP_FORBIDDEN, $exception->getStatusCode());
        }

        $response = $this->create($uuid, [], true);
        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());

        $data = ['title' => 'title', 'description' => 'desc', 'text' => 'text'];
        foreach ($data as $key => $value) {
            $tmp = $data;
            unset($tmp[$key]);
            $response = $this->create($uuid, $tmp, true);
            self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        }

        foreach ($data as $key => $value) {
            $tmp = $data;
            $tmp[$key] = '';
            $response = $this->create($uuid, $tmp, true);
            self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        }

        $response = $this->create($uuid, $data, true);
        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        /** @var string $json */
        $json = $response->getContent();
        $response = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        self::assertCount(6, $response);
        self::assertArrayHasKey('uuid', $response);
        self::assertArrayHasKey('title', $response);
        self::assertArrayHasKey('description', $response);
        self::assertArrayHasKey('text', $response);
        self::assertArrayHasKey('createdAt', $response);
        self::assertArrayHasKey('photo', $response);
        self::assertEquals($uuid->jsonSerialize(), $response['uuid']);
        self::assertEquals($createdAt->format('Y-m-d'), $response['createdAt']);
    }

    /**
     * @covers \App\Controller\NewsController::delete
     */
    public function testDelete(): void
    {
        $uuid = Uuid::v4();
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(NewsRepository::class);
        $repository
            ->expects($this->exactly(2))
        ->method('findOneBy')
            ->willReturn(
                $this->onConsecutiveCalls(
                    null,
                    new News(
                        'title',
                        'description',
                        'text'
                    )
                )
            );
        $entityManager->method('getRepository')->willReturn($repository);
        $service = new NewsService($entityManager);
        $normalizer = new NewsNormalizer(new ObjectNormalizer(), $this->createMock(ImageNormalizer::class));
        $security = $this->createMock(Security::class);
        $security->method('isGranted')->willReturn(true);
        $controller = new NewsController($normalizer, $service, $security);
        try {
            $controller->delete($uuid->jsonSerialize());
        } catch (NotFoundHttpException $exception) {
            self::assertEquals('entity not found', $exception->getMessage());
        }

        $response = $controller->delete($uuid->jsonSerialize());
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    /**
     * @throws ExceptionInterface
     * @throws JsonException
     * @covers \App\Controller\NewsController::entity()
     */
    public function testEntity(): void
    {
        $uuid = Uuid::v4();
        $newsService = $this->createMock(NewsServiceInterface::class);
        $repository = $this->createMock(NewsRepository::class);
        $image = new Image(new File(dirname(__DIR__) . '/../cat.jpg'), 'cat.jpg', 1);
        $repository->method('findOneBy')->willReturn(
            (new News('title', 'desc', 'text'))->setUuid($uuid)->addPhoto($image)
        );
        $newsNormalizer = new NewsNormalizer(new ObjectNormalizer(), new ImageNormalizer());
        $controller = new NewsController($newsNormalizer, $newsService, $this->createMock(Security::class));
        $response = $controller->entity($uuid->jsonSerialize(), $repository);
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        /** @var string $json */
        $json = $response->getContent();
        $decodedResponse = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        self::assertArrayHasKey('photo', $decodedResponse);
        self::assertNotEmpty($decodedResponse['photo']);

        try {
            $controller->entity('1234', $repository);
        } catch (BadRequestHttpException $exception) {
            self::assertEquals('invalid uuid', $exception->getMessage());
        }
    }

    /**
     * @throws ExceptionInterface
     * @covers \App\Controller\NewsController::list()
     */
    public function testList(): void
    {
        $newsService = $this->createMock(NewsServiceInterface::class);
        $repository = $this->createMock(NewsRepository::class);
        $repository->method('getList')->willReturn(
            [
                (new News('title', 'desc', 'text'))->setUuid(Uuid::v4()),
                (new News('title', 'desc', 'text'))->setUuid(Uuid::v4())
                ]
        );
        $newsNormalizer = new NewsNormalizer(new ObjectNormalizer(), new ImageNormalizer());
        $controller = new NewsController($newsNormalizer, $newsService, $this->createMock(Security::class));
        $response = $controller->list(new Request(), $repository);
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

//    /**
//     * @return void
//     * @covers \App\Controller\NewsController::update()
//     */
//    public function testUpdate(): void
//    {
//    }

    /**
     * @param Uuid $uuid
     * @param string[] $data
     * @return JsonResponse
     * @throws ExceptionInterface
     * @throws HttpExceptionInterface
     * @throws JsonException
     */
    private function create(
        Uuid                             $uuid,
        array                            $data,
        bool $asAdmin = false
    ): JsonResponse {
        $createdAt = new DateTimeImmutable();
        $newsService = $this->createMock(NewsServiceInterface::class);
        $newsService->method('create')->willReturn(
            (new News(
                $data['title'] ?? '',
                $data['desc'] ?? '',
                $data['text'] ?? ''
            ))
                ->setUuid($uuid)
                ->setCreatedAt($createdAt)
        );
        $security = $this->createMock(Security::class);
        $security->method('isGranted')->willReturn($asAdmin);
        $newsNormalizer = new NewsNormalizer(new ObjectNormalizer(), new ImageNormalizer());
        $controller = new NewsController($newsNormalizer, $newsService, $security);
        $request = $this->createMock(Request::class);
        $request->method('getContent')->willReturn(
            json_encode($data, JSON_THROW_ON_ERROR)
        );
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->addDefaultDoctrineAnnotationReader()->getValidator();
        return $controller->create($request, $validator);
    }
}
