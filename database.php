<?php

use Dotenv\Dotenv;

require 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function koneksi() {
    $servername = $_ENV['DATABASE_SERVERNAME'];
    $username = $_ENV['DATABASE_USERNAME'];
    $password = $_ENV['DATABASE_PASSWORD'];
    $dbname = $_ENV['DATABASE_DBNAME'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        return_json(
            false,
            "Connection failed: " . $conn->connect_error,
            [],
            400
        );
    }

    return $conn;
}


