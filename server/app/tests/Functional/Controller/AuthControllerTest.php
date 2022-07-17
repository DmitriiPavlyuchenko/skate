<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Entity\User;
use App\Tests\Functional\AbstractFunctionalTest;
use App\Tests\Functional\Tools\HttpClient;
use Doctrine\ORM\EntityManagerInterface;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

class AuthControllerTest extends AbstractFunctionalTest
{
    /**
     * @throws JsonException
     */
    public function testSignUp(): void
    {
        self::ensureKernelShutdown();
        $client = self::createClient();
        $client->request(
            Request::METHOD_POST,
            '/api/auth/sign_up',
            [],
            [],
            [],
            json_encode(['username' => 'username', 'password' => 'password', 'email' => 'email'], JSON_THROW_ON_ERROR)
        );
        self::assertResponseIsSuccessful();
        self::assertCount(1, $this->entityManager->getRepository(User::class)->findAll());
    }

    /**
     * @depends testSignUp
     * @throws JsonException
     */
    public function testRepeatSignUp(): void
    {
        $username = 'username';
        $password = 'password';
        $email = 'email';
        $payload = ['username' => $username, 'password' => $password, 'email' => $email];
        self::ensureKernelShutdown();
        $client = self::createClient();
        $client->request(
            Request::METHOD_POST,
            '/api/auth/sign_up',
            [],
            [],
            [],
            json_encode($payload, JSON_THROW_ON_ERROR)
        );
        self::assertResponseIsSuccessful();
        self::assertCount(1, $this->entityManager->getRepository(User::class)->findAll());

        $modifiedPayload = $payload;
        $modifiedPayload['email'] = 'newEmail';
        $client->request(
            Request::METHOD_POST,
            '/api/auth/sign_up',
            [],
            [],
            [],
            json_encode($modifiedPayload, JSON_THROW_ON_ERROR)
        );
        self::assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        self::assertCount(1, $this->entityManager->getRepository(User::class)->findAll());
        /** @var string $content */
        $content = $client->getResponse()->getContent();
        $response = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        self::assertArrayHasKey('errors', $response);
        self::assertEquals('username already in use', $response['errors'][0]);

        $modifiedPayload = $payload;
        $modifiedPayload['username'] = 'newUsername';
        $client->request(
            Request::METHOD_POST,
            '/api/auth/sign_up',
            [],
            [],
            [],
            json_encode($modifiedPayload, JSON_THROW_ON_ERROR)
        );
        self::assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        self::assertCount(1, $this->entityManager->getRepository(User::class)->findAll());
        /** @var string $content */
        $content = $client->getResponse()->getContent();
        $response = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        self::assertArrayHasKey('errors', $response);
        self::assertEquals('email already in use', $response['errors'][0]);
    }

    /**
     * @depends testRepeatSignUp
     * @throws JsonException
     */
    public function testSignIn(): void
    {
        $user = (new User())
            ->setEmail('email')
            ->setPassword('password')
            ->setUsername('username');
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $client = HttpClient::createClientAuthByUser($user);
        $client->request(
            'POST',
            '/api/auth/sign_in',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'email',
                'password' => 'password'
            ], JSON_THROW_ON_ERROR)
        );
        self::assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        /** @var string $json */
        $json = $client->getResponse()->getContent();
        $response = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        self::assertArrayHasKey('token', $response);
        self::assertArrayHasKey('refresh_token', $response);
    }
}
