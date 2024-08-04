<?php

include './vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo $_ENV['GITHUB_CLIENT_ID'];