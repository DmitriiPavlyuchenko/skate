<?php

declare(strict_types=1);

namespace App\Tests\Functional\Tools;

use App\Entity\User;
use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HttpClient extends WebTestCase
{
    /**
     * @throws JsonException
     */
    public static function createClientAuthByUser(User $user): KernelBrowser
    {
        self::ensureKernelShutdown();
        $client = self::createClient();

        $client->request(
            'POST',
            '/api/auth/sign_in',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $user->getEmail(),
                'password' => $user->getPassword()
            ], JSON_THROW_ON_ERROR)
        );
        /** @var string $json */
        $json = $client->getResponse()->getContent();
        $response = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $response['token']));

        return $client;
    }
}
