<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

require 'vendor/autoload.php';

include 'database.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function verifyToken($token) {
    try {
        $decoded = JWT::decode($token, new Key($_ENV['JWT_TOKEN'], 'HS256'));
        return $decoded;
    } catch (Exception $e) {
        return false;
    }
}

function getBearerTokenFromRequest() {
    $headers = getallheaders();
    if (!empty($headers['Authorization'])) {
        if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function return_json($status, $message, $data, $code) {
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
    http_response_code($code);
}

function myErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "<b>Error:</b> [$errno] $errstr in $errfile on line $errline";
}
