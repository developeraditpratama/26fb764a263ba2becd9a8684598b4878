<?php
header('Content-Type: application/json');

require 'database.php';

use Firebase\JWT\JWT;

$conn = koneksi();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $email = $data['email'];
    $password = $data['password'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

    if (!empty($email) && !empty($password)) {

        // Query database untuk memeriksa kredensial
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // Generate JWT
                $key = $_ENV['JWT_TOKEN'];
                $payload = array(
                    "iss" => "your_app",
                    "aud" => "your_app",
                    "iat" => time(),
                    "exp" => time() + 3600,
                    "data" => array(
                        "id" => $row['id'],
                        "email" => $row['email']
                    )
                );
                $jwt = JWT::encode($payload, $key, 'HS256');

                // Return JWT
                return_json(
                    true,
                    'Login Succesfully',
                    [
                        'token' => $jwt
                    ],
                    200
                );
            } else {
                return_json(
                    false,
                    'Invalid credentials',
                    [],
                    400
                );
            }
        } else {
            return_json(
                false,
                'User not found',
                [],
                400
            );
        }
    } else {
        return_json(
            false,
            'Username atau Password Tidak Boleh Kosong',
            [],
            400
        );
    }

} else {
    return_json(
        false,
        'Method Not Allowed',
        [],
        400
    );
}
