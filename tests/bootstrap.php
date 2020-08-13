<?php
declare(strict_types=1);

error_reporting(E_ALL | E_STRICT);

require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();