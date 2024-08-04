<?php
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require 'vendor/autoload.php';
require 'BaseController.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$conn = koneksi();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = getBearerTokenFromRequest();
    if ($token) {
        $decoded = verifyToken($token);

        if ($decoded) {
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['email'])) {

                $cron = isset($data['cron']) ?? 0;
                $subject = 'Email Test';
                $body = 'Ini adalah isi email yang dikirim menggunakan PHPMailer.';
                $email = $data['email'];

                if ($cron) {
                    $sql = "INSERT INTO email_queue (email, subject, body) VALUES ('$email', '$subject', '$body')";

                    $result = $conn->query($sql);

                    $conn->close();

                    return_json(
                        true,
                        'Email has been added into queue table',
                        [],
                        200
                    );

                } else {

                    sendEmail($data['email'], $subject, $body);
                }

            } else {
                return_json(
                    false,
                    "Email Tidak Boleh Kosong",
                    [],
                    401
                );
            }
        } else {
            return_json(
                false,
                'Invalid token',
                [],
                400
            );
        }
    } else {
        return_json(
            false,
            "Unauthorized",
            [],
            401
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

function sendEmail($sent, $subject, $body) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $_ENV['HOST_EMAIL'];
    $mail->SMTPAuth = $_ENV['SMTPAUTH_EMAIL'];
    $mail->Username = $_ENV['USERNAME_EMAIL'];
    $mail->Password = $_ENV['PASSWORD_EMAIL'];
    $mail->SMTPSecure = $_ENV['SMTPSECURE_EMAIL'];
    $mail->Port = $_ENV['PORT_EMAIL'];

    $mail->setFrom($_ENV['USERNAME_EMAIL'], 'Levart Code Challage');
    $mail->addAddress($sent);
    $mail->Subject = $subject;
    $mail->Body = $body;

    try {
        $mail->send();
        return_json(
            true,
            'Email has been sent',
            [],
            200
        );
    } catch (Exception $e) {
        return_json(
            false,
            "Message could not be sent. Mailer Error: {$mail->ErrorInfo}",
            [],
            400
        );
    }
}