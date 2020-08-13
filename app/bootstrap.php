<?php
declare(strict_types=1);

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

$config = new Config\App\AppConfig();
$apiCredentials = $config->getApiCredentials();