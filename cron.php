<?php

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method:POST');
header('Content-Type: application/json');

include 'vendor/autoload.php';

use Firebase\JWT\JWT;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $allheaders = getallheaders();
    var_dump($allheaders);
    die();
} else {
    echo 'null';
}