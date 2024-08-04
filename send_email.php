<?php

header('Content-Type: application/json; charset=utf-8');
include './vendor/autoload.php';
require_once('BaseController.php');

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'https://github.com/login/oauth/authorize');
} else {
    return_json(
        false,
        'Method Not Allowed',
        [],
        400
    );
}