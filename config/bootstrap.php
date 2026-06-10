<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

$_SERVER['APP_ENV'] ??= 'dev';
$_SERVER['APP_DEBUG'] ??= $_SERVER['APP_ENV'] !== 'prod';

if (!class_exists(Dotenv::class)) {
    throw new LogicException('Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.');
}

(new Dotenv())->usePutenv()->bootEnv(dirname(__DIR__).'/.env');
