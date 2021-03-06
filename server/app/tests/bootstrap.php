<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

passthru(sprintf(
    'php "%s/../bin/console" d:d:d --env=test --force --no-interaction',
    __DIR__
));
passthru(sprintf(
    'php "%s/../bin/console" d:d:c --env=test',
    __DIR__
));
passthru(sprintf(
    'php "%s/../bin/console" doctrine:m:m -n --env=test',
    __DIR__
));
