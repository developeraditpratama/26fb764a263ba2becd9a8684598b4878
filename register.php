<?php

//    add headers

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Method:POST');
header('Content-Type:application/json');
include './BaseController.php';

$conn = koneksi();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = json_decode(file_get_contents("php://input", true));

    $name = htmlentities($data->name);
    $email = htmlentities($data->email);
    $password = htmlentities($data->password);
    $new_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    $is_email = $result->fetch_assoc();

    if (isset($is_email['email']) == $email) {
        return_json(
            false,
            'Email sudah terdaftar',
            [],
            400
        );
    } else{
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$new_password')";

        $result = $conn->query($sql);

        if ($result) {
            return_json(
                true,
                'User add Successfully',
                [],
                200
            );
        } else {
            return_json(
                false,
                'Internal Server Error',
                [],
                500
            );
        }

        $conn->close();
    }

} else {
    return_json(
        false,
        'Method Not Allowed',
        [],
        400
    );
}
