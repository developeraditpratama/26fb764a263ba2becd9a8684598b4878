<?php

header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'BaseController.php';

function sendEmail() {
    $conn = koneksi();

    $sql = "SELECT * FROM email_queue WHERE status='pending'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $rows = $result->fetch_all();
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $_ENV['HOST_EMAIL'];
        $mail->SMTPAuth = $_ENV['SMTPAUTH_EMAIL'];
        $mail->Username = $_ENV['USERNAME_EMAIL'];
        $mail->Password = $_ENV['PASSWORD_EMAIL'];
        $mail->SMTPSecure = $_ENV['SMTPSECURE_EMAIL'];
        $mail->Port = $_ENV['PORT_EMAIL'];

        foreach ($rows as $row) {

            $mail->setFrom($_ENV['USERNAME_EMAIL'], 'Levart Code Challage');
            $mail->addAddress($row[1]);
            $mail->Subject = $row[2];
            $mail->Body = $row[3];

            try {

                $mail->send();

                $date = date('Y-m-d H:i:s');
                $id = $row[0];
                $sql = "UPDATE email_queue SET status='sent', sent_at='$date' WHERE id='$id'";
                $conn->query($sql);

            } catch (Exception $e) {

                $sql = "UPDATE email_queue SET status='failed', sent_at='$date' WHERE id='$id'";
                $conn->query($sql);
            }
        }
    }

    $conn->close();

}

print ('Cron Running');

sendEmail();

print ('Cron End');